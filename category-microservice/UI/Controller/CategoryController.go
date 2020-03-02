package Controller

import (
	"errors"
	"ferdyrurka/category/Application/Query"
	"ferdyrurka/category/Application/UseCase"
	"ferdyrurka/category/Infrastructure/Http"
	"ferdyrurka/category/UI/DTO"
	"ferdyrurka/category/UI/Presenter"
	"ferdyrurka/category/UI/Validator"
	"github.com/gorilla/mux"
	"net/http"
)

func CreateCategory(w http.ResponseWriter, r *http.Request) {
	var dto DTO.CreateCategoryDTO
	err := Http.ReadBody(r, &dto)

	if err != nil {
		Http.SendErrorJsonResponse(
			http.StatusBadRequest,
			err,
			errors.New("Send bad request!"),
			w)
		return
	}

	err = Validator.ValidateCreateCategory(dto)

	if err != nil {
		Http.SendErrorJsonResponse(
			http.StatusBadRequest,
			err,
			errors.New("Send bad request!"),
			w)
		return
	}

	id, err := UseCase.CreateCategory(dto)

	if err != nil {
		Http.SendErrorJsonResponse(
			http.StatusInternalServerError,
			err,
			errors.New("Internal sever error!"),
			w)
		return
	}

	Http.SendCustomJsonResponse(http.StatusOK, Presenter.CreateCategory(id), w)
}

func AddBookToCategories(w http.ResponseWriter, r *http.Request) {
	var dto DTO.AddBookToCategoriesDTO
	err := Http.ReadBody(r, &dto)

	if err != nil {
		Http.SendErrorJsonResponse(
			http.StatusBadRequest,
			err,
			errors.New("Send bad request!"),
			w)
		return
	}

	err = UseCase.AddBookToCategories(dto)

	if err != nil {
		Http.SendErrorJsonResponse(
			http.StatusInternalServerError,
			err,
			errors.New("Internal sever error!"),
			w)
		return
	}

	Http.SendCustomJsonResponse(http.StatusOK, Presenter.AddBookToCategories(), w)
}

func CheckExistCategory(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	dto := DTO.CategoryNameDTO{Name: vars["name"]}

	result, err := Query.CheckExistCategory(dto)

	if err != nil {
		Http.SendErrorJsonResponse(
			http.StatusInternalServerError,
			err,
			errors.New("Internal sever error!"),
			w)
		return
	}

	Http.SendCustomJsonResponse(http.StatusOK, Presenter.CheckExist(result), w)
}

func FindAllCategories(w http.ResponseWriter, r *http.Request) {
	result, err := Query.FindAllCategories()

	if err != nil {
		Http.SendErrorJsonResponse(
			http.StatusInternalServerError,
			err,
			errors.New("Internal sever error!"),
			w)
		return
	}

	Http.SendCustomJsonResponse(http.StatusOK, Presenter.FindAll(result), w)
}
