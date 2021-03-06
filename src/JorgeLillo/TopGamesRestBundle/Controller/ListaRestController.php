<?php

namespace JorgeLillo\TopGamesRestBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JorgeLillo\TopGamesBundle\Entity\Usuario;
use JorgeLillo\TopGamesBundle\Entity\Lista;

class ListaRestController extends FOSRestController {

     /**
     * Get all the list form application, by default it will return a json object.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all lists",
     * )
     * 
     * @Rest\View
     */
    public function allAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('TopGamesBundle:Lista')->findAll();
        return array('listas' => $entities);
    }

     /**
     * Get a list by id form application, by default it will return a json object.
     *
     * @ApiDoc(
     *  description="Returns a list",
     *  parameters={
     *      {"name"="{id}", "dataType"="integer", "required"=true, "description"="list id"}
     *  }
     * )
     * 
     * @Rest\View
     */
    public function getAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('TopGamesBundle:Lista')->find($id);
        
        if (!$entity instanceof Lista) {
            throw new NotFoundHttpException('List not found');
        }
      
        return array('lista' => $entity);
    }

       /**
     * Search for lists given a criteria, by default it will return a json object.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Search for lists",
     * )
     * 
     * @Rest\View
     */
    public function searchAction($search) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository("TopGamesBundle:Lista")->createQueryBuilder('o')
                ->where('o.nombre LIKE  :search')
                ->setParameter('search', '%' . $search . '%')
                ->getQuery()
                ->getResult();
        
        if (count($entities) == 0) {
            throw new NotFoundHttpException('No list found for ' . $search);
        }

        return array('listas' => $entities);
    }
    
    
       /**
     * Return the user's lists, by default it will return a json object.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get user's lists",
     * )
     * 
     * @Rest\View
     */
    public function getByUserAction($idUser) {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('TopGamesBundle:Usuario')->find($idUser);
        
        if (!$usuario instanceof Usuario) {
            throw new NotFoundHttpException('User not found');
        }
        
        $sql = 'SELECT lista.id '
                . 'FROM lista AS lista '
                . 'WHERE lista.id_usuario = ' . $usuario->getId();
        
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();
        $listasId = $statement->fetchAll();

        $listasList = array();
        foreach ($listasId as $idLista) {
            $lista = $em->getRepository('TopGamesBundle:Lista')->find($idLista);
            array_push($listasList, $lista);
        } 

        return array('user' => $usuario, 'listas' => $listasList);
    }
    

}
