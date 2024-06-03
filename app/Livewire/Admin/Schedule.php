<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Schedule extends Component
{
    public function render()
    {
        return view('livewire.admin.schedule')->layout('components.layouts.app-admin');
    }
}
