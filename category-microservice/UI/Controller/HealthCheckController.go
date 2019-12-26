package Controller

import (
	"ferdyrurka/category/Infrastructure/Http"
	"net/http"
)

func CheckHealth(w http.ResponseWriter, r *http.Request) {
	jsonResponse := Http.JsonResponse{
		HttpCode: http.StatusOK,
		Body: Http.JsonBody{Success:true, Result: "Working"},
	}

	Http.SendJsonResponse(jsonResponse, w)
}
