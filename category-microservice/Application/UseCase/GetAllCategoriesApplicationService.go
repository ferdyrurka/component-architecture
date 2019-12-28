package UseCase

import (
	"ferdyrurka/category/Domain/Entity"
	"ferdyrurka/category/Infrastructure/Repository"
)

func FindAllCategories() (*[]Entity.Category, error) {
	repo := Repository.NewCategoryRepository()
	categories, err := repo.FindAll()

	if err != nil {
		return nil, err
	}

	return categories, nil
}
