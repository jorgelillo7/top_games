<?php

namespace JorgeLillo\TopGamesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JorgeLillo\TopGamesBundle\Entity\Lista;
use JorgeLillo\TopGamesBundle\Form\ListaType;

/**
 * Lista controller.
 *
 */
class ListaController extends Controller {

    /**
     * Lists all Lista entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $usuarioId = $this->get('security.context')->getToken()->getUser()->getId();

        $repository = $em->getRepository('TopGamesBundle:Lista');
        $query = $repository->createQueryBuilder('l')
                ->where('l.idUsuario = :word')
                ->setParameter('word', $usuarioId)
                ->getQuery();
        $entities = $query->getResult();

        return $this->render('TopGamesBundle:Lista:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    public function indexAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('TopGamesBundle:Lista')->findAll();

        return $this->render('TopGamesBundle:Lista:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Lista entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Lista();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $usuario = $this->get('security.context')->getToken()->getUser();
            $entity->setIdUsuario($usuario->getId());
            $entity->setAutorOriginal($usuario->getUsername());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lista_show', array('id' => $entity->getId())));
        }

        return $this->render('TopGamesBundle:Lista:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Lista entity.
     *
     * @param Lista $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Lista $entity) {
        $form = $this->createForm(new ListaType(), $entity, array(
            'action' => $this->generateUrl('lista_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Lista entity.
     *
     */
    public function newAction() {
        $entity = new Lista();
        $form = $this->createCreateForm($entity);

        return $this->render('TopGamesBundle:Lista:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lista entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $lista = $em->getRepository('TopGamesBundle:Lista')->find($id);


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
        }


        if (!$lista) {
            throw $this->createNotFoundException('Unable to find Lista entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TopGamesBundle:Lista:show.html.twig', array(
                    'entity' => $lista,
                    'juegosAsociados' => $juegosList,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Lista entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TopGamesBundle:Lista')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lista entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TopGamesBundle:Lista:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Lista entity.
     *
     * @param Lista $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Lista $entity) {
        $form = $this->createForm(new ListaType(), $entity, array(
            'action' => $this->generateUrl('lista_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Lista entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TopGamesBundle:Lista')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lista entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lista_edit', array('id' => $id)));
        }

        return $this->render('TopGamesBundle:Lista:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lista entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TopGamesBundle:Lista')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lista entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lista'));
    }

    /**
     * Creates a form to delete a Lista entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('lista_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
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
    
    public function removeFromListAction($idJuego, $idLista){
         $em = $this->getDoctrine()->getManager();
            
            $repository = $em->getRepository('TopGamesBundle:ListaJuego');
              $query = $repository->createQueryBuilder('lj')
                ->where('lj.idJuego = :juego')
                 ->andWhere('lj.idLista = :lista')
                ->setParameter('juego', $idJuego)
                ->setParameter('lista', $idLista)
                ->getQuery();
            $listaJuego = $query->getSingleResult();
            
              $em->remove($listaJuego);
            $em->flush();
            
           return $this->redirect($this->generateUrl('lista_show', array('id' => $idLista)));
    }

}
