package Database

import (
	"database/sql"
	"ferdyrurka/category/Infrastructure/Database/Connection"
)

func GetDatabase() *sql.DB {
	return Connection.GetMySqlConnection()
}
