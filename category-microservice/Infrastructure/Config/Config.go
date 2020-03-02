package Config

import (
	"fmt"
	"github.com/caarlos0/env/v6"
)

type config struct {
	MysqlUrl string `env:"MYSQL_URL,required"`
	Environment string `env:"ENV,required"`
}

func GetConfig() config {
	conf := config{}

	if err := env.Parse(&conf); err != nil {
		fmt.Printf("%+v\n", err)
	}

	setDefault(&conf)

	return conf
}

func setDefault(conf *config) {
	if len(conf.Environment) == 0 {
		conf.Environment = "dev"
	}
}
