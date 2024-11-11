<?php
    
    declare(strict_types=1);
    
    namespace Abstraction;
    
    class Checkbox extends Field
    {
        
        public function render(): string
        {
            return <<<Input
<input type="checkbox" name="$this->name" />
Input;
        }
        
    }
