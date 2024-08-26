<?php
namespace App;

$mods = [
    "nightshadedude" => true,
    "beastco" => false,
    "samhuckabee" => true,
    "theprimeagen" => true,
    "teej_dv" => true,
];

class PPPredictionOption {
    public string $option;
    public int $points;

    function __construct(string $option) {
        $this->option = $option;
        $this->points = 0;
    }
}

class PPPrediction {
    public string $prediction;
    /** @var Array<PPPredictionOption> */
    public array $options;

    // !p !ntehountehou !noehunoetuh
    function __construct(PPMessage $msg) {
        $options = explode("!", $msg->text);
    }
}

class PPUserPrediction {
    public int $points = 0;
    public int $option = 0;
    public bool $resolved = false;

    function __construct($points, $option) {
        $this->points = $points;
        $this->option = $option;
        $this->resolved = false;
    }
}

class PPUser {
    public string $name = "";
    public int $points = 0;
    /** @var Array<string, PPUserPrediction> */
    public array $predictions = [];

    function __construct(string $name) {
        $this->name = $name;
        $this->points = 1000;
        $this->predictions = [];
    }

    public function predict(PPPrediction $pred, int $point, int $option) {
        if ($prev = $this->predictions[$pred->prediction]) {
            if ($prev->resolved) {
                return;
            }
            $this->points += $prev->points;
            $pred->options[$option]->points -= $prev->points;
        }

        $pointsBet = min($point, $this->points);
        if ($pointsBet == 0) {
            return;
        }

        $this->points -= $pointsBet;
        $this->predictions[$pred->prediction] = new PPUserPrediction($pointsBet, $option);
        $pred->options[$option]->points += $pointsBet;
    }

    public function resolve(PPPrediction $pred, int $winningOption, int $winningTotalPoints) {
        if ($winningTotalPoints == 0) {
            return;
        }

        if ($our = $this->predictions[$pred->prediction]) {
            if ($our->resolved) {
                return;
            }
            if ($our->option == $winningOption) {
                $this->points += floor(
                    ($our->points /
                    $pred->options[$winningOption]->points) *
                    $winningTotalPoints);
            }
            $our->resolved = true;
        }
    }
}

class PPMessage {
    public string $text;
    public string $from;
    public bool $super;
    public string $cmd;
    public int $pointsPredicted;

    function __construct(string $from, string $text) {
        global $mods;
        $this->from = $from;
        $this->text = $text;

        $lower = strtolower($from);
        $this->super = isset($mods[$lower]) && $mods[$lower];

        if (strlen($text) < 2) {
            $this->cmd = "NONE";
        } else {
            $this->cmd = explode(" ", substr($text, 1), 2)[0];
        }

        $this->pointsPredicted = 0;
        switch ($this->cmd) {
            case "1":
            case "2":
            case "3":
            case "4":
            case "5":
                $items = explode(" ", $text);
                if (count($items) !== 2) {
                    $this->pointsPredicted = 0;
                    return;
                }
                $this->pointsPredicted = intval($items[1]);
        }
    }

    function isValid() {
        if (!str_starts_with($this->text, "!")) {
            return false;
        }

        $isModMessage = $this->cmd == "p";
        if ($isModMessage && $this->super) {
            return true;
        }

        switch ($this->cmd) {
            case "1":
            case "2":
            case "3":
            case "4":
            case "5":
                return $this->pointsPredicted > 0;
            case "c":
                return $this->text === "!c";
            case "help":
                return $this->text === "!help me i am poor";
        }
        return false;
    }
}

class PP {
    /** @var Array<string, PPUser> */
    public array $users;
    function __construct() {
        $this->users = [];
    }

    function getUser(string $from) {
        if (!isset($this->users[$from])) {
            $this->users[$from] = new PPUser($from);
        }

        return $this->users[$from];
    }

    public function pushMessage(string $from, string $text) {
        $msg = new PPMessage($from, $text);
        $usr = $this->getUser($from);

        if (!$msg->isValid()) {
            return "";
        }

        if ($msg->cmd == "c") {
            return "@" . $msg->from . ": " . $usr->points;
        }

        if ($msg->cmd == "p") {
        }
    }
}

?>
