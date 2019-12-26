package Connection

import (
	"database/sql"
	"ferdyrurka/category/Infrastructure/Config"
	_ "github.com/go-sql-driver/mysql"
)

func GetMySqlConnection() *sql.DB {
	conf := Config.GetConfig()
	db, err := sql.Open("mysql", conf.MysqlUrl)

	if err != nil {
		panic(err.Error())
	}

	return db
}
