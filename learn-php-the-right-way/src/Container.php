<?php

    declare(strict_types=1);

    namespace App;

    use App\Exceptions\Container\{ContainerException, NotFoundException};
    use Psr\Container\ContainerInterface;
    use ReflectionClass;
    use ReflectionException;
    use ReflectionNamedType;
    use ReflectionParameter;
    use ReflectionUnionType;

    class Container implements ContainerInterface
    {

        private array $entries = [];

        public function entries(): array
        {
            return $this->entries;
        }

        /**
         * @throws ReflectionException
         * @throws ContainerException|NotFoundException
         */
        public function get(string $id)
        {
            if (!$this->has($id)) {
                return $this->resolve($id);
            }

            $entry = $this->entries[$id];
            if (is_callable($entry)) {
                return $entry($this);
            }

            return $this->resolve($entry);
        }

        public function has(string $id): bool
        {
            return isset($this->entries[$id]);
        }

        /**
         * @throws ReflectionException
         * @throws ContainerException
         * @throws NotFoundException
         */
        public function resolve(string $id): mixed
        {
            try {
                $reflectionClass = new ReflectionClass($id);
            } catch (ReflectionException $e) {
                throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
            }

            if (!$reflectionClass->isInstantiable()) {
                throw new ContainerException("Class $id is not instantiable");
            }

            $constructor = $reflectionClass->getConstructor();
            if ($constructor === null) {
                return new $id();
            }

            $parameters = $constructor->getParameters();
            if (count($parameters) === 0) {
                return new $id();
            }

            $dependencies = array_map(function (ReflectionParameter $parameter) use ($id) {
                $name = $parameter->getName();
                $type = $parameter->getType();
                if ($type === null) {
                    throw new ContainerException(
                      "Failed to resolve class $id, because param $name is messing a type hint"
                    );
                }

                if ($type instanceof ReflectionUnionType) {
                    throw new ContainerException(
                      "Failed to resolve class $id, because of union type for param $name is messing a type hint"
                    );
                }

                if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new ContainerException("Failed to resolve class $id, because of invalid param $name ");
            }, $parameters);

            return $reflectionClass->newInstanceArgs($dependencies);
        }

        public function set(string $id, callable|string $concrete): void
        {
            $this->entries[$id] = $concrete;
        }
    }
