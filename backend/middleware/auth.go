package middleware

import (
	"strings"

	"web-pendaftaran-tkaqila/backend/config"
	"web-pendaftaran-tkaqila/backend/utils"

	"github.com/gofiber/fiber/v2"
)

const ContextAdminID = "admin_id"

func JWTProtected(cfg *config.Config) fiber.Handler {
	return func(c *fiber.Ctx) error {
		authHeader := c.Get("Authorization")
		if authHeader == "" || !strings.HasPrefix(authHeader, "Bearer ") {
			return utils.Error(c, fiber.StatusUnauthorized, "Authorization header tidak valid", nil)
		}

		tokenStr := strings.TrimSpace(strings.TrimPrefix(authHeader, "Bearer "))
		claims, err := utils.ParseAdminToken(cfg.JWTSecret, tokenStr)
		if err != nil {
			return utils.Error(c, fiber.StatusUnauthorized, "Token tidak valid", err.Error())
		}

		c.Locals(ContextAdminID, claims.AdminID)
		return c.Next()
	}
}

