package models

import "time"

type PendaftaranStatus string

const (
	StatusPending  PendaftaranStatus = "pending"
	StatusDiproses PendaftaranStatus = "diproses"
	StatusDiterima PendaftaranStatus = "diterima"
	StatusDitolak  PendaftaranStatus = "ditolak"
)

type Pendaftaran struct {
	ID                uint               `gorm:"primaryKey" json:"id"`
	NamaAnak          string             `gorm:"size:191;not null" json:"nama_anak"`
	TempatLahir       string             `gorm:"size:191;not null" json:"tempat_lahir"`
	TanggalLahir      time.Time          `gorm:"type:date;not null" json:"tanggal_lahir"`
	JenisKelamin      string             `gorm:"size:10;not null" json:"jenis_kelamin"`
	NamaOrangTua      string             `gorm:"size:191;not null" json:"nama_orang_tua"`
	NoHP              string             `gorm:"size:50;not null" json:"no_hp"`
	Alamat            string             `gorm:"type:text;not null" json:"alamat"`
	StatusPendaftaran PendaftaranStatus  `gorm:"type:ENUM('pending','diproses','diterima','ditolak');default:'pending'" json:"status_pendaftaran"`
	Catatan           string             `gorm:"type:text" json:"catatan"`
	Berkas            []BerkasPendaftaran `json:"berkas,omitempty"`
	CreatedAt         time.Time          `json:"created_at"`
	UpdatedAt         time.Time          `json:"updated_at"`
}

