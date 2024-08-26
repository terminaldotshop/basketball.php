<?php

namespace App;
require_once("./app/PP.php");

$tests = [
    ["!c", "foobar", true],
    ["!c", "nightshadedude", true],
    ["!p oneuh oeu", "nightshadedude", true],
    ["!p oneuh oeu", "foobar", false],
    ["!1 oneuh", "foobar", false],
    ["!1 1000", "foobar", true],
    ["!1 1000", "nightshadedude", true],
    ["!r 7", "nightshadedude", true],
    ["!r 7", "foobar", false],
];

foreach ($tests as $test) {
    $msg = new PPMessage($test[1], $test[0]);
    if ($msg->isValid() !== $test[2]) {
        echo "failed on ppmessage: $test[0] $test[1] $test[2]";
        exit(1);
    }
}

$pp = new PP();

$out = $pp->pushMessage("theprimeagen", "!p Will teej make his first basket? !one option !two options !three twitch sucks");
if (strlen($out)) {
    echo "failed:  output from adding mod prediction: $out";
    exit(1);
}

if ($pp->prediction == null) {
    echo "failed: prediction was not created";
    exit(1);
}

$pp->pushMessage("teej", "!1 69");
if ($pp->getUser("teej")->points != 931) {
    echo "failed: teej should have 931 points";
    exit(1);
}
if ($pp->prediction->options[0]->points != 69) {
    echo "failed: options 0 does not have total voted points for it";
    exit(1);
}

if ($pp->prediction->totalPoints() != 69) {
    echo "failed: total points should be 69";
    exit(1);
}

$pp->pushMessage("foobar", "!1 42");
if ($pp->prediction->options[0]->points != 111) {
    echo "failed: options[0] should have 111 points";
    exit(1);
}

if ($pp->getUser("foobar")->points != 958) {
    echo "failed: foobar should have 958 points";
    exit(1);
}

$pp->pushMessage("bash", "!2 89");
if ($pp->prediction->options[1]->points != 89) {
    echo "failed: options[0] should have 111 points";
    exit(1);
}

if ($pp->prediction->totalPoints() != 200) {
    echo "failed: total points should be 200";
    exit(1);
}

$out = $pp->pushMessage("theprimeagen", "!r 1");
if (strlen($out)) {
    echo "failed:  output from adding mod prediction: $out";
    exit(1);
}
if ($pp->prediction != null) {
    echo "failed: prediction should be null";
    exit(1);
}

echo $pp->getUser("teej");

echo "great success";

?>

