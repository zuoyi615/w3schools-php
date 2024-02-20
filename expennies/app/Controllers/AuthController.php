<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AuthInterface;
use App\DataObjects\RegisterUserData;
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
        private EntityManager $em,
        private AuthInterface $auth,
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
        $data      = $request->getParsedBody();
        $validator = new Validator($data);
        $validator->rule('required', ['email', 'password',]);
        $validator->rule('email', 'email');

        $success = $this->auth->attemptLogin($data);
        if (!$success) {
            throw new ValidationException(['password' => ['You have entered an invalid username or password']]);
        }

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

        $userData = new RegisterUserData(
            name: $data['name'],
            email: $data['email'],
            password: $data['password']
        );
        $this->auth->register($userData);

        return $response->withHeader('Location', '/')->withStatus(302);
    }

    public function logout(Request $request, Response $response): Response
    {
        $this->auth->logout();

        return $response->withHeader('Location', '/login')->withStatus(302);
    }

}
