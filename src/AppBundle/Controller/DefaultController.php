<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets list of movies",
     *   output = "Array",
     *   authentication = false,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     * 
     */
    public function getMoviesAction()
    {
//      if(!$this->isGranted("ROLE_ADMIN")){
//        
//      }
      //$this->denyAccessUnlessGranted('ROLE_ADMIN');
      
      $data = $this->getDoctrine()->getRepository("AppBundle:Movie")->findAll();
      return $this->handleView($this->view($data));
    }
    
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Create Movie",
     *   output = "Array",
     *   authentication = false,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     * 
     */
    public function postMoviesAction(Request $request)
    {
      $content = json_decode($request->getContent());
      $em = $this->getDoctrine()->getManager();
      if(empty($content)){
        return new \Symfony\Component\HttpFoundation\Response("error with the data", 401);
      }
      
      try {
        
          $movie = new \AppBundle\Entity\Movie();
          $movie->setBorrowed(false);
          $movie->setTitle($content->title);
          $movie->setYear($content->year);
          $em->persist($movie);
          $em->flush();
          
      } catch (Exception $exc) {
          return new \Symfony\Component\HttpFoundation\Response("error with the data", 401);
      }
      
      
      return $this->handleView($this->view($movie))->setStatusCode(201);
    }
    
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Get one movie",
     *   output = "Array",
     *   authentication = false,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     * 
     */
    public function getMovieAction($id)
    { 
      try {
        
        $movie = $this->getDoctrine()->getRepository("AppBundle:Movie")->find($id);
        return $this->handleView($this->view($movie));  
          
      } catch (Exception $exc) {
          return new \Symfony\Component\HttpFoundation\Response("resource not found", 404);
      }
    }
    
    
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Put movie",
     *   output = "Array",
     *   authentication = false,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     * 
     */
    public function putMovieAction($id)
    { 
      try {
        
        $movie = $this->getDoctrine()->getRepository("AppBundle:Movie")->find($id);
        if(!($movie instanceof \AppBundle\Entity\Movie)){
          return new \Symfony\Component\HttpFoundation\Response("Resource not found", 404);
        }
        
        try {
            $em = $this->getDoctrine()->getManager();
            
            $content = json_decode($this->getRequest()->getContent());
            $movie->setTitle($content->title);
            $movie->setYear($content->year);
            $movie->setBorrowed($content->borrowed);
            
            $em->persist($movie);
            $em->flush();
            
        } catch (Exception $exc) {
          return new \Symfony\Component\HttpFoundation\Response("something got broken", 401);
        }  
      } catch (Exception $exc) {
          return new \Symfony\Component\HttpFoundation\Response("something got broken", 401);
      }
      
      return $this->handleView($this->view($movie)); 
    }
    
}
