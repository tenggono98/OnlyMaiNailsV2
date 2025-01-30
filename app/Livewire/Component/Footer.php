<?php

namespace App\Livewire\Component;

use App\Models\SettingWeb;
use Livewire\Component;

class Footer extends Component
{
    public $data_footer;

    public $settingWeb;

    public function mount()
    {
        $this->settingWeb = SettingWeb::all();
        $this->data_footer = [
            'instagram'=> $this->settingWeb->where('name', '=', 'instagram')->first()->value ?? '',
            'email'=> $this->settingWeb->where('name', '=', 'PaymentEmail')->first()->value ?? '',
        ];
    }

    public function render()
    {

       app('debugbar')->info( $this->data_footer);
        return view('livewire.component.footer');
    }
}
