package handlers

import (
	"strconv"
	"time"

	"web-pendaftaran-tkaqila/backend/models"
	"web-pendaftaran-tkaqila/backend/services"
	"web-pendaftaran-tkaqila/backend/utils"

	"github.com/gofiber/fiber/v2"
)

type PendaftaranHandler struct {
	service *services.PendaftaranService
}

func NewPendaftaranHandler(service *services.PendaftaranService) *PendaftaranHandler {
	return &PendaftaranHandler{service: service}
}

type PendaftaranRequest struct {
	NamaAnak     string `json:"nama_anak"`
	TempatLahir  string `json:"tempat_lahir"`
	TanggalLahir string `json:"tanggal_lahir"`
	JenisKelamin string `json:"jenis_kelamin"`
	NamaOrangTua string `json:"nama_orang_tua"`
	NoHP         string `json:"no_hp"`
	Alamat       string `json:"alamat"`
	Catatan      string `json:"catatan"`
}

func (h *PendaftaranHandler) Create(c *fiber.Ctx) error {
	var body PendaftaranRequest
	if err := c.BodyParser(&body); err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Payload tidak valid", map[string][]string{
			"body": {"format JSON tidak valid"},
		})
	}

	errors := map[string][]string{}
	if body.NamaAnak == "" {
		errors["nama_anak"] = []string{"wajib diisi"}
	}
	if body.TempatLahir == "" {
		errors["tempat_lahir"] = []string{"wajib diisi"}
	}
	if body.TanggalLahir == "" {
		errors["tanggal_lahir"] = []string{"wajib diisi"}
	}
	if body.JenisKelamin == "" {
		errors["jenis_kelamin"] = []string{"wajib diisi"}
	}
	if body.NamaOrangTua == "" {
		errors["nama_orang_tua"] = []string{"wajib diisi"}
	}
	if body.NoHP == "" {
		errors["no_hp"] = []string{"wajib diisi"}
	}
	if body.Alamat == "" {
		errors["alamat"] = []string{"wajib diisi"}
	}
	if len(errors) > 0 {
		return utils.Error(c, fiber.StatusBadRequest, "Data tidak lengkap", errors)
	}

	tgl, err := time.Parse("2006-01-02", body.TanggalLahir)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Format tanggal_lahir harus YYYY-MM-DD", map[string][]string{
			"tanggal_lahir": {"format tidak valid"},
		})
	}

	p := &models.Pendaftaran{
		NamaAnak:          body.NamaAnak,
		TempatLahir:       body.TempatLahir,
		TanggalLahir:      tgl,
		JenisKelamin:      body.JenisKelamin,
		NamaOrangTua:      body.NamaOrangTua,
		NoHP:              body.NoHP,
		Alamat:            body.Alamat,
		StatusPendaftaran: models.StatusPending,
		Catatan:           body.Catatan,
	}

	if err := h.service.Create(p); err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal menyimpan pendaftaran", err.Error())
	}

	return utils.Created(c, "Pendaftaran berhasil dibuat", p)
}

func (h *PendaftaranHandler) GetAll(c *fiber.Ctx) error {
	list, err := h.service.GetAll()
	if err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal mengambil data pendaftaran", err.Error())
	}
	return utils.Success(c, "Daftar pendaftar", list)
}

func (h *PendaftaranHandler) GetByID(c *fiber.Ctx) error {
	idParam := c.Params("id")
	id, err := strconv.Atoi(idParam)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "ID tidak valid", err.Error())
	}
	p, err := h.service.GetByID(uint(id))
	if err != nil {
		return utils.Error(c, fiber.StatusNotFound, "Data pendaftar tidak ditemukan", err.Error())
	}
	return utils.Success(c, "Detail pendaftar", p)
}

func (h *PendaftaranHandler) Update(c *fiber.Ctx) error {
	idParam := c.Params("id")
	id, err := strconv.Atoi(idParam)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "ID tidak valid", err.Error())
	}

	existing, err := h.service.GetByID(uint(id))
	if err != nil {
		return utils.Error(c, fiber.StatusNotFound, "Data pendaftar tidak ditemukan", err.Error())
	}

	var body PendaftaranRequest
	if err := c.BodyParser(&body); err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Payload tidak valid", map[string][]string{
			"body": {"format JSON tidak valid"},
		})
	}

	if body.NamaAnak != "" {
		existing.NamaAnak = body.NamaAnak
	}
	if body.TempatLahir != "" {
		existing.TempatLahir = body.TempatLahir
	}
	if body.TanggalLahir != "" {
		tgl, err := time.Parse("2006-01-02", body.TanggalLahir)
		if err != nil {
			return utils.Error(c, fiber.StatusBadRequest, "Format tanggal_lahir harus YYYY-MM-DD", map[string][]string{
				"tanggal_lahir": {"format tidak valid"},
			})
		}
		existing.TanggalLahir = tgl
	}
	if body.JenisKelamin != "" {
		existing.JenisKelamin = body.JenisKelamin
	}
	if body.NamaOrangTua != "" {
		existing.NamaOrangTua = body.NamaOrangTua
	}
	if body.NoHP != "" {
		existing.NoHP = body.NoHP
	}
	if body.Alamat != "" {
		existing.Alamat = body.Alamat
	}
	if body.Catatan != "" {
		existing.Catatan = body.Catatan
	}

	if err := h.service.Update(existing); err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal mengupdate pendaftaran", err.Error())
	}
	return utils.Success(c, "Pendaftaran berhasil diupdate", existing)
}

type UpdateStatusRequest struct {
	Status  string `json:"status_pendaftaran"`
	Catatan string `json:"catatan"`
}

func (h *PendaftaranHandler) UpdateStatus(c *fiber.Ctx) error {
	idParam := c.Params("id")
	id, err := strconv.Atoi(idParam)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "ID tidak valid", err.Error())
	}

	var body UpdateStatusRequest
	if err := c.BodyParser(&body); err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Payload tidak valid", map[string][]string{
			"body": {"format JSON tidak valid"},
		})
	}
	if body.Status == "" {
		return utils.Error(c, fiber.StatusBadRequest, "Status_pendaftaran wajib diisi", map[string][]string{
			"status_pendaftaran": {"wajib diisi"},
		})
	}

	status := models.PendaftaranStatus(body.Status)
	switch status {
	case models.StatusPending, models.StatusDiproses, models.StatusDiterima, models.StatusDitolak:
	default:
		return utils.Error(c, fiber.StatusBadRequest, "Status_pendaftaran tidak valid", map[string][]string{
			"status_pendaftaran": {"harus salah satu dari pending, diproses, diterima, ditolak"},
		})
	}

	existing, err := h.service.GetByID(uint(id))
	if err != nil {
		return utils.Error(c, fiber.StatusNotFound, "Data pendaftar tidak ditemukan", err.Error())
	}

	existing.StatusPendaftaran = status
	if body.Catatan != "" {
		existing.Catatan = body.Catatan
	}

	if err := h.service.Update(existing); err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal mengupdate status pendaftaran", err.Error())
	}
	return utils.Success(c, "Status pendaftaran berhasil diupdate", existing)
}

func (h *PendaftaranHandler) Delete(c *fiber.Ctx) error {
	idParam := c.Params("id")
	id, err := strconv.Atoi(idParam)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "ID tidak valid", err.Error())
	}

	if err := h.service.Delete(uint(id)); err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal menghapus pendaftaran", err.Error())
	}
	return utils.Success(c, "Pendaftaran berhasil dihapus", nil)
}


