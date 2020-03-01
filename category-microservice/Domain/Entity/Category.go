package Entity

import (
	"github.com/satori/go.uuid"
)

type Category struct {
	Id   string
	Name string
	CreatedAt string
	BookIds []string
}

func CreateCategory(name string) Category {
	return Category{
		Id:   uuid.Must(uuid.NewV4(), nil).String(),
		Name: name,
		BookIds: []string{},
	}
}

func AddBook(bookId string, category *Category) {
	category.BookIds = append(category.BookIds, bookId)
}

func GetCategoryTableName() string {
	return "category"
}
