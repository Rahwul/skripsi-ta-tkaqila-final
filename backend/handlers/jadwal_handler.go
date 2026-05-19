package handlers

import (
	"strconv"

	"web-pendaftaran-tkaqila/backend/models"
	"web-pendaftaran-tkaqila/backend/services"
	"web-pendaftaran-tkaqila/backend/utils"

	"github.com/gofiber/fiber/v2"
)

type JadwalHandler struct {
	service *services.JadwalService
}

func NewJadwalHandler(service *services.JadwalService) *JadwalHandler {
	return &JadwalHandler{service: service}
}

type JadwalRequest struct {
	NamaKelas  string `json:"nama_kelas"`
	Hari       string `json:"hari"`
	JamMulai   string `json:"jam_mulai"`
	JamSelesai string `json:"jam_selesai"`
	Keterangan string `json:"keterangan"`
}

func (h *JadwalHandler) Create(c *fiber.Ctx) error {
	var body JadwalRequest
	if err := c.BodyParser(&body); err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Payload tidak valid", map[string][]string{
			"body": {"format JSON tidak valid"},
		})
	}

	errors := map[string][]string{}
	if body.NamaKelas == "" {
		errors["nama_kelas"] = []string{"wajib diisi"}
	}
	if body.Hari == "" {
		errors["hari"] = []string{"wajib diisi"}
	}
	if body.JamMulai == "" {
		errors["jam_mulai"] = []string{"wajib diisi"}
	}
	if body.JamSelesai == "" {
		errors["jam_selesai"] = []string{"wajib diisi"}
	}
	if len(errors) > 0 {
		return utils.Error(c, fiber.StatusBadRequest, "Data tidak lengkap", errors)
	}

	j := &models.Jadwal{
		NamaKelas:  body.NamaKelas,
		Hari:       body.Hari,
		JamMulai:   body.JamMulai,
		JamSelesai: body.JamSelesai,
		Keterangan: body.Keterangan,
	}

	if err := h.service.Create(j); err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal menyimpan jadwal", err.Error())
	}

	return utils.Created(c, "Jadwal berhasil dibuat", j)
}

func (h *JadwalHandler) GetAll(c *fiber.Ctx) error {
	list, err := h.service.GetAll()
	if err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal mengambil jadwal", err.Error())
	}
	return utils.Success(c, "Daftar jadwal kelas", list)
}

func (h *JadwalHandler) GetByID(c *fiber.Ctx) error {
	idParam := c.Params("id")
	id, err := strconv.Atoi(idParam)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "ID tidak valid", err.Error())
	}
	j, err := h.service.GetByID(uint(id))
	if err != nil {
		return utils.Error(c, fiber.StatusNotFound, "Jadwal tidak ditemukan", err.Error())
	}
	return utils.Success(c, "Detail jadwal", j)
}

func (h *JadwalHandler) Update(c *fiber.Ctx) error {
	idParam := c.Params("id")
	id, err := strconv.Atoi(idParam)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "ID tidak valid", err.Error())
	}

	existing, err := h.service.GetByID(uint(id))
	if err != nil {
		return utils.Error(c, fiber.StatusNotFound, "Jadwal tidak ditemukan", err.Error())
	}

	var body JadwalRequest
	if err := c.BodyParser(&body); err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Payload tidak valid", map[string][]string{
			"body": {"format JSON tidak valid"},
		})
	}

	if body.NamaKelas != "" {
		existing.NamaKelas = body.NamaKelas
	}
	if body.Hari != "" {
		existing.Hari = body.Hari
	}
	if body.JamMulai != "" {
		existing.JamMulai = body.JamMulai
	}
	if body.JamSelesai != "" {
		existing.JamSelesai = body.JamSelesai
	}
	if body.Keterangan != "" {
		existing.Keterangan = body.Keterangan
	}

	if err := h.service.Update(existing); err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal mengupdate jadwal", err.Error())
	}
	return utils.Success(c, "Jadwal berhasil diupdate", existing)
}

func (h *JadwalHandler) Delete(c *fiber.Ctx) error {
	idParam := c.Params("id")
	id, err := strconv.Atoi(idParam)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "ID tidak valid", err.Error())
	}

	if err := h.service.Delete(uint(id)); err != nil {
		return utils.Error(c, fiber.StatusInternalServerError, "Gagal menghapus jadwal", err.Error())
	}
	return utils.Success(c, "Jadwal berhasil dihapus", nil)
}

