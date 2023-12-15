<?php

  declare(strict_types=1);

  namespace DIContainer;

  use Psr\Container\ContainerInterface;
  use ReflectionClass;
  use ReflectionException;
  use ReflectionNamedType;
  use ReflectionParameter;
  use ReflectionUnionType;
  use DIContainer\Exceptions\Container\ContainerException;

  class Container implements ContainerInterface {

    private array $entries = [];

    /**
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function get(string $id) {
      if (!$this->has($id)) {
        return $this->resove($id);
      }

      $entry = $this->entries[$id];
      return $entry($this);
    }

    public function has(string $id): bool {
      return isset($this->entries[$id]);
    }

    /**
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function resove(string $id): mixed {
      // 1. Inspect the class that we are trying to get from the container
      $reflectionClass = new ReflectionClass($id);
      if (!$reflectionClass->isInstantiable()) {
        throw new ContainerException("Class $id is not instantiable");
      }

      // 2. Inspect the constructor of the class
      $constructor = $reflectionClass->getConstructor();
      if ($constructor === null) {
        return new $id();
        // return $reflectionClass->newInstance();
      }

      // 3. Inspect the constructor parameters (dependencies)
      $parameters = $constructor->getParameters();
      if (count($parameters) === 0) {
        return new $id();
      }

      // 4. If the constructor parameter is a class then try to resolve that class using the container
      $dependencies = array_map(function (ReflectionParameter $parameter) use ($id) {
        $name = $parameter->getName();
        $type = $parameter->getType();
        if ($type === null) {
          throw new ContainerException("Failed to resolve class $id, because param $name is messing a type hint");
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
  }
