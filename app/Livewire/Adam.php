<?php

namespace App\Livewire;

use App\Scores;
use Livewire\Component;

class Adam extends Component
{
    public function render()
    {
        return view('livewire.adam', [
            'terminalScore' => Scores::terminalScore(),
            'laraconScore' => Scores::laraconScore(),
        ]);
    }
}
