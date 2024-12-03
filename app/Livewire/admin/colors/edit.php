<?php

namespace App\Livewire\Admin\Colors;

use App\Models\Vehiclecolor;
use Livewire\Component;

class Edit extends Component
{
    public $colorEdit;
    public $colors;
    //
    public $name;

    public function mount($colors)
    {
        $this->colorEdit = $colors->color_code;
        $this->name = $colors->name;
    }
    
    public function render()
    {
        return view('livewire.admin.colors.edit');
    }
}
