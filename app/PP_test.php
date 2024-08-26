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
];

foreach ($tests as $test) {
    $msg = new PPMessage($test[1], $test[0]);
    if ($msg->isValid() !== $test[2]) {
        echo "failed on ppmessage: $test[0] $test[1] $test[2]";
        exit(1);
    }
}

echo "success";

?>

