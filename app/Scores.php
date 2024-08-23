<?php

namespace App;

use Illuminate\Support\Facades\Cache;


class Scores
{
    static private $trm = "terminal-score";
    static private $lar = "laracon-score";

    static public function terminalScore()
    {
        return Cache::get(self::$trm);
    }

    static public function incrementTerminalScore($count)
    {
        Cache::increment(self::$trm, $count);
    }

    static public function resetTerminalScore()
    {
        Cache::put(self::$trm, 0);
    }

    static public function laraconScore()
    {
        return Cache::get(self::$lar);
    }

    static public function incrementLaraconScore($count)
    {
        Cache::increment(self::$lar, $count);
    }

    static public function resetLaraconScore()
    {
        Cache::put(self::$lar, 0);
    }
}
