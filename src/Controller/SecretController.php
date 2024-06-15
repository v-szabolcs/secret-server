<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/v1', name: 'app_secret_')]
class SecretController extends AbstractController
{
    #[Route(path: '/secret', name: 'post', methods: ['POST'])]
    public function post(): Response
    {
        return $this->json(['test' => 'post route'], 200);
    }

    #[Route(path: '/secret/{hash}', name: 'get', methods: ['GET'])]
    public function get(): Response
    {
        return $this->json(['test' => 'get route'], 200);
    }
}
