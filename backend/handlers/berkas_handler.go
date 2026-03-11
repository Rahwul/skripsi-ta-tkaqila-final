package handlers

import (
	"fmt"
	"os"
	"path/filepath"
	"strconv"
	"strings"
	"time"

	"web-pendaftaran-tkaqila/backend/services"
	"web-pendaftaran-tkaqila/backend/utils"

	"github.com/gofiber/fiber/v2"
)

type BerkasHandler struct {
	service *services.BerkasService
}

func NewBerkasHandler(service *services.BerkasService) *BerkasHandler {
	return &BerkasHandler{service: service}
}

func (h *BerkasHandler) UploadBerkas(c *fiber.Ctx) error {
	idParam := c.Params("id")
	id, err := strconv.Atoi(idParam)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "ID tidak valid", err.Error())
	}

	jenis := c.FormValue("jenis_berkas")
	if jenis == "" {
		return utils.Error(c, fiber.StatusBadRequest, "jenis_berkas wajib diisi", map[string][]string{
			"jenis_berkas": {"wajib diisi"},
		})
	}

	file, err := c.FormFile("file")
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "File wajib diupload", map[string][]string{
			"file": {"wajib diupload"},
		})
	}

	ext := strings.ToLower(filepath.Ext(file.Filename))
	allowed := map[string]bool{".jpg": true, ".jpeg": true, ".png": true, ".pdf": true}
	if !allowed[ext] {
		return utils.Error(c, fiber.StatusBadRequest, "Tipe file tidak diizinkan (hanya jpg, png, pdf)", map[string][]string{
			"file": {"tipe file tidak diizinkan"},
		})
	}

	uploadDir := filepath.Join("backend", "uploads", "pendaftaran", fmt.Sprintf("%d", id))
	if err := os.MkdirAll(uploadDir, 0o755); err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal membuat folder upload", err.Error())
	}

	newName := fmt.Sprintf("%d_berkas%s", time.Now().UnixNano(), ext)
	fullPath := filepath.Join(uploadDir, newName)

	if err := c.SaveFile(file, fullPath); err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal menyimpan file", err.Error())
	}

	relPath := filepath.ToSlash(strings.TrimPrefix(fullPath, "backend/"))

	berkas, err := h.service.AddBerkas(uint(id), jenis, relPath)
	if err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal menyimpan data berkas", err.Error())
	}

	return utils.Created(c, "Berkas berhasil diupload", berkas)
}

