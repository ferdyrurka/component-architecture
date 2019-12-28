package UseCase

import (
	"ferdyrurka/category/Infrastructure/Repository"
	"ferdyrurka/category/UI/DTO"
)

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
