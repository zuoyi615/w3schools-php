<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\UserProviderServiceInterface;
use App\Mail\SignupEmail;
use App\ResponseFormatter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RuntimeException;
use Slim\Views\Twig;

readonly class VerifyController
{
    
    public function __construct(
        private Twig                         $twig,
        private UserProviderServiceInterface $userProviderService,
        private SignupEmail                  $signupEmail,
        private ResponseFormatter            $formatter,
    ) {}
    
    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function index(Request $request, Response $response): Response
    {
        /** @var \App\Entity\User $user */
        $user = $request->getAttribute('user');
        if (!$user->getVerifiedAt()) {
            return $this->twig->render($response, 'auth/verify.twig');
        }
        
        return $response->withHeader('Location', '/')->withStatus(302);
    }
    
    public function verify(Request $request, Response $response, array $args): Response
    {
        /** @var \App\Entity\User $user */
        $user = $request->getAttribute('user');
        
        $idsNotEquals    = !hash_equals((string)$user->getId(), $args['id']);
        $emailsNotEquals = !hash_equals(sha1($user->getEmail()), $args['hash']);
        if ($idsNotEquals || $emailsNotEquals) {
            throw new RuntimeException('Verification failed');
        }
        
        if (!$user->getVerifiedAt()) {
            $this->userProviderService->verifyUser($user);
            
            return $response->withHeader('Location', '/')->withStatus(302);
        }
        
        return $this->formatter->asJson(
            response: $response->withStatus(401),
            data    : [
                'ok'      => false,
                'message' => $user->getName().' is already verified.',
            ]
        );
    }
    
    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function resend(Request $request, Response $response): Response
    {
        $this->signupEmail->sendTo($request->getAttribute('user'));
        
        return $response;
    }
    
}
