<?php
    
    declare(strict_types=1);
    
    namespace SendEmail\Attributes;
    
    use SendEmail\Contracts\RouteInterface;
    use SendEmail\Enums\HttpMethod;
    use Attribute;
    
    #[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
    readonly class Route implements RouteInterface
    {
        
        public function __construct(private string $path, private HttpMethod $method = HttpMethod::Get) {}
        
        public function getPath(): string
        {
            return $this->path;
        }
        
        public function getMethod(): string
        {
            return $this->method->value;
        }
        
    }
