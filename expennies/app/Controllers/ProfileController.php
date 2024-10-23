<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\DataObjects\UserProfileData;
use App\Entity\User;
use App\RequestValidators\UpdatePasswordRequestValidator;
use App\RequestValidators\UpdateProfileRequestValidator;
use App\Services\PasswordResetService;
use App\Services\UserProfileService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

readonly class ProfileController
{

    public function __construct(
        private Twig                             $twig,
        private UserProfileService               $userProfileService,
        private RequestValidatorFactoryInterface $requestValidatorFactory,
        private PasswordResetService             $passwordResetService,
    ) {}

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        /** @var User $user */
        $user = $request->getAttribute('user');
        $data = [
            'profile' => $this->userProfileService->get($user->getId()),
        ];

        return $this->twig->render($response, 'profile/index.twig', $data);
    }

    public function update(Request $request, Response $response): Response
    {
        /** @var User $user */
        $user = $request->getAttribute('user');

        $data = $this
            ->requestValidatorFactory
            ->make(UpdateProfileRequestValidator::class)
            ->validate($request->getParsedBody());

        $this->userProfileService->update(
            $user,
            new UserProfileData(
                email    : $user->getEmail(),
                name     : $data['name'],
                twoFactor: (bool) $data['twoFactor'] ?? false
            )
        );

        return $response->withStatus(204);
    }

    public function updatePassword(Request $request, Response $response): Response
    {
        /** @var User $user */
        $user = $request->getAttribute('user');
        $data = $this
            ->requestValidatorFactory->make(UpdatePasswordRequestValidator::class)
            ->validate($request->getParsedBody() + ['user' => $user]);

        $this->passwordResetService->updatePassword($user, $data['newPassword']);

        return $response->withStatus(204);
    }

}
