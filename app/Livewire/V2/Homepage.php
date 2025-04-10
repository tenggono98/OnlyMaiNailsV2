<?php

namespace App\Livewire\V2;

use App\Models\HomepageImage;
use App\Models\SettingWeb;
use Livewire\Component;

class Homepage extends Component
{
    public function render()
    {
        $settingWeb = SettingWeb::all();

        $data_homepage = [
            'gmapsLinks' => $settingWeb->where('name', '=', 'gmapsLinks')->first()?->value ?? '',
            'address' => $settingWeb->where('name', '=', 'Address')->first()?->value ?? '',
            'instagram' => $settingWeb->where('name', '=', 'instagram')->first()?->value ?? '',
            'email' => $settingWeb->where('name', '=', 'PaymentEmail')->first()?->value ?? '',
        ];

        $headerImages = HomepageImage::where('section', 'header')
            ->where('status', '1')
            ->orderBy('display_order')
            ->get();

        $promoImages = HomepageImage::where('section', 'promo')
            ->where('status', '1')
            ->orderBy('display_order')
            ->get();

        return view('livewire.v2.homepage', compact('data_homepage', 'headerImages', 'promoImages'));
    }
}
