<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\UserProfileService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

readonly class ProfileController
{

    public function __construct(
        private Twig               $twig,
        private UserProfileService $userProfileService
    ) {}

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        /** @var \App\Entity\User $user */
        $user = $request->getAttribute('user');
        $data = [
            'profile' => $this->userProfileService->get($user->getId()),
        ];

        return $this->twig->render($response, 'profile/index.twig', $data);
    }

    public function update(Request $request, Response $response): Response
    {
        return $response;
    }

}
