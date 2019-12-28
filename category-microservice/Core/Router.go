package Core

import (
	"ferdyrurka/category/UI/Controller"
	"github.com/gorilla/mux"
)

const APIPrefix = "/api/v1"

func createRoute() *mux.Router {
	router := mux.NewRouter()

	router.HandleFunc(APIPrefix + "/health-check", Controller.CheckHealth).Methods("GET")
	router.HandleFunc(APIPrefix + "/create-category", Controller.CreateCategory).Methods("POST")
	router.HandleFunc(APIPrefix + "/check-exist-category/{name}", Controller.CheckExistCategory).Methods("GET")
	router.HandleFunc(APIPrefix + "/find-all", Controller.FindAllCategories).Methods("GET")

	return router
}
