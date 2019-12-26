package Validator

import (
	"errors"
	"ferdyrurka/category/UI/DTO"
	"regexp"
)

func ValidateCreateCategory(dto DTO.CreateCategoryDTO) error {
	return validateName(dto.Name)
}

func validateName(name string) error {
	regexName := regexp.MustCompile("^[A-Z|a-z| |0-9|-]{1,255}$")

	if !regexName.MatchString(name) {
		return errors.New("Invalidate name variable with name value: '" + name + "'")
	}

	return nil
}
