package Http

import (
	"encoding/json"
	"ferdyrurka/category/Infrastructure/Config"
	"log"
	"net/http"
)

type JsonResponse struct {
	Body JsonBody
	HttpCode int
}

type JsonBody struct {
	Success      bool
	Result       string
}

func SendJsonResponse(jr JsonResponse, w http.ResponseWriter)  {
	SendCustomJsonResponse(jr.HttpCode, jr.Body, w)
}

func SendCustomJsonResponse(code int, v interface{}, w http.ResponseWriter) {
	b, err := json.Marshal(v)
	if err != nil {
		http.Error(w, "Internal server error", http.StatusInternalServerError)
		log.Println("Error JsonResponse with message: " + err.Error())
		return
	}

	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(code)
	_, _ = w.Write(b)
}

func SendErrorJsonResponse(code int, err error, prodErr error, w http.ResponseWriter) {
	var r JsonResponse
	if Config.GetConfig().Environment != "prod" {
		r = JsonResponse{
			HttpCode: code,
			Body: JsonBody{
				Result:  err.Error(),
				Success: false,
			},
		}
	} else {
		r = JsonResponse{
			HttpCode: code,
			Body: JsonBody{
				Result:  prodErr.Error(),
				Success: false,
			},
		}
	}

	SendJsonResponse(r, w)
}
