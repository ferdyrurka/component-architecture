package Presenter

func CreateCategory(id string) map[string]interface{} {
	b := make(map[string]interface{})
	b["success"] = true
	b["id"] = id

	return b
}

func CheckExist(count int) map[string]interface{} {
	b := make(map[string]interface{})
	b["success"] = true
	b["result"] = count

	return b
}
