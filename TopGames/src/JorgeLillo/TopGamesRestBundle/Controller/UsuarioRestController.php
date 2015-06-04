<?php

namespace JorgeLillo\TopGamesRestBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JorgeLillo\TopGamesBundle\Entity\Usuario;
use Symfony\Component\HttpFoundation\Request;

class UsuarioRestController extends FOSRestController {

    /**
     * Get all the users form application, by default it will return a json object.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all users from application",
     * )
     * 
     * @Rest\View
     */
    public function allAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('TopGamesBundle:Usuario')->findAll();
        return array('users' => $entities);
    }

     /**
     * Get a user by id form application, by default it will return a json object.
     *
     * @ApiDoc(
     *  description="Returns an user",
     *  parameters={
     *      {"name"="{id}", "dataType"="integer", "required"=true, "description"="list id"}
     *  }
     * )
     * 
     * @Rest\View
     */
    public function getAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TopGamesBundle:Usuario')->find($id);

        if (!$entity instanceof Usuario) {
            throw new NotFoundHttpException('User not found');
        }

        return array('user' => $entity);
    }

    /**
     * @ApiDoc(
     *  description="Login method",
     *  parameters={
     *      {"name"="user", "dataType"="string", "required"=true, "description"="user name"},
     *      {"name"="pass", "dataType"="string", "required"=true, "description"="pass of the account"}
     *  }
     * )
     * 
     * @Rest\View
     */
    public function loginAction(Request $request) {
        $checkLogin = false;
        $userName = $request->get('user');
        $pass = $request->get('pass');
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('TopGamesBundle:Usuario')->findByUsername($userName);

        if ($user) {
            if (password_verify($pass, $user[0]->getPassword())) {
                $checkLogin = true;
            }
        }

        return array('login' => $checkLogin, 'idUser' => $user[0]->getId());
    }

}
