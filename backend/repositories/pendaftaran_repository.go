package repositories

import (
	"time"

	"web-pendaftaran-tkaqila/backend/models"

	"gorm.io/gorm"
)

type PendaftaranRepository struct {
	db *gorm.DB
}

func NewPendaftaranRepository(db *gorm.DB) *PendaftaranRepository {
	return &PendaftaranRepository{db: db}
}

func (r *PendaftaranRepository) Create(p *models.Pendaftaran) error {
	return r.db.Create(p).Error
}

func (r *PendaftaranRepository) FindAll() ([]models.Pendaftaran, error) {
	var list []models.Pendaftaran
	err := r.db.Preload("Berkas").Order("created_at desc").Find(&list).Error
	return list, err
}

func (r *PendaftaranRepository) FindByID(id uint) (*models.Pendaftaran, error) {
	var p models.Pendaftaran
	err := r.db.Preload("Berkas").First(&p, id).Error
	if err != nil {
		return nil, err
	}
	return &p, nil
}

func (r *PendaftaranRepository) Update(p *models.Pendaftaran) error {
	return r.db.Save(p).Error
}

func (r *PendaftaranRepository) Delete(id uint) error {
	return r.db.Delete(&models.Pendaftaran{}, id).Error
}

func (r *PendaftaranRepository) FindByDateRange(start, end time.Time) ([]models.Pendaftaran, error) {
	var list []models.Pendaftaran
	err := r.db.Where("created_at BETWEEN ? AND ?", start, end).
		Order("created_at desc").
		Find(&list).Error
	return list, err
}

