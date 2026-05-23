package handlers

import (
	"web-pendaftaran-tkaqila/database"
	"web-pendaftaran-tkaqila/models"

	"github.com/gofiber/fiber/v2"
)

// CreatePendaftaran handles the submission of a new registration
func CreatePendaftaran(c *fiber.Ctx) error {
	var input models.Pendaftaran
	if err := c.BodyParser(&input); err != nil {
		return c.Status(fiber.StatusBadRequest).JSON(fiber.Map{
			"status":  "error",
			"message": "Data tidak valid",
		})
	}

	// Validate required fields
	if input.NamaAnak == "" || input.NamaOrangTua == "" || input.NoHp == "" {
		return c.Status(fiber.StatusBadRequest).JSON(fiber.Map{
			"status":  "error",
			"message": "Data wajib (Nama Anak, Orang Tua, No HP) harus diisi",
		})
	}

	input.StatusPendaftaran = "pending"

	db, _ := database.ConnectDB()
	if err := db.Create(&input).Error; err != nil {
		return c.Status(fiber.StatusInternalServerError).JSON(fiber.Map{
			"status":  "error",
			"message": "Gagal menyimpan pendaftaran",
		})
	}

	return c.Status(fiber.StatusCreated).JSON(fiber.Map{
		"status":  "success",
		"message": "Pendaftaran berhasil dikirim",
		"data":    input,
	})
}

// GetAllPendaftaran retrieves all registrations
func GetAllPendaftaran(c *fiber.Ctx) error {
	db, _ := database.ConnectDB()
	var pendaftaran []models.Pendaftaran
	
	db.Order("created_at desc").Find(&pendaftaran)

	return c.JSON(fiber.Map{
		"status": "success",
		"data":   pendaftaran,
	})
}

// GetPendaftaran retrieves a single registration by ID
func GetPendaftaran(c *fiber.Ctx) error {
	id := c.Params("id")
	db, _ := database.ConnectDB()
	var pendaftaran models.Pendaftaran

	if err := db.First(&pendaftaran, id).Error; err != nil {
		return c.Status(fiber.StatusNotFound).JSON(fiber.Map{
			"status":  "error",
			"message": "Data pendaftar tidak ditemukan",
		})
	}

	return c.JSON(fiber.Map{
		"status": "success",
		"data":   pendaftaran,
	})
}

// UpdateStatusPendaftaran updates the status of a registration
func UpdateStatusPendaftaran(c *fiber.Ctx) error {
	id := c.Params("id")
	db, _ := database.ConnectDB()
	var pendaftaran models.Pendaftaran

	if err := db.First(&pendaftaran, id).Error; err != nil {
		return c.Status(fiber.StatusNotFound).JSON(fiber.Map{
			"status":  "error",
			"message": "Data pendaftar tidak ditemukan",
		})
	}

	var input struct {
		StatusPendaftaran string `json:"status_pendaftaran"`
		Catatan           string `json:"catatan"`
	}

	if err := c.BodyParser(&input); err != nil {
		return c.Status(fiber.StatusBadRequest).JSON(fiber.Map{
			"status":  "error",
			"message": "Data tidak valid",
		})
	}

	updates := map[string]interface{}{
		"status_pendaftaran": input.StatusPendaftaran,
	}
	
	if input.Catatan != "" {
		updates["catatan"] = input.Catatan
	}

	db.Model(&pendaftaran).Updates(updates)

	return c.JSON(fiber.Map{
		"status":  "success",
		"message": "Status berhasil diperbarui",
		"data":    pendaftaran,
	})
}

// DeletePendaftaran deletes a registration
func DeletePendaftaran(c *fiber.Ctx) error {
	id := c.Params("id")
	db, _ := database.ConnectDB()
	var pendaftaran models.Pendaftaran

	if err := db.First(&pendaftaran, id).Error; err != nil {
		return c.Status(fiber.StatusNotFound).JSON(fiber.Map{
			"status":  "error",
			"message": "Data pendaftar tidak ditemukan",
		})
	}

	db.Delete(&pendaftaran)

	return c.JSON(fiber.Map{
		"status":  "success",
		"message": "Data pendaftar berhasil dihapus",
	})
}
