<?php
declare(strict_types=1);

namespace App\Component\Category\API;

use App\Component\Book\IO\BookIdInput;
use App\Component\Category\Exception\CategoryApiException;
use App\Component\Category\Exception\CategoryWasFoundException;
use App\Component\Category\Exception\RuntimeException;
use App\Component\Category\IO\CategoriesIdsInput;
use App\Component\Category\IO\CategoriesOutput;
use App\Component\Category\IO\CategoryIdOutput;
use App\Component\Category\IO\CategoryInput;
use App\Infrastructure\Microservices\Communication\CommunicationInterface;

final class CategoryApi implements CategoryApiInterface
{
    private CommunicationInterface $communication;

    public function __construct(CommunicationInterface $communication)
    {
        $this->communication = $communication;
    }

    public function addBookToCategories(BookIdInput $bookIdInput, CategoriesIdsInput $categoriesIdsInput): void
    {
        $result = $this->communication->post(
            'add-book-to-categories',
            [
                'categoryIds' => $categoriesIdsInput->getCategoriesIds(),
                'bookId' => $bookIdInput->getBookId(),
            ]
        );

        if (!isset($result['success']) || (bool) $result['success'] === false) {
            throw new CategoryApiException(
                sprintf(
                    'Failed add book to categories for book id %s.
                    Category microservices return: %s',
                    $bookIdInput->getBookId(),
                    json_encode($result, JSON_THROW_ON_ERROR, 512)
                )
            );
        }
    }

    public function createCategory(CategoryInput $categoryInput): CategoryIdOutput
    {
        $resultCheckExist = $this->communication->get('check-exist-category/' . $categoryInput->getName());

        if (!isset($resultCheckExist['result'])) {
            throw new RuntimeException(
                'createCategory',
                'check-exist-category',
                sprintf('Result not found in response! Response content: %s', json_encode($resultCheckExist))
            );
        }

        if ((bool) $resultCheckExist['result']) {
            throw new CategoryWasFoundException($categoryInput->getName());
        }

        $resultCreate = $this->communication->post('create-category', ['name' => $categoryInput->getName()]);

        if (!isset($resultCreate['id'])) {
            throw new RuntimeException(
                'createCategory',
                'create-category',
                sprintf('Result id not found in response! Response content: %s', json_encode($resultCreate))
            );
        }

        return new CategoryIdOutput((string) $resultCreate['id']);
    }

    public function findAll(): CategoriesOutput
    {
        $allCategories = $this->communication->get('find-all');

        if (!isset($allCategories['result'], $allCategories['success']) || $allCategories['success'] === false) {
            throw new RuntimeException(
                'findAll',
                'find-all',
                sprintf(
                    'Internal server error with category api! Response content: %s',
                    json_encode($allCategories, JSON_THROW_ON_ERROR, 512)
                )
            );
        }

        $categoriesOutput = new CategoriesOutput();

        foreach ($allCategories['result'] as $category) {
            $categoriesOutput->addCategory($category['Id'], $category['Name']);
        }

        return $categoriesOutput;
    }
}
