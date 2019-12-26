package Presenter

import (
	"ferdyrurka/category/Infrastructure/Http"
	"net/http"
)

func CreateCustomError(err error, statusCode int, w http.ResponseWriter) {
	jsonResponse := Http.JsonResponse{
		HttpCode: statusCode,
		Body: Http.JsonBody{
			Result:  err.Error(),
			Success: false,
		},
	}

	Http.SendJsonResponse(jsonResponse, w)
}
