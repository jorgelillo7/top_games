<?php

namespace JorgeLillo\TopGamesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JorgeLillo\TopGamesBundle\Entity\Juego;
use JorgeLillo\TopGamesBundle\Entity\JuegoPlataforma;
use JorgeLillo\TopGamesBundle\Entity\ListaJuego;
use JorgeLillo\TopGamesBundle\Form\JuegoType;

/**
 * Juego controller.
 *
 */
class JuegoController extends Controller {

    /**
     * Lists all Juego entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TopGamesBundle:Juego')->findAll();

        foreach ($entities as $juego) {
            $juego->setListaPlataformas($this->getListaPlataformas($juego->getId()));
        }

        //Pagination
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('TopGamesBundle:Juego:index.html.twig', array(
                    'entities' => $pagination,
        ));
    }

    /**
     * Creates a new Juego entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Juego();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->upload();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('juego_show', array('id' => $entity->getId())));
        }

        return $this->render('TopGamesBundle:Juego:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Juego entity.
     *
     */
    public function newAction() {
        $entity = new Juego();
        $form = $this->createCreateForm($entity);

        return $this->render('TopGamesBundle:Juego:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Juego entity.
     *
     */
    public function showAction(Request $request, $id) {
        $usuarioId = null;

        $error = $request->get('error');
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TopGamesBundle:Juego')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Juego entity.');
        }

        $listaPlataformas = $this->getListaPlataformas($entity->getId());

        if ($this->get('security.context')->getToken()->getUser() != "anon.") {
            $usuarioId = $this->get('security.context')->getToken()->getUser()->getId();
        }

        $repository = $em->getRepository('TopGamesBundle:Lista');
        $query = $repository->createQueryBuilder('l')
                ->where('l.idUsuario = :word')
                ->setParameter('word', $usuarioId)
                ->getQuery();
        $misListas = $query->getResult();

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TopGamesBundle:Juego:show.html.twig', array(
                    'entity' => $entity,
                    'listaPlataformas' => $listaPlataformas,
                    'misListas' => $misListas,
                    'error' => $error,
                    'userId' => $usuarioId,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Juego entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TopGamesBundle:Juego')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Juego entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TopGamesBundle:Juego:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Juego entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TopGamesBundle:Juego')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Juego entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->upload();
            $em->flush();

            return $this->redirect($this->generateUrl('juego_edit', array('id' => $id)));
        }

        return $this->render('TopGamesBundle:Juego:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Juego entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TopGamesBundle:Juego')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Juego entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('juego'));
    }

    public function juegoPlataformasAction($id) {
        $em = $this->getDoctrine()->getManager();
        $idJuego = $id;
        $juego = $em->getRepository('TopGamesBundle:Juego')->find($id);
        $plataformasAsociadas = $this->getListaPlataformas($idJuego);

        $plataformasTotales = $em->getRepository('TopGamesBundle:Plataforma')->findAll();

        $listaPlataformasSinDuplicados = array();
        foreach ($plataformasTotales as $plataformaLista) {
            $yaAsociado = false;
            foreach ($plataformasAsociadas as $plataformaAsociada) {
                if ($plataformaLista->getId() == $plataformaAsociada->getId()) {
                    $yaAsociado = true;
                }
            }

            if ($yaAsociado == false) {
                array_push($listaPlataformasSinDuplicados, $plataformaLista);
            }
        }


        return $this->render('TopGamesBundle:Juego:gestionplataformas.html.twig', array(
                    'idJuego' => $idJuego,
                    'juego' => $juego,
                    'plataformas' => $listaPlataformasSinDuplicados,
                    'plataformasAsociadas' => $plataformasAsociadas
        ));
    }

    public function plataforma_saveAction($idJuego, $idPlataforma) {

        $em = $this->getDoctrine()->getManager();

        $juego = $em->getRepository('TopGamesBundle:Juego')->find($idJuego);

        $juegoPlataforma = new JuegoPlataforma();
        $juegoPlataforma->setIdJuego($juego->getId());
        $juegoPlataforma->setIdPlataforma($idPlataforma);
        $em->persist($juegoPlataforma);
        $em->flush();


        return $this->redirect($this->generateUrl('juego_plataformas', array('id' => $idJuego)));
    }

    public function plataforma_deleteAction($idJuego, $idPlataforma) {

        $em = $this->getDoctrine()->getManager();

        $sql = 'SELECT jp.id '
                . 'FROM juego_plataforma AS jp '
                . 'WHERE jp.id_juego= ' . $idJuego . ' AND jp.id_plataforma = ' . $idPlataforma;

        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();
        $juegoplataformaId = $statement->fetchAll();
        $sqlDeletePlataforma = 'DELETE FROM juego_plataforma WHERE ID = ' . $juegoplataformaId[0]['id'];
        $statement2 = $em->getConnection()->prepare($sqlDeletePlataforma);
        $statement2->execute();

        return $this->redirect($this->generateUrl('juego_plataformas', array('id' => $idJuego)));
    }

    public function addToListAction(Request $request) {
        $idJuego = $request->get('idJuego');
        $idLista = $request->get('idList');

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('TopGamesBundle:ListaJuego');
        $query = $repository->createQueryBuilder('lj')
                ->where('lj.idJuego = :juego')
                ->andWhere('lj.idLista = :lista')
                ->setParameter('juego', $idJuego)
                ->setParameter('lista', $idLista)
                ->getQuery();
        $listaJuego = $query->getResult();

        if ($listaJuego == null) {
            $juego = $em->getRepository('TopGamesBundle:Juego')->find($idJuego);
            $lista = $em->getRepository('TopGamesBundle:Lista')->find($idLista);

            $listaJuego = new ListaJuego();
            $listaJuego->setIdJuego($juego->getId());
            $listaJuego->setIdLista($lista->getId());
            $em->persist($listaJuego);
            $em->flush();

            return $this->redirect($this->generateUrl('lista_show', array('id' => $idLista)));
        } else {
            return $this->redirect($this->generateUrl('juego_show', array('id' => $idJuego, 'error' => "-1")));
        }
    }

    /*************
      Private methods
     *************/

    /**
     * Creates a form to create a Juego entity.
     *
     * @param Juego $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Juego $entity) {
        $form = $this->createForm(new JuegoType(), $entity, array(
            'action' => $this->generateUrl('juego_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to delete a Juego entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('juego_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Borrar'))
                        ->getForm()
        ;
    }

    /**
     * Creates a form to edit a Juego entity.
     *
     * @param Juego $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Juego $entity) {
        $form = $this->createForm(new JuegoType(), $entity, array(
            'action' => $this->generateUrl('juego_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    private function getListaPlataformas($id) {
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
