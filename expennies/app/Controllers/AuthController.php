<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

readonly class AuthController
{

    public function __construct(
        private Twig $twig,
        private EntityManager $em
    ) {}

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function loginView(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'auth/login.twig');
    }

    public function logIn(Request $request, Response $response): Response
    {
        var_dump($request->getParsedBody());

        return $response;
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function registerView(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'auth/register.twig');
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $password       = $data['password'];
        $hashedPassword = password_hash(
            $password,
            PASSWORD_BCRYPT,
            ['cost' => 12]
        );

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($hashedPassword);

        $this->em->persist($user);
        $this->em->flush();

        return $response;
    }

}
