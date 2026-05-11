package models

import "time"

type User struct {
	ID           uint `gorm:"primaryKey"`
	Name         string
	Email        string `gorm:"uniqueIndex;size:191"`
	PasswordHash string
	Role         string `gorm:"type:ENUM('admin','operator','wali murid');default:admin"`
	CreatedAt    time.Time
	UpdatedAt    time.Time
}

type Student struct {
	ID          uint `gorm:"primaryKey"`
	FullName    string
	BirthDate   time.Time `gorm:"type:DATE"`
	Gender      string    `gorm:"type:ENUM('L','P')"`
	Address     string    `gorm:"type:TEXT"`
	ParentName  string
	ParentPhone string
	CreatedAt   time.Time
	UpdatedAt   time.Time
}

type Class struct {
	ID            uint `gorm:"primaryKey"`
	Name          string
	Level         string
	Quota         int
	ScheduleDay   string
	ScheduleStart string
	ScheduleEnd   string
	CreatedAt     time.Time
	UpdatedAt     time.Time
}

type Registration struct {
	ID               uint `gorm:"primaryKey"`
	StudentID        uint
	ClassID          uint
	RegistrationCode string    `gorm:"uniqueIndex;size:191"`
	RegistrationDate time.Time `gorm:"type:DATETIME"`
	Status           string    `gorm:"type:ENUM('pending','accepted','rejected');default:pending"`
	CreatedAt        time.Time
	UpdatedAt        time.Time

	Student Student `gorm:"foreignKey:StudentID;constraint:OnUpdate:CASCADE,OnDelete:RESTRICT"`
	Class   Class   `gorm:"foreignKey:ClassID;constraint:OnUpdate:CASCADE,OnDelete:RESTRICT"`
}

// Flat model specifically for frontend integration
type Pendaftaran struct {
	ID                uint      `gorm:"primaryKey" json:"id"`
	NamaAnak          string    `json:"nama_anak"`
	TempatLahir       string    `json:"tempat_lahir"`
	TanggalLahir      string    `json:"tanggal_lahir"`
	JenisKelamin      string    `json:"jenis_kelamin"`
	NamaOrangTua      string    `json:"nama_orang_tua"`
	NoHp              string    `json:"no_hp"`
	Alamat            string    `json:"alamat"`
	Catatan           string    `json:"catatan"`
	StatusPendaftaran string    `gorm:"default:'pending'" json:"status_pendaftaran"`
	CreatedAt         time.Time `json:"created_at"`
	UpdatedAt         time.Time `json:"updated_at"`
}
