package Core

import (
	"fmt"
	"net/http"
)

func initServer() {
	fmt.Println("Servers run on port 8080")
	err := http.ListenAndServe(":8080", createRoute())

	if err != nil {
		panic("Server error: " + err.Error())
	}

	fmt.Println("Server disabled!")
}

func ServerStart() {
	initServer()
}
