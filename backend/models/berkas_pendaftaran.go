package models

import "time"

type BerkasPendaftaran struct {
	ID            uint      `gorm:"primaryKey" json:"id"`
	PendaftaranID uint      `gorm:"index;not null" json:"pendaftaran_id"`
	JenisBerkas   string    `gorm:"size:100;not null" json:"jenis_berkas"`
	FilePath      string    `gorm:"size:255;not null" json:"file_path"`
	CreatedAt     time.Time `json:"created_at"`
	UpdatedAt     time.Time `json:"updated_at"`

	Pendaftaran Pendaftaran `gorm:"constraint:OnUpdate:CASCADE,OnDelete:CASCADE" json:"-"`
}

