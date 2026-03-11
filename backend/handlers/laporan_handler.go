package handlers

import (
	"time"

	"web-pendaftaran-tkaqila/backend/services"
	"web-pendaftaran-tkaqila/backend/utils"

	"github.com/gofiber/fiber/v2"
)

type LaporanHandler struct {
	service *services.LaporanService
}

func NewLaporanHandler(service *services.LaporanService) *LaporanHandler {
	return &LaporanHandler{service: service}
}

func (h *LaporanHandler) LaporanPeriode(c *fiber.Ctx) error {
	startStr := c.Query("start_date")
	endStr := c.Query("end_date")

	if startStr == "" || endStr == "" {
		return utils.Error(c, fiber.StatusBadRequest, "start_date dan end_date wajib diisi", map[string][]string{
			"start_date": {"wajib diisi"},
			"end_date":   {"wajib diisi"},
		})
	}

	start, err := time.Parse("2006-01-02", startStr)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Format start_date harus YYYY-MM-DD", map[string][]string{
			"start_date": {"format tidak valid"},
		})
	}
	end, err := time.Parse("2006-01-02", endStr)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Format end_date harus YYYY-MM-DD", map[string][]string{
			"end_date": {"format tidak valid"},
		})
	}

	end = end.Add(24*time.Hour - time.Nanosecond)

	list, err := h.service.LaporanPeriode(start, end)
	if err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal mengambil laporan", err.Error())
	}

	data := fiber.Map{
		"start_date": startStr,
		"end_date":   endStr,
		"total":      len(list),
		"data":       list,
	}

	return utils.Success(c, "Laporan pendaftaran per periode", data)
}

