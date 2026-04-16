package main

import (
	"log"

	"web-pendaftaran-tkaqila/backend/config"
	"web-pendaftaran-tkaqila/backend/database"
	"web-pendaftaran-tkaqila/backend/routes"

	"github.com/gofiber/fiber/v2"
	"github.com/gofiber/fiber/v2/middleware/logger"
	"github.com/gofiber/fiber/v2/middleware/recover"
)

func main() {
	cfg := config.LoadConfig()
	db := database.ConnectAndMigrate(cfg)

	app := fiber.New(fiber.Config{
		ErrorHandler: func(c *fiber.Ctx, err error) error {
			return c.Status(fiber.StatusInternalServerError).JSON(fiber.Map{
				"success": false,
				"message": "Terjadi kesalahan pada server",
				"data":    nil,
				"errors":  err.Error(),
			})
		},
	})

	app.Use(logger.New())
	app.Use(recover.New())

	routes.RegisterAPIRoutes(app, db, cfg)

	log.Printf("Server berjalan di port %s", cfg.AppPort)
	if err := app.Listen(":" + cfg.AppPort); err != nil {
		log.Fatalf("Gagal menjalankan server: %v", err)
	}
}

