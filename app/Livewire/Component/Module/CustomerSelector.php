<?php

namespace App\Livewire\Component\Module;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Modelable;

class CustomerSelector extends Component
{
    public $searchTerm = '';
    public $selectedCustomer = null;
    public $customers = [];
    #[Modelable]
    public $clientBook ;



    public function updatedSearchTerm()
    {
        $this->customers = User::where(function($query) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
        })->where('role', '=', 'user')
          ->get();
    }

    public function selectCustomer($customerId)
    {
        $this->clientBook = User::find($customerId)->toArray();
        $this->searchTerm = $this->clientBook['name'];
        $this->customers = [];

    }

    public function clearSelection()
    {
        $this->clientBook = null;
        $this->searchTerm = '';
        $this->customers = [];
    }


    public function render()
    {

        return view('livewire.component.module.customer-selector');
    }
}
