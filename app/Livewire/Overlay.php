<?php

namespace App\Livewire;

use App\Scores;
use Livewire\Component;

class Overlay extends Component
{
    public function render()
    {
        return view('livewire.overlay', [
            'terminalScore' => Scores::terminalScore(),
            'laraconScore' => Scores::laraconScore(),
        ]);
    }
}
