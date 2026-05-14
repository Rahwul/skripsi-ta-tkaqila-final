package services

import (
	"time"

	"web-pendaftaran-tkaqila/backend/models"
	"web-pendaftaran-tkaqila/backend/repositories"
)

type PendaftaranService struct {
	repo *repositories.PendaftaranRepository
}

func NewPendaftaranService(repo *repositories.PendaftaranRepository) *PendaftaranService {
	return &PendaftaranService{repo: repo}
}

func (s *PendaftaranService) Create(p *models.Pendaftaran) error {
	return s.repo.Create(p)
}

func (s *PendaftaranService) GetAll() ([]models.Pendaftaran, error) {
	return s.repo.FindAll()
}

func (s *PendaftaranService) GetByID(id uint) (*models.Pendaftaran, error) {
	return s.repo.FindByID(id)
}

func (s *PendaftaranService) Update(p *models.Pendaftaran) error {
	return s.repo.Update(p)
}

func (s *PendaftaranService) Delete(id uint) error {
	return s.repo.Delete(id)
}

func (s *PendaftaranService) GetByDateRange(start, end time.Time) ([]models.Pendaftaran, error) {
	return s.repo.FindByDateRange(start, end)
}

