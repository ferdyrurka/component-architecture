package Config

import (
	"fmt"
	"github.com/caarlos0/env/v6"
)

type config struct {
	MysqlUrl string `env:"MYSQL_URL,required"`
}

func GetConfig() config {
	conf := config{}

	if err := env.Parse(&conf); err != nil {
		fmt.Printf("%+v\n", err)
	}

	return conf
}
