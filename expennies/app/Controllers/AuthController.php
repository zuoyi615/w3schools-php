<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AuthInterface;
use App\Contracts\RequestValidatorFactoryInterface;
use App\DataObjects\RegisterUserData;
use App\Enum\AuthAttemptStatus;
use App\Exception\ValidationException;
use App\RequestValidators\RegisterUserRequestValidator;
use App\RequestValidators\UserLoginRequestValidator;
use App\ResponseFormatter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

readonly class AuthController
{

    public function __construct(
        private Twig                             $twig,
        private RequestValidatorFactoryInterface $factory,
        private AuthInterface                    $auth,
        private ResponseFormatter                $formatter,
    ) {}

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function loginView(Response $response): Response
    {
        return $this->twig->render($response, 'auth/login.twig');
    }

    public function login(Request $request, Response $response): Response
    {
        $data = $this
            ->factory
            ->make(UserLoginRequestValidator::class)
            ->validate($request->getParsedBody());

        $loginStatus = $this->auth->attemptLogin($data);

        if ($loginStatus === AuthAttemptStatus::FAILED) {
            throw new ValidationException(['password' => ['You have entered an invalid username or password']]);
        }

        if ($loginStatus === AuthAttemptStatus::TWO_FACTOR_AUTH) {
            return $this->formatter->asJson($response, ['two_factor' => true]);
        }

        return $this->formatter->asJson($response, []);
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function registerView(Response $response): Response
    {
        return $this->twig->render($response, 'auth/register.twig');
    }

    public function register(Request $request, Response $response): Response
    {
        $data = $this->factory->make(RegisterUserRequestValidator::class)->validate($request->getParsedBody());

        $this->auth->register(
            new RegisterUserData(
                name    : $data['name'],
                email   : $data['email'],
                password: $data['password']
            )
        );

        return $response->withHeader('Location', '/')->withStatus(302);
    }

    public function logout(Response $response): Response
    {
        $this->auth->logout();

        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    public function twoFactorLogin(Request $request, Response $response): Response
    {
        $data = $this
            ->factory
            ->make(UserLoginRequestValidator::class)
            ->validate($request->getParsedBody());

        return $response;
    }

}
