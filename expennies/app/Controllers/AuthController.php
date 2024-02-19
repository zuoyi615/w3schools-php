<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entity\User;
use App\Exception\ValidationException;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Valitron\Validator;

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

    public function login(Request $request, Response $response): Response
    {
        // 1. Validate the request data
        $data      = $request->getParsedBody();
        $validator = new Validator($data);
        $validator->rule('required', ['email', 'password',]);
        $validator->rule('email', 'email');

        // 2. Check user the credentials
        $user = $this
            ->em
            ->getRepository(User::class)
            ->findOneBy(['email' => $data['email']]);
        if(!$user) {
            throw new ValidationException('');
        }

        // 3. Save user's id in the session

        // 4. Redirect the user to the home page
        return $response->withHeader('Location', '/')->withStatus(302);
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

        $validator = new Validator($data);
        $validator->rule(
            'required',
            ['name', 'email', 'password', 'confirmPassword']
        );
        $validator->rule('email', 'email');
        $validator
            ->rule('equals', 'confirmPassword', 'password')
            ->label('Confirm Password');
        $validator
            ->rule(function ($field, $value) {
                return !$this
                    ->em
                    ->getRepository(User::class)
                    ->count(['email' => $value]);
            }, 'email')
            ->message('User with the given email address already exists.');
        if ($validator->validate()) {
            echo "all fields are valid.";
        } else {
            throw new ValidationException($validator->errors());
        }

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

    public function logout(Request $request, Response $response): Response
    {
        var_dump($request->getParsedBody());

        return $response;
    }

}
