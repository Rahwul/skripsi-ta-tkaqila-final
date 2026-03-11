package database

import (
    "fmt"
    "os"

    "gorm.io/driver/mysql"
    "gorm.io/gorm"
)

var DB *gorm.DB

func getEnv(key, def string) string {
    v := os.Getenv(key)
    if v == "" {
        return def
    }
    return v
}

func ConnectDB() (*gorm.DB, error) {
    user := getEnv("DB_USER", getEnv("DB_USERNAME", "root"))
    pass := getEnv("DB_PASS", getEnv("DB_PASSWORD", ""))
    host := getEnv("DB_HOST", "localhost")
    port := getEnv("DB_PORT", "3306")
    name := getEnv("DB_NAME", getEnv("DB_DATABASE", "db_tk_aqila"))

    dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?charset=utf8mb4&parseTime=True&loc=Local", user, pass, host, port, name)
    db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
    if err != nil {
        return nil, err
    }
    DB = db
    return db, nil
}

