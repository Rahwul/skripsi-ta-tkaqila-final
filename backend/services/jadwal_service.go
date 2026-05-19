package services

import (
	"web-pendaftaran-tkaqila/backend/models"
	"web-pendaftaran-tkaqila/backend/repositories"
)

type JadwalService struct {
	repo *repositories.JadwalRepository
}

func NewJadwalService(repo *repositories.JadwalRepository) *JadwalService {
	return &JadwalService{repo: repo}
}

func (s *JadwalService) Create(j *models.Jadwal) error {
	return s.repo.Create(j)
}

func (s *JadwalService) GetAll() ([]models.Jadwal, error) {
	return s.repo.FindAll()
}

func (s *JadwalService) GetByID(id uint) (*models.Jadwal, error) {
	return s.repo.FindByID(id)
}

func (s *JadwalService) Update(j *models.Jadwal) error {
	return s.repo.Update(j)
}

func (s *JadwalService) Delete(id uint) error {
	return s.repo.Delete(id)
}

