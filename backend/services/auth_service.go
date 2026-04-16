package services

import (
	"errors"

	"web-pendaftaran-tkaqila/backend/config"
	"web-pendaftaran-tkaqila/backend/models"
	"web-pendaftaran-tkaqila/backend/repositories"
	"web-pendaftaran-tkaqila/backend/utils"

	"golang.org/x/crypto/bcrypt"
)

type AuthService struct {
	cfg       *config.Config
	adminRepo *repositories.AdminRepository
}

func NewAuthService(cfg *config.Config, adminRepo *repositories.AdminRepository) *AuthService {
	return &AuthService{
		cfg:       cfg,
		adminRepo: adminRepo,
	}
}

func (s *AuthService) Register(name, email, password string) (*models.Admin, error) {
	hash, err := bcrypt.GenerateFromPassword([]byte(password), bcrypt.DefaultCost)
	if err != nil {
		return nil, err
	}
	admin := &models.Admin{
		Name:     name,
		Email:    email,
		Password: string(hash),
	}
	if err := s.adminRepo.Create(admin); err != nil {
		return nil, err
	}
	return admin, nil
}

func (s *AuthService) Login(email, password string) (string, *models.Admin, error) {
	admin, err := s.adminRepo.FindByEmail(email)
	if err != nil {
		return "", nil, errors.New("email atau password salah")
	}
	if err := bcrypt.CompareHashAndPassword([]byte(admin.Password), []byte(password)); err != nil {
		return "", nil, errors.New("email atau password salah")
	}
	token, err := utils.GenerateAdminToken(s.cfg.JWTSecret, admin)
	if err != nil {
		return "", nil, err
	}
	return token, admin, nil
}

