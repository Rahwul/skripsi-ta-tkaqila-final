package database

import (
	"fmt"
	"log"

	"web-pendaftaran-tkaqila/backend/config"
	"web-pendaftaran-tkaqila/backend/models"

	"gorm.io/driver/mysql"
	"gorm.io/gorm"
)

var DB *gorm.DB

func ConnectAndMigrate(cfg *config.Config) *gorm.DB {
	dsn := fmt.Sprintf(
		"%s:%s@tcp(%s:%s)/%s?charset=utf8mb4&parseTime=True&loc=Local",
		cfg.DBUser,
		cfg.DBPassword,
		cfg.DBHost,
		cfg.DBPort,
		cfg.DBName,
	)

	db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
	if err != nil {
		log.Fatalf("Gagal konek database: %v", err)
	}

	if err := db.AutoMigrate(
		&models.Admin{},
		&models.Pendaftaran{},
		&models.BerkasPendaftaran{},
		&models.Jadwal{},
		&models.SiteContent{},
	); err != nil {
		log.Fatalf("Gagal migrasi database: %v", err)
	}

	DB = db
	return db
}
