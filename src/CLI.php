<?php

class CLI {
    public static function printLine($string, $numbOfPreNewLines = 0, $numbOfPostNewLines = 1) {
        echo str_repeat("\n", $numbOfPreNewLines) . $string . str_repeat("\n", $numbOfPostNewLines);
    }
}
