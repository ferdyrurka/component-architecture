<?php

namespace App\Component\Book\UI\Form;

use App\Component\Category\API\CategoryApiInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CreateBookForm extends AbstractType
{
    private CategoryApiInterface $categoryApi;

    public function __construct(CategoryApiInterface $categoryApi)
    {
        $this->categoryApi = $categoryApi;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Regex('/^([a-z|A-Z|0-9| |.,-]){1,255}$/'),
                ]
            ])
            ->add('category_ids', ChoiceType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new GreaterThan(['value' => 0])
                ],
                'multiple' => true,
                'choices' => ($this->categoryApi->findAll())->getArrayCategories()
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'create.book.token',
        ]);
    }
}
