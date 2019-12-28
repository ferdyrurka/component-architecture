package Repository

import (
	"database/sql"
	"errors"
	"ferdyrurka/category/Domain/Entity"
	"ferdyrurka/category/Infrastructure/Database"
	"log"
)

type CategoryRepository struct {
	db *sql.DB
	table string
}

func NewCategoryRepository() CategoryRepositoryInterface {
	return &CategoryRepository{
		db: Database.GetDatabase(),
		table: Entity.GetCategoryTableName(),
	}
}

func (c CategoryRepository) Save(category Entity.Category) error {
	stmt, err := c.db.Prepare("INSERT INTO " + c.table + " VALUES (?, ?)")

	if err != nil {
		log.Println("Prepare save, error message: " + err.Error())
		return errors.New("Runtime error: query failed.")
	}

	_, err = stmt.Exec(category.Id, category.Name)

	if err != nil {
		log.Println("Exec save, error message: " + err.Error())
		return errors.New("Runtime error: exec failed.")
	}

	return nil
}

func (c CategoryRepository) GetCountByName(name string) (int, error) {
	stmt, err := c.db.Prepare("SELECT COUNT(c.id) FROM " + c.table + " c WHERE c.name = ?")

	if err != nil {
		log.Println("Prepare GetCountByName, error message: " + err.Error())
		return 0, errors.New("Runtime error: query failed.")
	}

	result, err := stmt.Query(name)

	if err != nil {
		log.Println("Exec GetCountByName, error message: " + err.Error())
		return 0, errors.New("Runtime error: exec failed.")
	}

	var count int
	result.Next()
	_ = result.Scan(&count)

	return count, nil
}

func (c CategoryRepository) FindAll() (*[]Entity.Category, error) {
	result, err := c.db.Query("SELECT * FROM category")

	if err != nil {
		log.Println("Exec GetAll, error message: " + err.Error())
		return nil, err
	}

	var categories []Entity.Category

	for result.Next() {
		var id string
		var name string

		result.Scan(&id, &name)
		categories = append(categories, Entity.Category{Id: id, Name: name})
	}

	return &categories, nil
}
