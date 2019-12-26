package UseCase

import (
	"ferdyrurka/category/Infrastructure/Repository"
	"ferdyrurka/category/UI/DTO"
)

func CheckExistCategory(dto DTO.CategoryNameDTO) (int, error) {
	return Repository.NewCategoryRepository().GetCountByName(dto.Name)
}
