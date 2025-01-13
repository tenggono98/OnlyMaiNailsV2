<?php

namespace App\Livewire\NewUI;

use App\Models\ReviewUser;
use Livewire\Component;

class Homepage extends Component
{
    public function render()
    {
         // Review Data
         $review = ReviewUser::where('is_show_review','=',1)->where('status','=',1)->take(3)->get();
        return view('livewire.new-u-i.homepage',compact('review'));
    }
}
