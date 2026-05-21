package repositories

import (
	"web-pendaftaran-tkaqila/backend/models"

	"gorm.io/gorm"
)

type SiteContentRepository struct {
	db *gorm.DB
}

func NewSiteContentRepository(db *gorm.DB) *SiteContentRepository {
	return &SiteContentRepository{db: db}
}

func (r *SiteContentRepository) FindAll() ([]models.SiteContent, error) {
	var list []models.SiteContent
	err := r.db.Order("`key` asc").Find(&list).Error
	return list, err
}

func (r *SiteContentRepository) Upsert(key, value string) (*models.SiteContent, error) {
	sc := &models.SiteContent{
		Key:   key,
		Value: value,
	}

	err := r.db.Where("`key` = ?", key).FirstOrCreate(sc).Error
	if err != nil {
		return nil, err
	}

	if sc.Value != value {
		sc.Value = value
		if err := r.db.Save(sc).Error; err != nil {
			return nil, err
		}
	}

	return sc, nil
}

