<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Authors;
use App\Entity\Books;

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
        $em = $this->getDoctrine()->getManager();
        return $this->render('author/welcome.html.twig',
            array('aut' => $aut)
        );
    }
    /**
     * @Route("/authorAdd", name="add_author", methods={"GET"})
     */
    public function authorAdd(): Response
    {
        return $this->render('author/authorAdd.html.twig');
    }
    public function getData(Request $request){
        return json_decode($request->getContent(), true);
    }
    /**
     * @Route("/authorAdd", name="authorAddAjax", methods={"POST"})
     */
    public function authorAddAjax(Request $request)
    {
        $content = $this->getData($request);
        $em = $this->getDoctrine()->getManager();
        $author = $em->getRepository(Authors::class)->findOneBy([
            "name" => $content["name"]
        ]);
        if(empty($author)){
            $author = new Authors();
            $author->setName($content["name"]);
            $em->persist($author);
            $em->flush();
            return $this->json([
                "message" => "ok",
                "author_id" => $author->getId()
            ], 200);
        }
        else {
            return $this->json("error", 500);
        }
    }
    /**
     * @Route("/authorEdit/{id}", name="authorEditAjax", methods={"GET"})
     */
    public function authorEditAjax(Request $request, int $id)
    {
        $author = $this->getDoctrine()->getRepository(Authors::class)->find($id);
        if(!$author)
            throw $this->createNotFoundException(
                'No author found for name '.$author->getName()
            );
        return $this->render('author/authorEdit.html.twig',
            array('author' => $author)
        );
    }
    /**
     * @Route("/authorEdit", name="authorEditAddAjax", methods={"PUT"})
     */
    public function authorEditAddAjax(Request $request)
    {
        $content = $this->getData($request);
        $em = $this->getDoctrine()->getManager();
        $author = $em->getRepository(Authors::class)->findOneBy([
            "id" => $content["id"]
        ]);
        //$author = new Authors();
        $author->setName($content["name"]);
        $em->persist($author);
        $em->flush();
        return $this->json([
            "message" => "ok",
            "author_id" => $author->getId()
        ], 200);
    }
    /**
     * @Route("/{id}", name="authorRemoveAjax", methods={"DELETE"})
     */
    public function authorRemoveAjax(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $author = $em->getRepository(Authors::class)->find($id);
        /*foreach ($em->getRepository(Books::class)->findAll as $b){
            $book = $em->getRepository(Books::class)->findBy([
                "id.authors" => $author
            ]);
        }*/
        $author->getBooks()->;
        if($author) {
            $em->remove($author);
            $em->flush();
            return $this->json([
                "message" => "ok"
            ], 200);
        }
        else {
            return $this->json("error", 500);
        }
    }
    /**
     * @Route("/{id}", name="authorAllBooks", methods={"GET"})
     */
    public function authorAllBooks(int $id)
    {
        $author = $this->getDoctrine()
            ->getRepository(Authors::class)
            ->find($id);
        return $this->render('author/authorAllBooks.html.twig',
            array('author' => $author)
        );
    }
}
  