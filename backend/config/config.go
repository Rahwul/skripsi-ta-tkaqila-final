package config

import (
	"log"
	"os"
)

type Config struct {
	AppPort   string
	JWTSecret string

	DBHost     string
	DBPort     string
	DBUser     string
	DBPassword string
	DBName     string
}

func getEnv(key, def string) string {
	if v := os.Getenv(key); v != "" {
		return v
	}
	return def
}

func LoadConfig() *Config {
	cfg := &Config{
		AppPort:   getEnv("APP_PORT", "3000"),
		JWTSecret: getEnv("JWT_SECRET", "supersecretjwt"),

		DBHost:     getEnv("DB_HOST", "127.0.0.1"),
		DBPort:     getEnv("DB_PORT", "3306"),
		DBUser:     getEnv("DB_USERNAME", getEnv("DB_USER", "root")),
		DBPassword: getEnv("DB_PASSWORD", getEnv("DB_PASS", "")),
		DBName:     getEnv("DB_DATABASE", getEnv("DB_NAME", "db_tk_aqila")),
	}

	if cfg.JWTSecret == "supersecretjwt" {
		log.Println("[WARN] JWT_SECRET masih default, sebaiknya diganti di .env")
	}

	return cfg
}

