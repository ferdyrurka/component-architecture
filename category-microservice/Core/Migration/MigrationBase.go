package Migration

import (
	"ferdyrurka/category/Infrastructure/Database"
	"log"
)

const MICROSERVICE_NAME string = "category"

func isNewMigrate(createdAtMigration string) bool {
	stmt, err := Database.GetDatabase().Prepare("SELECT COUNT(mm.id) FROM migration_microservice mm WHERE mm.created_at_migration = ? AND mm.microservice_name = ?")

	if err != nil {
		log.Fatalln(err.Error())
	}

	result, err := stmt.Query(createdAtMigration, MICROSERVICE_NAME)

	if err != nil {
		log.Fatalln(err.Error())
	}

	var count int
	result.Next()
	_ = result.Scan(&count)

	if count > 0 {
		return false
	}

	return true
}

func insertMigration(createdAtMigration string) {
	stmt, err := Database.GetDatabase().Prepare("INSERT INTO migration_microservice (microservice_name, created_at_migration, migration_at) VALUES (?, ?, NOW())")

	if err != nil {
		log.Fatalln(err.Error())
	}

	_, err = stmt.Exec(MICROSERVICE_NAME, createdAtMigration)

	if err != nil {
		log.Fatalln(err.Error())
	}
}
