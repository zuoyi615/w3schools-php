<?php

namespace App\RequestValidators;

use App\Contracts\RequestValidatorFactoryInterface as FactoryInterface;
use App\Contracts\RequestValidatorInterface;
use Psr\Container\ContainerInterface;
use RuntimeException;

readonly class RequestValidatorFactory implements FactoryInterface
{

    public function __construct(private ContainerInterface $c) {}

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function make(string $class): RequestValidatorInterface
    {
        $validator = $this->c->get($class);
        if ($validator instanceof RequestValidatorInterface) {
            return $validator;
        }

        throw new RuntimeException(
            'Failed to instantiate the request validator class `'
            .$class.
            '`'
        );
    }

}
