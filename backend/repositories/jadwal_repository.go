package repositories

import (
	"web-pendaftaran-tkaqila/backend/models"

	"gorm.io/gorm"
)

type JadwalRepository struct {
	db *gorm.DB
}

func NewJadwalRepository(db *gorm.DB) *JadwalRepository {
	return &JadwalRepository{db: db}
}

func (r *JadwalRepository) Create(j *models.Jadwal) error {
	return r.db.Create(j).Error
}

func (r *JadwalRepository) FindAll() ([]models.Jadwal, error) {
	var list []models.Jadwal
	err := r.db.Order("hari, jam_mulai").Find(&list).Error
	return list, err
}

func (r *JadwalRepository) FindByID(id uint) (*models.Jadwal, error) {
	var j models.Jadwal
	if err := r.db.First(&j, id).Error; err != nil {
		return nil, err
	}
	return &j, nil
}

func (r *JadwalRepository) Update(j *models.Jadwal) error {
	return r.db.Save(j).Error
}

func (r *JadwalRepository) Delete(id uint) error {
	return r.db.Delete(&models.Jadwal{}, id).Error
}

