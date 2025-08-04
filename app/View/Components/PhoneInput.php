<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PhoneInput extends Component
{
    public $name;
    public $id;
    public $placeholder;
    public $value;
    public $maxlength;
    public $required;


    /**
     * Create a new component instance.
     *
     * @param string $name
     * @return void
     */
    public function __construct($name, $id = null, $placeholder = '', $value = '', $required = true)
    {
        $this->name = $name;
        $this->id = $id ?? $name; // Default to the name if id is not provided
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.phone-input');
    }
}
