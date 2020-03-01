package Migration

import (
	"ferdyrurka/category/Infrastructure/Database"
	"fmt"
)

func Migrate20200229()  {
	fmt.Println("Migration 2020-02-29 check...")

	if !isNewMigrate("2020-02-29") {
		fmt.Println("Migration 2020-02-29 skipped...")
		return
	}

	fmt.Println("Migration 2020-02-29 start...")

	db := Database.GetDatabase()
	db.Query("DROP TABLE book_category")
	db.Query("ALTER TABLE category ADD COLUMN book_ids JSON NOT NULL")
	db.Query("ALTER TABLE category MODIFY COLUMN created_at DATETIME")

	fmt.Println("Migration 2020-02-29 successful, save migration info in database...")
	insertMigration("2020-02-29")

	fmt.Println("Save migration 2020-02-29 successful")
}