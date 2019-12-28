package Controller

import (
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
		Presenter.CreateCustomError(err, http.StatusBadRequest, w)
		return
	}

	err = Validator.ValidateCreateCategory(dto)

	if err != nil {
		Presenter.CreateCustomError(err, http.StatusBadRequest, w)
		return
	}

	id, err := UseCase.CreateCategory(dto)

	if err != nil {
		Presenter.CreateCustomError(err, http.StatusBadRequest, w)
		return
	}

	Http.SendCustomJsonResponse(http.StatusOK, Presenter.CreateCategory(id), w)
}

func CheckExistCategory(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	dto := DTO.CategoryNameDTO{Name: vars["name"]}

	result, err := UseCase.CheckExistCategory(dto)

	if err != nil {
		http.Error(w, "Internal server error", http.StatusInternalServerError)
		return
	}

	Http.SendCustomJsonResponse(http.StatusOK, Presenter.CheckExist(result), w)
}
