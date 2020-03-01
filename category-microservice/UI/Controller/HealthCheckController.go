package Controller

import (
	"ferdyrurka/category/Infrastructure/Http"
	"ferdyrurka/category/Infrastructure/Repository"
	"net/http"
)

func CheckHealth(w http.ResponseWriter, r *http.Request) {
	if !Repository.NewCategoryRepository().PingCategoryDatabase() {
		jsonResponse := Http.JsonResponse{
			HttpCode: http.StatusOK,
			Body: Http.JsonBody{Success:false, Result: "Not working"},
		}

		Http.SendJsonResponse(jsonResponse, w)

		return
	}

	jsonResponse := Http.JsonResponse{
		HttpCode: http.StatusOK,
		Body: Http.JsonBody{Success:true, Result: "Working"},
	}

	Http.SendJsonResponse(jsonResponse, w)
}
