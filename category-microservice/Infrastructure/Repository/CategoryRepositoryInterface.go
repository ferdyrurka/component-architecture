package Repository

import "ferdyrurka/category/Domain/Entity"

type CategoryRepositoryInterface interface {
	Save(category Entity.Category) error
	UpdateBookIds(category Entity.Category) error
	GetCountByName(name string) (int, error)
	FindAll() (*[]Entity.Category, error)
	GetById(id string) (Entity.Category, error)
}
