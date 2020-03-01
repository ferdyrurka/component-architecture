package DTO

type CreateCategoryDTO struct {
	Name string
}

type CategoryNameDTO struct {
	Name string
}

type AddBookToCategoriesDTO struct {
	CategoryIds []string
	BookId string
}
