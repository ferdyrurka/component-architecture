package Entity

import (
	"github.com/satori/go.uuid"
)

type Category struct {
	Id   string
	Name string
}

func CreateCategory(name string) Category {
	return Category{
		Id:   uuid.Must(uuid.NewV4(), nil).String(),
		Name: name,
	}
}

func GetCategoryTableName() string {
	return "category"
}
