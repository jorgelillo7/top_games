<?php

namespace JorgeLillo\TopGamesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TopGamesBundle:Default:index.html.twig');
    }
  
    public function masInfoAction()
    {
         return $this->render('TopGamesBundle:Default:masInfo.html.twig');
    }
}
