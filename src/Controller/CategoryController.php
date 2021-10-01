<?php

namespace App\Controller;

use App\Entity\Authors;
use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function getData(Request $request){
        return json_decode($request->getContent(), true);
    }
    /**
     * @Route("/categoryAdd", name="categoryAdd", methods={"GET"})
     */
    public function categoryAdd(): Response
    {
        return $this->render('category/categoryAdd.html.twig');
    }
    /**
     * @Route("/categoryAdd", name="categoryAddAjax", methods={"POST"})
     */
    public function categoryAddAjax(Request $request)
    {
        $content = $this->getData($request);
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Categories::class)->findOneBy([
            "name" => $content["name"]
        ]);
        if(empty($category)){
            $category = new Categories();
            $category->setName($content["name"]);
            $em->persist($category);
            $em->flush();
            return $this->json([
                "message" => "ok",
                "category_id" => $category->getId()
            ], 200);
        }
        else {
            return $this->json("error", 500);
        }
    }
    /**
     * @Route("/categoryEdit/{id}", name="categoryEditAjax", methods={"GET"})
     */
    public function categoryEditAjax(Request $request, int $id)
    {
        $category = $this->getDoctrine()->getRepository(Categories::class)->find($id);
        if(!$category)
            throw $this->createNotFoundException(
                'No author found for name '.$category->getName()
            );
        return $this->render('category/categoryEdit.html.twig',
            array('category' => $category)
        );
    }
    /**
     * @Route("/categoryEdit", name="categoryEditAddAjax", methods={"PUT"})
     */
    public function categoryEditAddAjax(Request $request)
    {
        $content = $this->getData($request);
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Categories::class)->findOneBy([
            "id" => $content["id"]
        ]);
        $category->setName($content["name"]);
        $em->persist($category);
        $em->flush();
        return $this->json([
            "message" => "ok",
            "category_id" => $category->getId()
        ], 200);
    }
    /**
     * @Route("/{id}", name="categoryRemoveAjax", methods={"DELETE"})
     */
    public function categoryRemoveAjax(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Categories::class)->find($id);
        if($category) {
            $em->remove($category);
            $em->flush();
            return $this->json([
                "message" => "ok"
            ], 200);
        }
        else {
            return $this->json("error", 500);
        }
    }
}
