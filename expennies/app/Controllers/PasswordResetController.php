<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Exception\ValidationException;
use App\Mail\ForgotPasswordEmail;
use App\RequestValidators\ForgotPasswordRequestValidator;
use App\RequestValidators\ResetPasswordRequestValidator;
use App\Services\PasswordResetService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

readonly class PasswordResetController
{

    public function __construct(
        private Twig                             $twig,
        private RequestValidatorFactoryInterface $requestValidatorFactory,
        private UserProviderServiceInterface     $userProviderService,
        private PasswordResetService             $passwordResetService,
        private ForgotPasswordEmail              $forgotPasswordEmail,
    ) {}

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function showForgotPasswordForm(Response $response): Response
    {
        return $this->twig->render($response, 'auth/forgot_password.twig');
    }

    /**
     * @throws \Random\RandomException
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function handleForgotPasswordRequest(Request $request, Response $response): Response
    {
        $data = $this
            ->requestValidatorFactory
            ->make(ForgotPasswordRequestValidator::class)
            ->validate($request->getParsedBody());

        $user = $this->userProviderService->getByCredentials($data);

        if ($user) {
            $email = $data['email'];

            $this->passwordResetService->deactivateAllPasswordReset($email);
            $passwordReset = $this->passwordResetService->generate($email);
            $this->forgotPasswordEmail->sendLink($passwordReset);
        }

        return $response;
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function showResetPasswordForm(Response $response, array $args): Response
    {
        $token         = $args['token'];
        $passwordReset = $this->passwordResetService->findByToken($token);

        if (!$passwordReset) {
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        return $this->twig->render($response, 'auth/reset_password.twig', ['token' => $token]);
    }

    public function resetPassword(Request $request, Response $response, array $args): Response
    {
        $token = $args['token'];
        $data  = $this
            ->requestValidatorFactory
            ->make(ResetPasswordRequestValidator::class)
            ->validate($request->getParsedBody() + $args);

        $passwordReset = $this->passwordResetService->findByToken($token);
        if (!$passwordReset) {
            throw new ValidationException(['confirmPassword' => ['Invalid Token']]);
        }

        $user = $this->userProviderService->getByCredentials(['email' => $passwordReset->getEmail()]);
        if (!$user) {
            throw new ValidationException(['confirmPassword' => ['Invalid Token']]);
        }

        $this->passwordResetService->updatePassword($user, $data['password']);

        return $response;
    }

}
