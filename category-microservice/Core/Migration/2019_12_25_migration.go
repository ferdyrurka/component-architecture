package Migration

import (
	"ferdyrurka/category/Infrastructure/Database"
	"fmt"
	"log"
)

func Migrate20191225()  {
	fmt.Println("Migration 2019-12-25 start...")
	_, err := Database.GetDatabase().Query("CREATE TABLE IF NOT EXISTS category(id varchar(255) NOT NULL, name varchar(255) NOT NULL UNIQUE, UNIQUE INDEX UNIQ_CATEGORY_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;")

	if err != nil {
		log.Fatalln(err.Error())
	}

	fmt.Println("Migrate successful")
}
