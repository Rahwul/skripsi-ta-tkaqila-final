package handlers

import (
	"web-pendaftaran-tkaqila/backend/middleware"
	"web-pendaftaran-tkaqila/backend/repositories"
	"web-pendaftaran-tkaqila/backend/services"
	"web-pendaftaran-tkaqila/backend/utils"

	"github.com/gofiber/fiber/v2"
)

type AuthHandler struct {
	authService *services.AuthService
	adminRepo   *repositories.AdminRepository
}

func NewAuthHandler(authService *services.AuthService, adminRepo *repositories.AdminRepository) *AuthHandler {
	return &AuthHandler{
		authService: authService,
		adminRepo:   adminRepo,
	}
}

type RegisterAdminRequest struct {
	Name     string `json:"name"`
	Email    string `json:"email"`
	Password string `json:"password"`
}

type LoginAdminRequest struct {
	Email    string `json:"email"`
	Password string `json:"password"`
}

func (h *AuthHandler) Register(c *fiber.Ctx) error {
	var body RegisterAdminRequest
	if err := c.BodyParser(&body); err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Payload tidak valid", map[string][]string{
			"body": {"format JSON tidak valid"},
		})
	}
	if body.Name == "" || body.Email == "" || body.Password == "" {
		return utils.Error(c, fiber.StatusBadRequest, "Data tidak lengkap", map[string][]string{
			"name":     {"wajib diisi"},
			"email":    {"wajib diisi"},
			"password": {"wajib diisi"},
		})
	}

	admin, err := h.authService.Register(body.Name, body.Email, body.Password)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Gagal registrasi admin", err.Error())
	}

	return utils.Created(c, "Admin berhasil diregistrasi", fiber.Map{
		"id":    admin.ID,
		"name":  admin.Name,
		"email": admin.Email,
	})
}

func (h *AuthHandler) Login(c *fiber.Ctx) error {
	var body LoginAdminRequest
	if err := c.BodyParser(&body); err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Payload tidak valid", map[string][]string{
			"body": {"format JSON tidak valid"},
		})
	}
	if body.Email == "" || body.Password == "" {
		return utils.Error(c, fiber.StatusBadRequest, "Data tidak lengkap", map[string][]string{
			"email":    {"wajib diisi"},
			"password": {"wajib diisi"},
		})
	}

	token, admin, err := h.authService.Login(body.Email, body.Password)
	if err != nil {
		return utils.Error(c, fiber.StatusUnauthorized, "Login gagal", err.Error())
	}

	return utils.Success(c, "Login berhasil", fiber.Map{
		"token": token,
		"admin": fiber.Map{
			"id":    admin.ID,
			"name":  admin.Name,
			"email": admin.Email,
		},
	})
}

func (h *AuthHandler) Profile(c *fiber.Ctx) error {
	adminIDVal := c.Locals(middleware.ContextAdminID)
	if adminIDVal == nil {
		return utils.Error(c, fiber.StatusUnauthorized, "Unauthorized", nil)
	}
	id, ok := adminIDVal.(uint)
	if !ok {
		return utils.Error(c, fiber.StatusUnauthorized, "Unauthorized", "tipe admin_id tidak valid")
	}

	admin, err := h.adminRepo.FindByID(id)
	if err != nil {
		return utils.Error(c, fiber.StatusNotFound, "Admin tidak ditemukan", err.Error())
	}

	return utils.Success(c, "Profil admin", fiber.Map{
		"id":         admin.ID,
		"name":       admin.Name,
		"email":      admin.Email,
		"created_at": admin.CreatedAt,
	})
}

