package Query

import (
	"ferdyrurka/category/Domain/Entity"
	"ferdyrurka/category/Infrastructure/Repository"
	"ferdyrurka/category/UI/DTO"
)

func FindAllCategories() (*[]Entity.Category, error) {
	repo := Repository.NewCategoryRepository()
	categories, err := repo.FindAll()

	if err != nil {
		return nil, err
	}

	return categories, nil
}

func CheckExistCategory(dto DTO.CategoryNameDTO) (bool, error) {
	count, err := Repository.NewCategoryRepository().GetCountByName(dto.Name)

	if err != nil {
		return true, err
	}

	if count > 0 {
		return true, nil
	}

	return false, nil
}
