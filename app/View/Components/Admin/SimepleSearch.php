<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SimpleSearch extends Component
{
    public string $name;
    public string $placeholder;
    public string $label;
    public ?string $hint;
    public string $action;
    public bool $autofocus;

    public function __construct(
        string $name = 'q',
        string $placeholder = 'Search...',
        string $label = 'Search',
        ?string $hint = null,
        ?string $action = null,
        bool $autofocus = false,
    ) {
        $this->name        = $name;
        $this->placeholder = $placeholder;
        $this->label       = $label;
        $this->hint        = $hint;
        $this->action      = $action ?: url()->current();
        $this->autofocus   = $autofocus;
    }

    public function currentValue(): string
    {
        return (string) request($this->name, '');
    }

    public function render(): View
    {
        return view('components.admin.simple-search');
    }
}
