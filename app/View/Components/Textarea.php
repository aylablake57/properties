<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $name;
    public $id;
    public $placeholder;
    public $value;
    public $maxlength;
    public $required;

    public function __construct($name, $id = null, $placeholder = '', $value = '', $maxlength = 1500, $required = true)
    {
        $this->name = $name;
        $this->id = $id ?? $name; // Default to the name if id is not provided
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->maxlength = $maxlength;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.textarea');
    }
}
