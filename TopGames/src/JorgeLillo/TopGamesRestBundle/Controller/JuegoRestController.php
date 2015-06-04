<?php

namespace JorgeLillo\TopGamesRestBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JorgeLillo\TopGamesBundle\Entity\Juego;
use JorgeLillo\TopGamesBundle\Entity\Lista;

class JuegoRestController extends FOSRestController {

    
    /**
     * Get all the games form application, by default it will return a json object.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all games",
     * )
     * 
     * @Rest\View
     */
    public function allAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TopGamesBundle:Juego')->findAll();
        foreach ($entities as $juego) {
            $juego->setListaPlataformas($this->getListaPlataformas($juego->getId()));
            $juego->setImageBytes($this->getImageBytes($juego));
        }

        return array('juegos' => $entities);
    }

    /**
     * Get a games by id form application, by default it will return a json object.
     *
     * @ApiDoc(
     *  description="Returns a game",
     *  parameters={
     *      {"name"="{id}", "dataType"="integer", "required"=true, "description"="game id"}
     *  }
     * )
     * 
     * @Rest\View
     */
    public function getAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TopGamesBundle:Juego')->find($id);

        if (!$entity instanceof Juego) {
            throw new NotFoundHttpException('Juego not found');
        }

        $entity->setListaPlataformas($this->getListaPlataformas($entity->getId()));
        $entity->setImageBytes($this->getImageBytes($entity));

        return array('juego' => $entity);
    }

     /**
     * Search for games given a criteria, by default it will return a json object.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Search for games",
     * )
     * 
     * @Rest\View
     */
    public function searchAction($search) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository("TopGamesBundle:Juego")->createQueryBuilder('o')
                ->where('o.titulo LIKE  :search')
                ->setParameter('search', '%' . $search . '%')
                ->getQuery()
                ->getResult();
        if (count($entities) == 0) {
            throw new NotFoundHttpException('No games found for ' . $search);
        }

        foreach ($entities as $juego) {
            $juego->setListaPlataformas($this->getListaPlataformas($juego->getId()));
            $juego->setImageBytes($this->getImageBytes($juego));
        }

        return array('juegos' => $entities);
    }
    
     /**
     * Return the list's list of games, by default it will return a json object.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Search for games by list",
     * )
     * 
     * @Rest\View
     */
    public function getByListAction($idList) {
        $em = $this->getDoctrine()->getManager();
        $lista = $em->getRepository('TopGamesBundle:Lista')->find($idList);
        
        if (!$lista instanceof Lista) {
            throw new NotFoundHttpException('Lista not found');
        }
        
        $sql = 'SELECT juego.id '
                . 'FROM juego AS juego '
                . 'INNER JOIN lista_juego AS lj ON lj.id_juego = juego.id '
                . 'AND lj.id_lista = ' . $lista->getId();
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();
        $juegosAsociadosId = $statement->fetchAll();

        $juegosList = array();
        foreach ($juegosAsociadosId as $idJuego) {
            $juego = $em->getRepository('TopGamesBundle:Juego')->find($idJuego);
            array_push($juegosList, $juego);
        }

        foreach ($juegosList as $juego) {
            $juego->setListaPlataformas($this->getListaPlataformas($juego->getId()));
            $juego->setImageBytes($this->getImageBytes($juego));
        }
         

        return array('lista' => $lista, 'juegos' => $juegosList);
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

    public function getImageBytes($juego) {
        if ($juego->getPath() != null) {
            $filename = $juego->getAbsolutePath();
            $file = fopen($filename, "rb");
            $contents = fread($file, filesize($filename));
            fclose($file);

            return base64_encode($contents);
        }
    }

}
