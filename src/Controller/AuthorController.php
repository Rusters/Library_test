<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Authors;

/**
 * @Route("/author")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $aut = $this->getDoctrine()
            ->getRepository(Authors::class)
            ->findAll();
        if (!$aut) {
            throw $this->createNotFoundException(
                'No author found'
            );
        }
        dd($aut[0]->getBooks()->getValues());
        return $this->render('author/welcome.html.twig',
            array('aut' => $aut)
        );
    }
}
  