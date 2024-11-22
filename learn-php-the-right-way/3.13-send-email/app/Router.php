<?php
    
    declare(strict_types=1);
    
    namespace SendEmail;
    
    use ReflectionAttribute;
    use ReflectionClass;
    use ReflectionException;
    use SendEmail\Attributes\Route;
    use SendEmail\Exceptions\RouteNotFoundException;
    
    class Router
    {
        
        private array $routes = [];
        
        public function __construct(private readonly Container $container) {}
        
        /**
         * @throws \SendEmail\Exceptions\RouteNotFoundException
         */
        public function registerRoutesFromControllerAttributes(array $controllers): void
        {
            foreach ($controllers as $controller) {
                try {
                    $reflectionController = new ReflectionClass($controller);
                } catch (ReflectionException $e) {
                    throw new RouteNotFoundException($e->getMessage(), $e->getCode(), $e);
                }
                
                foreach ($reflectionController->getMethods() as $method) {
                    $attributes = $method->getAttributes(Route::class, ReflectionAttribute::IS_INSTANCEOF);
                    
                    foreach ($attributes as $attribute) {
                        /**@var$route Route */
                        $route = $attribute->newInstance();
                        
                        $this->register($route->getMethod(), $route->getPath(), [$controller, $method->getName()]);
                    }
                }
            }
        }
        
        public function register(string $requestMethod, string $route, callable|array $action): self
        {
            $this->routes[$requestMethod][$route] = $action;
            
            return $this;
        }
        
        public function get(string $route, callable|array $action): self
        {
            return $this->register('get', $route, $action);
        }
        
        public function post(string $route, callable|array $action): self
        {
            return $this->register('post', $route, $action);
        }
        
        public function routes(): array
        {
            return $this->routes;
        }
        
        /**
         * @throws \SendEmail\Exceptions\RouteNotFoundException
         * @throws \Psr\Container\ContainerExceptionInterface
         * @throws \Psr\Container\NotFoundExceptionInterface
         */
        public function resolve(string $requestUri, string $requestMethod)
        {
            $route  = explode('?', $requestUri)[0];
            $action = $this->routes[$requestMethod][$route] ?? null;
            
            if (!$action) {
                throw new RouteNotFoundException();
            }
            
            if (is_callable($action)) {
                return call_user_func($action);
            }
            
            [$class, $method] = $action;
            
            if (class_exists($class)) {
                $class = $this->container->get($class);
                
                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
            
            throw new RouteNotFoundException();
        }
        
    }
