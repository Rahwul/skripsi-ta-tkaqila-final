package services

import (
	"time"

	"web-pendaftaran-tkaqila/backend/models"
	"web-pendaftaran-tkaqila/backend/repositories"
)

type LaporanService struct {
	pendaftaranRepo *repositories.PendaftaranRepository
}

func NewLaporanService(pendaftaranRepo *repositories.PendaftaranRepository) *LaporanService {
	return &LaporanService{pendaftaranRepo: pendaftaranRepo}
}

func (s *LaporanService) LaporanPeriode(start, end time.Time) ([]models.Pendaftaran, error) {
	return s.pendaftaranRepo.FindByDateRange(start, end)
}

