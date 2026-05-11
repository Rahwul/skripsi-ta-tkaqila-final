package models

import "time"

type Jadwal struct {
	ID         uint      `gorm:"primaryKey" json:"id"`
	NamaKelas  string    `gorm:"size:191;not null" json:"nama_kelas"`
	Hari       string    `gorm:"size:20;not null" json:"hari"`
	JamMulai   string    `gorm:"size:10;not null" json:"jam_mulai"`
	JamSelesai string    `gorm:"size:10;not null" json:"jam_selesai"`
	Keterangan string    `gorm:"type:text" json:"keterangan"`
	CreatedAt  time.Time `json:"created_at"`
	UpdatedAt  time.Time `json:"updated_at"`
}

