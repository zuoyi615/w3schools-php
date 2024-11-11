<?php
    
    declare(strict_types=1);
    
    namespace Abstraction;
    
    class Text extends Field
    {
        
        // keep same arguments as parent class, but can own default value argument
        public function render(string $value = 'Hello'): string
        {
            return <<<Input
<input type="text" name="$this->name" value="$value" />
Input;
        }
        
    }
