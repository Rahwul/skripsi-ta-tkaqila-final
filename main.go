package main

import (
	"log"
	"os"

	"web-pendaftaran-tkaqila/database"
	"web-pendaftaran-tkaqila/handlers"
	"web-pendaftaran-tkaqila/middleware"
	"web-pendaftaran-tkaqila/models"

	"github.com/gofiber/fiber/v2"
)

func main() {
	db, err := database.ConnectDB()
	if err != nil {
		log.Fatal(err)
	}

	if err := db.AutoMigrate(&models.User{}, &models.Student{}, &models.Class{}, &models.Registration{}, &models.Pendaftaran{}); err != nil {
		log.Fatal(err)
	}

	app := fiber.New()
	app.Get("/", func(c *fiber.Ctx) error { return c.SendString("TK Aqila API") })

	api := app.Group("/api")
	api.Get("/me", middleware.Protected(), handlers.Me)
	api.Get("/admin-only", middleware.Protected(), middleware.AuthorizeRoles("admin"), func(c *fiber.Ctx) error {
		return c.JSON(fiber.Map{"status": "success", "message": "admin only", "data": nil})
	})
	auth := api.Group("/auth")
	auth.Post("/register", handlers.Register)
	auth.Post("/login", handlers.Login)

	pendaftaran := api.Group("/pendaftaran")
	pendaftaran.Post("/", handlers.CreatePendaftaran)
	pendaftaran.Get("/", handlers.GetAllPendaftaran)
	pendaftaran.Get("/:id", handlers.GetPendaftaran)
	pendaftaran.Patch("/:id/status", middleware.Protected(), middleware.AuthorizeRoles("admin"), handlers.UpdateStatusPendaftaran)
	pendaftaran.Delete("/:id", middleware.Protected(), middleware.AuthorizeRoles("admin"), handlers.DeletePendaftaran)

	port := os.Getenv("PORT")
	if port == "" {
		port = "3000"
	}
	log.Fatal(app.Listen(":" + port))
}
