<?php

namespace App\Livewire\Admin\Colors;

use Livewire\Component;

class Create extends Component
{
    public $name;
    public $color_code = '#000000';
    public function render()
    {
        return view('livewire.admin.colors.create');
    }
}
