<?php

namespace App\Livewire;

use App\Scores;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Overlay extends Component
{
    public function render()
    {
        return view('livewire.overlay', [
            'terminalScore' => Scores::terminalScore(),
            'laraconScore' => Scores::laraconScore(),
            'message_count' => Cache::get('message_count'),
            /* 'prompt' => Cache::get('prediction_prompt'), */
            'prompt' => 'Who misses the first shot',
            /* 'options' => Cache::get('prediction_options'), */
            'options' => ["Adam Almore", "ThDxr", "ThePrimeagen"],
        ]);
    }
}
