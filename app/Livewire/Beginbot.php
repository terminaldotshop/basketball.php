<?php

namespace App\Livewire;

use App\Scores;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;


class Beginbot extends Component
{
    public function incrementTerminal($value)
    {
        Scores::incrementTerminalScore($value);
    }

    public function decrementTerminal()
    {
        Scores::incrementTerminalScore(-1);
    }

    public function resetTerminal()
    {
        Scores::resetTerminalScore();
    }

    public function incrementLaracon($value)
    {
        Scores::incrementLaraconScore($value);
    }

    public function decrementLaracon()
    {
        Scores::incrementLaraconScore(-1);
    }

    public function resetLaracon()
    {
        Scores::resetLaraconScore();
    }


    public function render()
    {
        return view('livewire.beginbot', [
            'terminalScore' => Scores::terminalScore(),
            'laraconScore' => Scores::laraconScore(),
        ]);
    }
}
