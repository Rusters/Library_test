<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $categ = $this->getDoctrine()
            ->getRepository(Categories::class)
            ->findAll();
        if (!$categ) {
            throw $this->createNotFoundException(
                'No category found'
            );
        }
        return $this->render('category/category.html.twig',
            array('categ' => $categ)
        );
    }
}
