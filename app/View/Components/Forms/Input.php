<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $label;
    public $required;
    public $value;
    public $id;
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $label = null,
        $required = false,
        $value = null,
        $id = null,
        $type = 'text'
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        $this->value = $value;
        $this->id = $id;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.input');
    }
}
