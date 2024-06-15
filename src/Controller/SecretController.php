<?php

namespace App\Controller;

use App\Service\SecretService;
use App\Validator\ObjectValidator;
use App\Mapper\SecretPayloadMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/v1', name: 'app_secret_')]
class SecretController extends AbstractController
{
    public function __construct(
        private SecretPayloadMapper $secretPayloadMapper,
        private ObjectValidator $objectValidator,
        private SecretService $secretService,
    ) {
    }

    #[Route(path: '/secret', name: 'post', methods: ['POST'])]
    public function post(Request $request): Response
    {
        $payload = $request->request;

        try {
            $secretPayloadDTO = $this->secretPayloadMapper->map(
                $payload->get('secret'),
                $payload->get('expireAfterViews'),
                $payload->get('expireAfter'),
            );
        } catch (\TypeError) {
            return $this->json(['test' => 'invalid input'], 405);
        }

        if (!$this->objectValidator->isValid($secretPayloadDTO)) {
            return $this->json(['test' => 'invalid input'], 405);
        }

        try {
            $secretDTO = $this->secretService->create($secretPayloadDTO);
        } catch (\TypeError) {
            return $this->json(['test' => 'invalid input'], 405);
        }

        return $this->json($secretDTO, 200);
    }

    #[Route(path: '/secret/{hash}', name: 'get', methods: ['GET'])]
    public function get(): Response
    {
        return $this->json(['test' => 'get route'], 200);
    }
}
