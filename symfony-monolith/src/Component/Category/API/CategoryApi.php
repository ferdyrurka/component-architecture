<?php
declare(strict_types=1);

namespace App\Component\Category\API;

use App\Component\Book\IO\BookIdInput;
use App\Component\Category\Exception\CategoryWasFoundException;
use App\Component\Category\Exception\RuntimeException;
use App\Component\Category\IO\CategoryIdInput;
use App\Component\Category\IO\CategoryIdOutput;
use App\Component\Category\IO\CategoryInput;
use App\Infrastructure\Microservices\Communication\CommunicationInterface;

class CategoryApi implements CategoryApiInterface
{
    private CommunicationInterface $communication;

    public function __construct(CommunicationInterface $communication)
    {
        $this->communication = $communication;
    }

    public function addBook(BookIdInput $bookIdInput, CategoryIdInput $categoryIdInput): void
    {

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
}
