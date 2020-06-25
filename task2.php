<?php
function checkBraces (string $string) {
    $bracesOpen = ['(', '{', '<', '['];
    $bracesClosed = [')', '}', '>', ']'];
    $stack = [];
    foreach (str_split($string) as $char) {
        if (in_array($char, $bracesOpen)) {
            $stack[] = $char;
        } elseif (in_array($char, $bracesClosed)) {
            $key = array_search($char, $bracesClosed);
            if ($bracesOpen[$key] != array_pop($stack)) {
                return false;
            }
        }
    }

    return empty($stack);
}

var_dump(checkBraces('---(++++)----'));
var_dump(checkBraces(''));
var_dump(checkBraces('before ( middle []) after '));
var_dump(checkBraces(') ('));
var_dump(checkBraces('} {'));
var_dump(checkBraces('<(   >)'));
var_dump(checkBraces('(  [  <>  ()  ]  <>  )'));
var_dump(checkBraces('   (      [)'));
