<?php

namespace App\Livewire\Component;


use Livewire\Component;
use App\Livewire\Actions\Logout;



class Header extends Component
{
    public function render()
    {
        return view('livewire.component.header');
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}
