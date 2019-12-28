package Presenter

import "ferdyrurka/category/Domain/Entity"

func CreateCategory(id string) map[string]interface{} {
	b := make(map[string]interface{})
	b["success"] = true
	b["id"] = id

	return b
}

func CheckExist(result bool) map[string]interface{} {
	b := make(map[string]interface{})
	b["success"] = true
	b["result"] = result

	return b
}

func FindAll(categories *[]Entity.Category) map[string]interface{} {
	b := make(map[string]interface{})
	b["success"] = true
	b["result"] = categories

	return b
}
