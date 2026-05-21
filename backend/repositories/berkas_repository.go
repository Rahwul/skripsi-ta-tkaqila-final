package repositories

import (
	"web-pendaftaran-tkaqila/backend/models"

	"gorm.io/gorm"
)

type BerkasRepository struct {
	db *gorm.DB
}

func NewBerkasRepository(db *gorm.DB) *BerkasRepository {
	return &BerkasRepository{db: db}
}

func (r *BerkasRepository) Create(berkas *models.BerkasPendaftaran) error {
	return r.db.Create(berkas).Error
}

