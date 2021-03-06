<?php

namespace JorgeLillo\TopGamesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JorgeLillo\TopGamesBundle\Entity\Plataforma;
use JorgeLillo\TopGamesBundle\Form\PlataformaType;

/**
 * Plataforma controller.
 *
 */
class PlataformaController extends Controller {

    /**
     * Lists all Plataforma entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TopGamesBundle:Plataforma')->findAll();

        //Pagination
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $entities, $request->query->get('page', 1)/* page number */, 10/* limit per page */
        );

        return $this->render('TopGamesBundle:Plataforma:index.html.twig', array(
                    'entities' => $pagination,
        ));
    }

    /**
     * Creates a new Plataforma entity.
     *
     */
    public function createAction(Request $request) {
        $nombre = $request->get('nombre');
        $color = $request->get('color');
        $letraBlanca = $request->get('letraBlanca');

        $entity = new Plataforma();
        $entity->setNombre($nombre);
        $entity->setColor($color);
        if ($letraBlanca == 'on') {
            $entity->setLetraBlanca(true);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('plataforma'));
    }

    /**
     * Displays a form to create a new Plataforma entity.
     *
     */
    public function newAction() {
        $entity = new Plataforma();
        $form = $this->createCreateForm($entity);

        return $this->render('TopGamesBundle:Plataforma:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Plataforma entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TopGamesBundle:Plataforma')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plataforma entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TopGamesBundle:Plataforma:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

  

    /**
     * Edits an existing Plataforma entity.
     *
     */
    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $idPlataforma = $request->get('id');
        $nombre = $request->get('nombre');
        $color = $request->get('color');
        $letraBlanca = $request->get('letraBlanca');

        $entity = $em->getRepository('TopGamesBundle:Plataforma')->find($idPlataforma);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plataforma entity.');
        }
        $entity->setNombre($nombre);
        $entity->setColor($color);
        if ($letraBlanca == 'on') {
            $entity->setLetraBlanca(true);
        } else {
            $entity->setLetraBlanca(false);
        }

        $em->persist($entity);
        $em->flush();

        $deleteForm = $this->createDeleteForm($idPlataforma);

        return $this->redirect($this->generateUrl('plataforma'));
    }

    /**
     * Deletes a Plataforma entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('TopGamesBundle:Plataforma')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plataforma entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('plataforma'));
    }

     /*************
      Private methods
     *************/
    
    /**
     * Creates a form to create a Plataforma entity.
     *
     * @param Plataforma $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Plataforma $entity) {
        $form = $this->createForm(new PlataformaType(), $entity, array(
            'action' => $this->generateUrl('plataforma_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    
     /**
     * Creates a form to edit a Plataforma entity.
     *
     * @param Plataforma $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Plataforma $entity) {
        $form = $this->createForm(new PlataformaType(), $entity, array(
            'action' => $this->generateUrl('plataforma_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Editar'));

        return $form;
    }
    
    /**
     * Creates a form to delete a Plataforma entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('plataforma_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Borrar'))
                        ->getForm()
        ;
    }

}
