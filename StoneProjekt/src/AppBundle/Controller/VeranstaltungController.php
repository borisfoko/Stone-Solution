<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class VeranstaltungController extends Controller
{
    /**
     * @Route("/ver_list", name="ver_list")
     * @return Response
     */
    public function veranstaltungAction()
    {
        return $this->render('veranstaltung/veranstaltungen.html.twig',
            array(
                // ...
            )
        );
    }
}
