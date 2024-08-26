<?php

namespace App;

class PPPredictionOption
{
    public string $option;
    public int $points;

    function __construct(string $option, int $points = 0)
    {
        $this->option = $option;
        $this->points = $points;
    }

    function __toString()
    {
        return "$this->option: $this->points";
    }
}

class PPPrediction
{
    public bool $valid;
    public string $prediction;
    /** @var Array<PPPredictionOption> */
    public array $options;

    // !p <time> !ntehountehou !noehunoetuh
    function __construct(PPMessage $msg)
    {
        $this->options = [];

        $options = explode("!", $msg->text);
        foreach (array_slice($options, 2) as $option) {
            array_push($this->options, new PPPredictionOption($option));
        }

        $this->valid = true;
        $this->prediction = substr($options[1], 2);
    }

    public function totalPoints()
    {
        $total = 0;
        foreach ($this->options as $option) {
            $total += $option->points;
        }
        return $total;
    }

    public function __toString()
    {
        $out = "PPPrediction: $this->prediction\n";
        foreach ($this->options as $option) {
            $out .= "$option\n";
        }
        return $out;
    }
}

class PPUserPrediction
{
    public int $points = 0;
    public int $option = 0;
    public bool $resolved = false;

    function __construct($points, $option)
    {
        $this->points = $points;
        $this->option = $option;
        $this->resolved = false;
    }

    function __toString()
    {
        return "PPUserPrediction($this->option): $this->points";
    }
}

class PPUser
{
    public string $name = "";
    public int $points = 0;
    /** @var Array<string, PPUserPrediction> */
    public array $predictions = [];

    function __construct(string $name)
    {
        $this->name = $name;
        $this->points = 1000;
        $this->predictions = [];
    }

    public function __toString()
    {
        return "user: $this->name -- $this->points";
    }

    public function predict(PPPrediction $pred, int $point, int $option)
    {
        if (isset($this->predictions[$pred->prediction]) && $prev = $this->predictions[$pred->prediction]) {
            if ($prev->resolved) {
                return;
            }
            $this->points += $prev->points;
            $pred->options[$prev->option]->points -= $prev->points;
        }

        $pointsBet = min($point, $this->points);
        if ($pointsBet == 0) {
            return;
        }

        if (count($pred->options) <= $option || $option < 0) {
            return;
        }

        $this->points -= $pointsBet;
        $this->predictions[$pred->prediction] = new PPUserPrediction($pointsBet, $option);
        $pred->options[$option]->points += $pointsBet;
    }

    public function resolve(PPPrediction $pred, int $winningOption)
    {
        $winningTotalPoints = $pred->totalPoints();
        if ($winningTotalPoints == 0) {
            return;
        }

        echo "for $this->name\n";
        foreach ($this->predictions as $k => $v) {
            echo "prediction: $k => $v\n";
        }

        if (isset($this->predictions[$pred->prediction]) && $our = $this->predictions[$pred->prediction]) {
            if ($our->resolved) {
                return;
            }
            if ($our->option == $winningOption) {
                $this->points += floor(
                    ($our->points /
                        $pred->options[$winningOption]->points) *
                        $winningTotalPoints
                );
            }
            $our->resolved = true;
        }
    }
}

class PPMessage
{
    public string $text;
    public string $from;
    public bool $super;
    public string $cmd;
    public int $pointsPredicted;
    public int $predictedIndex;


    public $mods = [
        "nightshadedude" => true,
        "beastco" => false,
        "samhuckabee" => true,
        "theprimeagen" => true,
        "teej_dv" => true,
    ];

    function __construct(string $from, string $text)
    {
        $text = trim($text);

        $this->from = $from;
        $this->text = trim($text);

        $lower = strtolower($from);
        $this->super = isset($this->mods[$lower]) && $this->mods[$lower];

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

        $this->predictedIndex = intval($this->cmd) - 1;
    }

    function __toString()
    {
        return "PPMessage($this->from, $this->text, $this->cmd, " . strval($this->super) . ")";
    }

    function isValid()
    {
        if (!str_starts_with($this->text, "!")) {
            return false;
        }

        $isModMessage = $this->cmd == "p" || $this->cmd == "r";
        if ($isModMessage && $this->super) {
            return true;
        } else if ($isModMessage) {
            return false;
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
            case "r":
                if (strlen($this->text) === 4) {
                    $parts = explode(" ", $this->text);
                    if (count($parts) == 2) {
                        return intval($parts[1]) > 0;
                    }
                }
        }
        return false;
    }
}

class PP
{
    /** @var Array<string, PPUser> */
    public array $users;

    public ?PPPrediction $prediction = NULL;

    function __construct()
    {
        $this->users = [];
        $this->prediction = NULL;
    }

    function getUser(string $from)
    {
        if (!isset($this->users[$from])) {
            $this->users[$from] = new PPUser($from);
        }

        return $this->users[$from];
    }

    public function pushMessage(string $from, string $text)
    {
        $msg = new PPMessage($from, $text);
        $usr = $this->getUser($from);
        echo "message: $msg\n";
        echo "user: $usr\n";

        if (!$msg->isValid()) {
            echo "NOT VALID";
            return "";
        }

        if ($msg->cmd == "c") {
            return "@" . $msg->from . ": " . $usr->points;
        }

        if ($msg->cmd == "p") {
            if ($this->prediction != NULL) {
                return "@" . $msg->from . ": there is an active prediction";
            }

            $pred = new PPPrediction($msg);
            if (!$pred->valid) {
                return "@" . $msg->from . ": Invalid prediction syntax";
            }

            $this->prediction = $pred;
            return "";
        }

        if ($msg->cmd == "r") {
            echo "HAYAYAYAYAYA";
            if ($this->prediction === NULL) {
                return "@" . $msg->from . ": there is no active prediction";
            }

            $winner = substr($msg->text, 3);
            echo "winner: \"$winner\"\n";
            $winner = intval($winner);
            if ($winner == 0) {
                return "@" . $msg->from . ": invalid r syntax e.g.: !r 1";
            }

            echo "predictions: " . count($this->prediction->options) . "\n";
            if (count($this->prediction->options) < $winner) {
                return "@" . $msg->from . ": FALIDE RESOLVE, Winner to large";
            }

            foreach ($this->users as $user) {
                $user->resolve($this->prediction, $winner - 1);
            }
            $this->prediction = NULL;
            return "";
        }

        if ($this->prediction != NULL) {
            $usr->predict($this->prediction, $msg->pointsPredicted, $msg->predictedIndex);
        }
    }
}
