<?php

namespace App\Middleware;

use App\Contracts\AuthInterface;
use App\Contracts\EntityManagerServiceInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class AuthMiddleware implements MiddlewareInterface
{
    
    public function __construct(
        private Twig                          $twig,
        private ResponseFactoryInterface      $factory,
        private AuthInterface                 $auth,
        private EntityManagerServiceInterface $em,
    ) {}
    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($user = $this->auth->getUser()) {
            $this->twig->getEnvironment()->addGlobal('auth', [
                'id'   => $user->getId(),
                'name' => $user->getName(),
            ]);
            
            $this
                ->em
                ->enableUserAuthFilter($user->getId());
            
            $request = $request->withAttribute('user', $user);
            
            return $handler->handle($request);
        }
        
        $this->auth->logout();
        
        return $this
            ->factory
            ->createResponse(302)
            ->withHeader('Location', '/login');
    }
    
}
