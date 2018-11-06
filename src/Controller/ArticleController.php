<?php

namespace App\Controller;

use App\Entity\Article;
use FOS\RestBundle\Controller\FOSRestController;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class ArticleController extends AbstractController
{
    /**
     * @Rest\Get("article/{id}")
     */
    public function article($id)
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(Article::class);
        $article = $repository->find($id);

        if (empty($article)){
            $response_status  = Response::HTTP_BAD_GATEWAY;
        }else{
            $response_status  = Response::HTTP_OK;
        }
        return $this->json([
            $article,
            $response_status
        ]);
    }

    /**
     * @Rest\Put("/article/{id}")
     */
    public function articleUpdate($slug, Request $request)
    {

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(Article::class);

        $article = $repository->find($slug);
        //var_dump($article);

        if (empty($article)){
            $response_status  = Response::HTTP_BAD_GATEWAY;

        }else{
            $name = $request->get('name');
            $description = $request->get('description');
            $article->setName($name);
            $article->setDescription($description);
            $em = $doctrine->getManager();
            $em->persist($article);
            $em->flush();

            $response_status  = Response::HTTP_OK;
        }
        return $this->json([
            $article,
            $response_status
        ]);
    }



    /**
     * @Rest\Get("/articles")
     */
    public function articles(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);


        if ($request->get('short')==1){
            $article = $repository->getShortData();
        }else{
            $article = $repository->getFullData();
        }

        return $this->json([
            $article
        ]);

    }


    /**
     * @Rest\Post("/article")
     * @param Request $request
     */
    public function postArticleAction(Request $request){

        $article = new Article();

        $name = $request->get('name');
        $description = $request->get('description');



        if (empty($name)){
            return new JsonResponse(['name is empty'], Response::HTTP_BAD_REQUEST);
        }
        elseif (empty($description)){
            return new JsonResponse(['description is empty'], Response::HTTP_BAD_REQUEST);
        }
        else{
            $article->setName($name);

            $article->setDescription($description);
            $article->setDateCreated( new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return new JsonResponse($article, Response::HTTP_CREATED);
        }

    }




}
