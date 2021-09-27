<?php

namespace App\Controller;

use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Books::class)
            ->findAll();
        if (!$book) {
            throw $this->createNotFoundException(
                'No book found'
            );
        }
        return $this->render('book/book.html.twig',
            array('book' => $book)
        );
    }
}
