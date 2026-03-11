package handlers

import (
	"web-pendaftaran-tkaqila/backend/services"
	"web-pendaftaran-tkaqila/backend/utils"

	"github.com/gofiber/fiber/v2"
)

type SiteContentHandler struct {
	service *services.SiteContentService
}

func NewSiteContentHandler(service *services.SiteContentService) *SiteContentHandler {
	return &SiteContentHandler{service: service}
}

func (h *SiteContentHandler) GetAll(c *fiber.Ctx) error {
	data, err := h.service.GetAll()
	if err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal mengambil konten website", err.Error())
	}

	return utils.Success(c, "Konten website", data)
}

func (h *SiteContentHandler) UpsertMany(c *fiber.Ctx) error {
	var payload map[string]string
	if err := c.BodyParser(&payload); err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Payload tidak valid", err.Error())
	}

	saved, err := h.service.UpsertMany(payload)
	if err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal menyimpan konten website", err.Error())
	}

	return utils.Success(c, "Konten website berhasil disimpan", saved)
}

