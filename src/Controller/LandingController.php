<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LandingController extends AbstractController
{
    #[Route('/app/{reactRouting?}', name: 'react_landing', requirements: ['reactRouting' => '.*'])]
    public function reactLanding(): Response
    {
        return $this->render('pages/landing/react_home.html.twig');
    }
}
