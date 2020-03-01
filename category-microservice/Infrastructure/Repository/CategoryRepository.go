package Repository

import (
	"database/sql"
	"encoding/json"
	"ferdyrurka/category/Domain/Entity"
	"ferdyrurka/category/Infrastructure/Database"
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
	stmt, err := c.db.Prepare("INSERT INTO " + c.table + " VALUES (?, ?, NOW(), ?)")

	if err != nil {
		return err
	}

	bookIdsJson, _ := json.Marshal(category.BookIds)

	_, err = stmt.Exec(category.Id, category.Name, bookIdsJson)

	return err
}

func (c CategoryRepository) UpdateBookIds(category Entity.Category) error {
	stmt, err := c.db.Prepare("UPDATE " + c.table + " SET book_ids = ? WHERE id = ?")

	if err != nil {
		return err
	}

	bookIdsJson, _ := json.Marshal(category.BookIds)

	_, err = stmt.Exec(bookIdsJson, category.Id)

	return err
}

func (c CategoryRepository) GetCountByName(name string) (int, error) {
	stmt, err := c.db.Prepare("SELECT COUNT(c.id) FROM " + c.table + " c WHERE c.name = ?")

	if err != nil {
		return 0, err
	}

	result, err := stmt.Query(name)

	if err != nil {
		return 0, err
	}

	count := 0
	result.Next()
	err = result.Scan(&count)

	return count, err
}

func (c CategoryRepository) FindAll() (*[]Entity.Category, error) {
	result, err := c.db.Query("SELECT * FROM " + c.table)

	if err != nil {
		return nil, err
	}

	var categories []Entity.Category
	var category Entity.Category

	for result.Next() {
		category = Entity.Category{}

		err = result.Scan(&category.Id, &category.Name, &category.CreatedAt, &category.BookIds)

		if err != nil {
			return nil, err
		}

		categories = append(categories, category)
	}

	return &categories, nil
}

func (c CategoryRepository) GetById(id string) (Entity.Category, error) {
	result, err := c.db.Query("SELECT id, name, created_at, book_ids FROM " + c.table + " WHERE id = ?", id)

	category := Entity.Category{}

	if err != nil {
		return category, err
	}

	var bookIdsJson []uint8

	result.Next()
	err = result.Scan(&category.Id, &category.Name, &category.CreatedAt, &bookIdsJson)

	json.Unmarshal(bookIdsJson, &category.BookIds)

	return category, err
}

func (c CategoryRepository) PingCategoryDatabase() bool {
	err := c.db.Ping()

	return err == nil
}
