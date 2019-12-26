package Http

import (
	"encoding/json"
	"io/ioutil"
	"net/http"
)

func ReadBody(r *http.Request, v interface{}) error {
	bodyJson, err := ioutil.ReadAll(r.Body)
	defer r.Body.Close()

	if err != nil {
		return err
	}

	err = json.Unmarshal(bodyJson, &v)

	if err != nil {
		return err
	}

	return nil
}

