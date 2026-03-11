package routes

import (
	"web-pendaftaran-tkaqila/backend/config"
	"web-pendaftaran-tkaqila/backend/handlers"
	"web-pendaftaran-tkaqila/backend/middleware"
	"web-pendaftaran-tkaqila/backend/repositories"
	"web-pendaftaran-tkaqila/backend/services"
	"web-pendaftaran-tkaqila/backend/utils"

	"github.com/gofiber/fiber/v2"
	"gorm.io/gorm"
)

func RegisterAPIRoutes(app *fiber.App, db *gorm.DB, cfg *config.Config) {
	// repositories
	adminRepo := repositories.NewAdminRepository(db)
	pendaftaranRepo := repositories.NewPendaftaranRepository(db)
	berkasRepo := repositories.NewBerkasRepository(db)
	jadwalRepo := repositories.NewJadwalRepository(db)
	siteContentRepo := repositories.NewSiteContentRepository(db)

	// services
	authService := services.NewAuthService(cfg, adminRepo)
	pendaftaranService := services.NewPendaftaranService(pendaftaranRepo)
	berkasService := services.NewBerkasService(berkasRepo, pendaftaranRepo)
	jadwalService := services.NewJadwalService(jadwalRepo)
	laporanService := services.NewLaporanService(pendaftaranRepo)
	siteContentService := services.NewSiteContentService(siteContentRepo)

	// handlers
	authHandler := handlers.NewAuthHandler(authService, adminRepo)
	pendaftaranHandler := handlers.NewPendaftaranHandler(pendaftaranService)
	berkasHandler := handlers.NewBerkasHandler(berkasService)
	jadwalHandler := handlers.NewJadwalHandler(jadwalService)
	laporanHandler := handlers.NewLaporanHandler(laporanService)
	siteContentHandler := handlers.NewSiteContentHandler(siteContentService)

	app.Get("/", func(c *fiber.Ctx) error {
		return utils.Success(c, "TK Aqila API", fiber.Map{"status": "ok"})
	})

	api := app.Group("/api")

	// AUTH ADMIN
	admin := api.Group("/admin")
	admin.Post("/register", authHandler.Register)
	admin.Post("/login", authHandler.Login)
	admin.Get("/profile", middleware.JWTProtected(cfg), authHandler.Profile)

	// PENDAFTARAN
	api.Post("/pendaftaran", pendaftaranHandler.Create)
	apiProtected := api.Group("/pendaftaran", middleware.JWTProtected(cfg))
	apiProtected.Get("/", pendaftaranHandler.GetAll)
	apiProtected.Get("/:id", pendaftaranHandler.GetByID)
	apiProtected.Put("/:id", pendaftaranHandler.Update)
	apiProtected.Patch("/:id/status", pendaftaranHandler.UpdateStatus)
	apiProtected.Delete("/:id", pendaftaranHandler.Delete)
	apiProtected.Post("/:id/upload-berkas", berkasHandler.UploadBerkas)

	// LAPORAN
	laporanGroup := api.Group("/laporan", middleware.JWTProtected(cfg))
	laporanGroup.Get("/", laporanHandler.LaporanPeriode)

	// JADWAL
	jadwalGroup := api.Group("/jadwal", middleware.JWTProtected(cfg))
	jadwalGroup.Get("/", jadwalHandler.GetAll)
	jadwalGroup.Post("/", jadwalHandler.Create)
	jadwalGroup.Get("/:id", jadwalHandler.GetByID)
	jadwalGroup.Put("/:id", jadwalHandler.Update)
	jadwalGroup.Delete("/:id", jadwalHandler.Delete)

	// KONTEN WEBSITE
	api.Get("/site-content", siteContentHandler.GetAll)
	api.Put("/site-content", middleware.JWTProtected(cfg), siteContentHandler.UpsertMany)
}
