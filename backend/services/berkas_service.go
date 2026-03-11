package services

import (
	"web-pendaftaran-tkaqila/backend/models"
	"web-pendaftaran-tkaqila/backend/repositories"
)

type BerkasService struct {
	berkasRepo      *repositories.BerkasRepository
	pendaftaranRepo *repositories.PendaftaranRepository
}

func NewBerkasService(berkasRepo *repositories.BerkasRepository, pendaftaranRepo *repositories.PendaftaranRepository) *BerkasService {
	return &BerkasService{
		berkasRepo:      berkasRepo,
		pendaftaranRepo: pendaftaranRepo,
	}
}

func (s *BerkasService) AddBerkas(pendaftaranID uint, jenis, path string) (*models.BerkasPendaftaran, error) {
	if _, err := s.pendaftaranRepo.FindByID(pendaftaranID); err != nil {
		return nil, err
	}
	b := &models.BerkasPendaftaran{
		PendaftaranID: pendaftaranID,
		JenisBerkas:   jenis,
		FilePath:      path,
	}
	if err := s.berkasRepo.Create(b); err != nil {
		return nil, err
	}
	return b, nil
}

