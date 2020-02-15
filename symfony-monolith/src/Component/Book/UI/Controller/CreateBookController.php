<?php

namespace App\Component\Book\UI\Controller;

use App\Component\Book\API\BookApiInterface;
use App\Component\Book\IO\BookInput;
use App\Component\Book\UI\Form\CreateBookForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateBookController extends AbstractController
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/create-book", methods={"GET"})
     * @Template("book/create-book.html.twig")
     */
    public function createView(Request $request): array
    {
        $form = $this->createForm(CreateBookForm::class, new BookInput('', []));
        $form->handleRequest($request);

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @param Request $request
     * @param BookApiInterface $bookApi
     * @return Response
     *
     * @Route("/create-book", methods={"POST"})
     */
    public function create(Request $request, BookApiInterface $bookApi): Response
    {
        $form = $this->createForm(CreateBookForm::class, new BookInput('', []));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookApi->createBook($form->getData());

            return $this->redirect('/');
        }

        return $this->forward(__CLASS__ . '::createView', [
            'request' => $request,
        ]);
    }
}
