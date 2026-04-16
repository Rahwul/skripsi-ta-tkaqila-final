package services

import (
	"strings"

	"web-pendaftaran-tkaqila/backend/repositories"
)

type SiteContentService struct {
	repo *repositories.SiteContentRepository
}

func NewSiteContentService(repo *repositories.SiteContentRepository) *SiteContentService {
	return &SiteContentService{repo: repo}
}

func (s *SiteContentService) GetAll() (map[string]string, error) {
	list, err := s.repo.FindAll()
	if err != nil {
		return nil, err
	}

	out := make(map[string]string, len(list))
	for _, item := range list {
		out[item.Key] = item.Value
	}
	return out, nil
}

func (s *SiteContentService) UpsertMany(values map[string]string) (map[string]string, error) {
	out := make(map[string]string, len(values))

	for k, v := range values {
		key := strings.TrimSpace(k)
		if key == "" {
			continue
		}

		value := strings.TrimSpace(v)
		_, err := s.repo.Upsert(key, value)
		if err != nil {
			return nil, err
		}

		out[key] = value
	}

	return out, nil
}

