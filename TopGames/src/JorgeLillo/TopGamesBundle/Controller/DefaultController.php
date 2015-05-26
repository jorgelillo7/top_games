<?php

namespace JorgeLillo\TopGamesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JorgeLillo\TopGamesBundle\Form\JuegoType;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('TopGamesBundle:Default:index.html.twig');
    }

    public function buscarAction(Request $request) {
        $search = $request->get('nombre');
         
        $em = $this->getDoctrine()->getEntityManager(); 
       $repository = $em->getRepository('TopGamesBundle:Juego');
       $query = $repository->createQueryBuilder('p')
               ->where('p.titulo LIKE :word')
               //->orWhere('p.discription LIKE :word')
               ->setParameter('word', '%'.$search.'%')
               ->getQuery();
$entities = $query->getResult();

        foreach ($entities as $juego) {
            $juego->setListaPlataformas($this->getListaPlataformas($juego->getId()));
        }

        //Pagination
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render(
                        'TopGamesBundle:Default:searchList.html.twig', array(
                    'entities' => $pagination,
                    'cadena' => $search,
                        )
        );
    }

    public function masInfoAction() {
        return $this->render('TopGamesBundle:Default:masInfo.html.twig');
    }

    public function getListaPlataformas($id) {
        $em = $this->getDoctrine()->getManager();
        $idJuego = $id;
        $sql = 'SELECT plat.id '
                . 'FROM plataforma AS plat '
                . 'INNER JOIN juego_plataforma AS jp ON plat.id = jp.id_plataforma '
                . 'AND jp.id_juego = ' . $idJuego;
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();
        $plataformasId = $statement->fetchAll();

        $listaPlataformas = array();
        foreach ($plataformasId as $valor) {
            $plataforma = $em->getRepository('TopGamesBundle:Plataforma')->find($valor);
            array_push($listaPlataformas, $plataforma);
        }

        return $listaPlataformas;
    }

}
