package Migration

import (
	"ferdyrurka/category/Infrastructure/Database"
	"fmt"
	"log"
)

func Migrate20191228()  {
	fmt.Println("Migration 2019-12-28 start create table migration_microservice...")
	db := Database.GetDatabase()
	_, err := db.Query("CREATE TABLE IF NOT EXISTS migration_microservice(id INTEGER(11) NOT NULL AUTO_INCREMENT, microservice_name varchar(255) NOT NULL, created_at_migration DATE NOT NULL, migration_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;")

	if err != nil {
		log.Fatalln(err.Error())
	}

	fmt.Println("Migration 2019-12-28 check...")

	if !isNewMigrate("2019-12-28") {
		fmt.Println("Migration 2019-12-28 skipped...")
		return
	}

	fmt.Println("Migration 2019-12-28 start...")
	db.Query("ALTER TABLE category ADD COLUMN created_at DATE")
	db.Query("UPDATE TABLE category SET created_at = NOW() WHERE created_at IS NULL")
	db.Query("ALTER TABLE category MODIFY created_at NOT NULL")
	db.Query("CREATE TABLE book_category(category_id VARCHAR(255) NOT NULL, book_id VARCHAR(255) NOT NULL, FOREIGN KEY (category_id) REFERENCES category (id), FOREIGN KEY (book_id) REFERENCES book (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;")

	fmt.Println("Migration 2019-12-28 successful, save migration info in database...")
	insertMigration("2019-12-28")

	fmt.Println("Save migration 2019-12-28 successful")
}
