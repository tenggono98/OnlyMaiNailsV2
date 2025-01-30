<?php

namespace App\Livewire\V2;

use App\Models\SettingWeb;
use Livewire\Component;

class Homepage extends Component
{
    public $data_homepage ;
    public $settingWeb;

    public function mount()
    {
        $this->settingWeb = SettingWeb::all();
        $this->data_homepage = [
            'address' => $this->settingWeb->where('name', '=', 'Address')->first()->value ?? '',
            'gmapslinks' => $this->settingWeb->where('name', '=', 'gmapsLinks')->first()->value ?? '',
            'instagram'=> $this->settingWeb->where('name', '=', 'instagram')->first()->value ?? '',
            'email'=> $this->settingWeb->where('name', '=', 'PaymentEmail')->first()->value ?? '',
        ];
    }
    public function render()
    {
        return view('livewire.v2.homepage');
    }
}
