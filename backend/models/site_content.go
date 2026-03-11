package models

import "time"

type SiteContent struct {
	ID        uint      `gorm:"primaryKey" json:"id"`
	Key       string    `gorm:"size:191;uniqueIndex;not null" json:"key"`
	Value     string    `gorm:"type:longtext;not null" json:"value"`
	CreatedAt time.Time `json:"created_at"`
	UpdatedAt time.Time `json:"updated_at"`
}

