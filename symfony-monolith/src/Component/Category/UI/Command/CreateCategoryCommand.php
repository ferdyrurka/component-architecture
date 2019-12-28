<?php
declare(strict_types=1);

namespace App\Component\Category\UI\Command;

use App\Component\Category\API\CategoryApiInterface;
use App\Component\Category\IO\CategoryInput;
use App\Component\Category\IO\CategoryNameInput;
use App\Component\Category\UI\Validator\CategoryValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCategoryCommand extends Command
{
    private const CATEGORY_NAME_ARG = 'name';

    private CategoryApiInterface $categoryApi;

    private CategoryValidator $categoryValidator;

    public function __construct(CategoryApiInterface $categoryApi, CategoryValidator $categoryValidator)
    {
        $this->categoryApi = $categoryApi;
        $this->categoryValidator = $categoryValidator;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('monolith:category:create');
        $this->setDescription('This command is used for create category. Return category id or error.');
        $this->addArgument(self::CATEGORY_NAME_ARG, InputArgument::REQUIRED, 'Name category');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $categoryName = $input->getArgument(self::CATEGORY_NAME_ARG);

        if ($this->categoryValidator->validateName($categoryName)) {
            $output->writeln('Category is not valid!');
            return 0;
        }

        $categoryInput = new CategoryInput($categoryName);
        $categoryIdOutput = $this->categoryApi->createCategory($categoryInput);

        $output->writeln('New category id is: ' . $categoryIdOutput->getCategoryId());
        return 1;
    }
}
