<?php

namespace App\Livewire;

use App\Scores;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Adam extends Component
{
    public function render()
    {
        /* dd(Cache::get('prediction_options')); */
        /* $options = Cache::get('prediction_options')->map(function ($option) { */
        /*     return $option->option; */
        /* }); */
        /* dd($options); */

        $options = Cache::get('prediction_options', []);
        $totalPoints = 1;
        foreach ($options as $option) {
            $totalPoints += $option["points"];
        }

        foreach ($options as $option) {
            $option["percentage"] = $option["points"] / $totalPoints * 100;
        }

        return view('livewire.adam', [
            'terminalScore' => Scores::terminalScore(),
            'laraconScore' => Scores::laraconScore(),
            'message_count' => Cache::get('message_count'),
            'prompt' => Cache::get('prediction_prompt'),
            'options' => $options,
            'totalPoints' => $totalPoints,
        ]);
    }
}
