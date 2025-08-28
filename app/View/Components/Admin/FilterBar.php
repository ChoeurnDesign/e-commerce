<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class FilterBar extends Component
{
    /**
     * Array of field definition arrays.
     * Each field supports keys:
     * name (string, required)
     * type (text|select|select-multi|date|number|boolean)
     * label (string)
     * placeholder (string)
     * options (array) for select(s)
     * step, min, max, true_label, false_label, size (optional)
     */
    public array $fields;
    public string $action;
    public string $method;

    public function __construct(array $fields = [], string $action = '', string $method = 'GET')
    {
        $this->fields = $fields;
        $this->action = $action ?: url()->current();
        $this->method = strtoupper($method) === 'POST' ? 'POST' : 'GET';
    }

    public function render()
    {
        return view('components.admin.filter-bar');
    }
}
