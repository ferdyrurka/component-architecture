package UseCase

import (
	"errors"
	"ferdyrurka/category/Domain/Entity"
	"ferdyrurka/category/Infrastructure/Repository"
	"ferdyrurka/category/UI/DTO"
)

func CreateCategory(dto DTO.CreateCategoryDTO) (string, error) {
	repo := Repository.NewCategoryRepository()

	count, err := repo.GetCountByName(dto.Name)

	if err != nil {
		return "", err
	} else if count > 0 {
		return "", errors.New("Category is found!")
	}

	category := Entity.CreateCategory(dto.Name)
	return category.Id, repo.Save(category)
}

func AddBookToCategories(dto DTO.AddBookToCategoriesDTO) error {
	repo := Repository.NewCategoryRepository()

	for _, categoryId := range dto.CategoryIds {
		category, err := repo.GetById(categoryId)

		if err != nil {
			return err
		}

		Entity.AddBook(dto.BookId, &category)

		err = repo.UpdateBookIds(category)

		if err != nil {
			return err
		}
	}

	return nil
}
