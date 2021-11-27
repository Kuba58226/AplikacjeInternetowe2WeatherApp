<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinksController extends AbstractController
{
    /**
     * @Route("/links", name="links")
     */
    public function index(): Response
    {
        return $this->render('links/index.html.twig', [
            'controller_name' => 'LinksController',
        ]);
    }
}
