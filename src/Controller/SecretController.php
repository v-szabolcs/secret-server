<?php

namespace App\Controller;

use App\Service\SecretService;
use App\Factory\ResponseFactory;
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
        private ResponseFactory $responseFactory,
    ) {
    }

    #[Route(path: '/secret', name: 'post', methods: ['POST'])]
    public function post(Request $request): Response
    {
        $acceptHeader = $request->headers->get('accept');

        $payload = $request->request;

        try {
            $secretPayloadDTO = $this->secretPayloadMapper->map(
                $payload->get('secret'),
                $payload->get('expireAfterViews'),
                $payload->get('expireAfter'),
            );
        } catch (\TypeError) {
            return $this->responseFactory->build(['error' => 'Invalid input'], 405, [], $acceptHeader);
        }

        if (!$this->objectValidator->isValid($secretPayloadDTO)) {
            return $this->responseFactory->build(['error' => 'Invalid input'], 405, [], $acceptHeader);
        }

        $secretDTO = $this->secretService->create($secretPayloadDTO);

        return $this->responseFactory->build($secretDTO, 200, [], $acceptHeader);
    }

    #[Route(path: '/secret/{hash}', name: 'get', methods: ['GET'])]
    public function get(string $hash, Request $request): Response
    {
        $acceptHeader = $request->headers->get('accept');

        $secretDTO = $this->secretService->get($hash);

        if (!$secretDTO) {
            return $this->responseFactory->build(['error' => 'Secret not found'], 404, [], $acceptHeader);
        }

        return $this->responseFactory->build($secretDTO, 200, [], $acceptHeader);
    }
}
