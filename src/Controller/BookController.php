<?php

namespace App\Controller;

use App\Entity\Authors;
use App\Entity\Books;
use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->render('book/book.html.twig',
            array('book' => $book)
        );
    }
    /**
     * @Route("/bookAdd", name="bookAdd", methods={"GET"})
     */
    public function bookAdd(): Response
    {
        $author = $this->getDoctrine()
            ->getRepository(Authors::class)
            ->findAll();
        $category = $this->getDoctrine()
            ->getRepository(Categories::class)
            ->findAll();
        return $this->render('book/bookAdd.html.twig',
            array('author' => $author, 'category' => $category)
        );
    }

    public function getData(Request $request){
        return json_decode($request->getContent(), true);
    }
    /**
     * @Route("/bookAdd", name="bookAddAjax", methods={"POST"})
     */
    public function bookAddAjax(Request $request)
    {
        $photo = $request->files->get('file');
        $author = $this->getDoctrine()
            ->getRepository(Authors::class)
            ->findOneBy([
                "name" => $request->get('aut')
            ]);
        $category = $this->getDoctrine()
            ->getRepository(Categories::class)
            ->findOneBy([
                "name" => $request->get('cat')
            ]);
        $dir = $this->getParameter('files_folder').'/photos';
        $photo->move($dir, $photo->getClientOriginalName());
        $em = $this->getDoctrine()->getManager();
        $book = new Books();
        $book->setName($request->get('text'));
        $book->setPhoto("/photos/".$photo->getClientOriginalName());
        $book->addAuthors($author);
        $book->addCategories($category);
        $em->persist($book);
        $em->flush();
        return $this->json([
            "message" => "ok",
            "book_id" => $book->getId()
        ], 200);
    }
    /**
     * @Route("/{id}", name="bookRemoveAjax", methods={"DELETE"})
     */
    public function bookRemoveAjax(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Books::class)->find($id);
        $authors = $em->getRepository(Authors::class)->findAll();
        $category = $em->getRepository(Categories::class)->findAll();
        if(!empty($book)) {
            foreach ($authors as $a)
                $a->removeBooks($book);
            foreach ($category as $c)
                $c->removeBooks($book);
            $em->remove($book);
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
     * @Route("/bookEdit/{id}", name="bookEditAjax", methods={"GET"})
     */
    public function bookEditAjax(Request $request, int $id)
    {
        $book = $this->getDoctrine()->getRepository(Books::class)->find($id);
        if(!$book)
            throw $this->createNotFoundException(
                'No author found for name '.$book->getName()
            );
        return $this->render('book/bookEdit.html.twig',
            array('book' => $book)
        );
    }
    /**
     * @Route("/bookEdit", name="bookEditAddAjax", methods={"POST"})
     */
    public function bookEditAddAjax(Request $request)
    {
        $photo = $request->files->get('file');
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Books::class)->findOneBy([
            "id" => $request->get('id')
        ]);
        $dir = $this->getParameter('files_folder').'/photos';
        $photo->move($dir, $photo->getClientOriginalName());
        $book->setName($request->get('text'));
        $book->setPhoto("/photos/".$photo->getClientOriginalName());
        $em->persist($book);
        $em->flush();
        return $this->json([
            "message" => "ok",
            "author_id" => $book->getId()
        ], 200);
    }
}
