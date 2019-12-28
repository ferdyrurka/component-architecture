package Repository

import "ferdyrurka/category/Domain/Entity"

type CategoryRepositoryInterface interface {
	Save(category Entity.Category) error
	GetCountByName(name string) (int, error)
	FindAll() (*[]Entity.Category, error)
}
