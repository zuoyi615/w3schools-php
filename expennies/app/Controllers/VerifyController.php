<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\UserProviderServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RuntimeException;
use Slim\Views\Twig;

readonly class VerifyController
{

    public function __construct(private Twig $twig, private UserProviderServiceInterface $userProviderService) {}

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function index(Response $response): Response
    {
        return $this->twig->render($response, 'auth/verify.twig');
    }

    public function verify(Request $request, Response $response, array $args): Response
    {
        /** @var \App\Entity\User $user */
        $user = $request->getAttribute('user');

        $idsNotEquals    = !hash_equals((string) $user->getId(), $args['id']);
        $emailsNotEquals = !hash_equals(sha1($user->getEmail()), $args['hash']);
        if ($idsNotEquals || $emailsNotEquals) {
            throw new RuntimeException('Verification failed');
        }

        if (!$user->getVerifiedAt()) {
            $this->userProviderService->verifyUser($user);
        }

        return $response->withHeader('Location', '/')->withStatus(302);
    }

}
