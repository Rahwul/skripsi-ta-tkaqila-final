package handlers

import (
	"time"

	"os"
	"strconv"
	"web-pendaftaran-tkaqila/database"
	"web-pendaftaran-tkaqila/models"

	"github.com/gofiber/fiber/v2"
	"github.com/golang-jwt/jwt/v5"
	"golang.org/x/crypto/bcrypt"
)

type RegisterRequest struct {
	Name     string `json:"name"`
	Email    string `json:"email"`
	Password string `json:"password"`
}

type LoginRequest struct {
	Email    string `json:"email"`
	Password string `json:"password"`
}

func getEnv(key, def string) string {
	v := os.Getenv(key)
	if v == "" {
		return def
	}
	return v
}

func Register(c *fiber.Ctx) error {
	var body RegisterRequest
	if err := c.BodyParser(&body); err != nil {
		return c.Status(fiber.StatusBadRequest).JSON(fiber.Map{"status": "error", "message": "invalid payload", "data": nil})
	}
	if body.Name == "" || body.Email == "" || body.Password == "" {
		return c.Status(fiber.StatusBadRequest).JSON(fiber.Map{"status": "error", "message": "name, email, and password are required", "data": nil})
	}

	var existing models.User
	if err := database.DB.Where("email = ?", body.Email).First(&existing).Error; err == nil {
		return c.Status(fiber.StatusConflict).JSON(fiber.Map{"status": "error", "message": "email already registered", "data": nil})
	}

	hash, err := bcrypt.GenerateFromPassword([]byte(body.Password), bcrypt.DefaultCost)
	if err != nil {
		return c.Status(fiber.StatusInternalServerError).JSON(fiber.Map{"status": "error", "message": "failed to hash password", "data": nil})
	}

	user := models.User{
		Name:         body.Name,
		Email:        body.Email,
		PasswordHash: string(hash),
		Role:         "admin",
	}
	if err := database.DB.Create(&user).Error; err != nil {
		return c.Status(fiber.StatusInternalServerError).JSON(fiber.Map{"status": "error", "message": "failed to create user", "data": nil})
	}

	return c.Status(fiber.StatusCreated).JSON(fiber.Map{"status": "success", "message": "user registered", "data": fiber.Map{"id": user.ID, "name": user.Name, "email": user.Email, "role": user.Role}})
}

func Login(c *fiber.Ctx) error {
	var body LoginRequest
	if err := c.BodyParser(&body); err != nil {
		return c.Status(fiber.StatusBadRequest).JSON(fiber.Map{"status": "error", "message": "invalid payload", "data": nil})
	}
	if body.Email == "" || body.Password == "" {
		return c.Status(fiber.StatusBadRequest).JSON(fiber.Map{"status": "error", "message": "email and password are required", "data": nil})
	}

	var user models.User
	if err := database.DB.Where("email = ?", body.Email).First(&user).Error; err != nil {
		return c.Status(fiber.StatusUnauthorized).JSON(fiber.Map{"status": "error", "message": "invalid credentials", "data": nil})
	}

	if err := bcrypt.CompareHashAndPassword([]byte(user.PasswordHash), []byte(body.Password)); err != nil {
		return c.Status(fiber.StatusUnauthorized).JSON(fiber.Map{"status": "error", "message": "invalid credentials", "data": nil})
	}

	secret := getEnv("JWT_SECRET", "secret")
	token := jwt.NewWithClaims(jwt.SigningMethodHS256, jwt.MapClaims{
		"sub":   user.ID,
		"email": user.Email,
		"role":  user.Role,
		"exp":   time.Now().Add(24 * time.Hour).Unix(),
		"iat":   time.Now().Unix(),
	})
	signed, err := token.SignedString([]byte(secret))
	if err != nil {
		return c.Status(fiber.StatusInternalServerError).JSON(fiber.Map{"status": "error", "message": "failed to generate token", "data": nil})
	}

	return c.JSON(fiber.Map{"status": "success", "message": "login success", "data": fiber.Map{"token": signed}})
}

func Me(c *fiber.Ctx) error {
	v := c.Locals("claims")
	claims, ok := v.(jwt.MapClaims)
	if !ok {
		return c.Status(fiber.StatusUnauthorized).JSON(fiber.Map{"status": "error", "message": "invalid claims", "data": nil})
	}

	var uid uint
	switch id := claims["sub"].(type) {
	case float64:
		uid = uint(id)
	case int:
		uid = uint(id)
	case string:
		if parsed, err := strconv.ParseUint(id, 10, 64); err == nil {
			uid = uint(parsed)
		} else {
			return c.Status(fiber.StatusUnauthorized).JSON(fiber.Map{"status": "error", "message": "invalid subject", "data": nil})
		}
	default:
		return c.Status(fiber.StatusUnauthorized).JSON(fiber.Map{"status": "error", "message": "invalid subject", "data": nil})
	}

	var user models.User
	if err := database.DB.First(&user, uid).Error; err != nil {
		return c.Status(fiber.StatusNotFound).JSON(fiber.Map{"status": "error", "message": "user not found", "data": nil})
	}

	return c.JSON(fiber.Map{"status": "success", "message": "me", "data": fiber.Map{"id": user.ID, "name": user.Name, "email": user.Email, "role": user.Role, "created_at": user.CreatedAt, "updated_at": user.UpdatedAt}})
}
