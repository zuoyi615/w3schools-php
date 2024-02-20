<?php

namespace App\Middleware;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class AuthenticationMiddleware implements MiddlewareInterface
{

    public function __construct(private EntityManager $em) {}

    #[Override]
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $id = $_SESSION['user'];
        if (!empty($id)) {
            $user = $this->em->getRepository(User::class)->find($id);
            if (!empty($user)) {
                $request = $request->withAttribute('user', $user);
            }
        }

        return $handler->handle($request);
    }

}
