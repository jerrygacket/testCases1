<?php
function searchWorld ($words) {
    $max = '';
    $min = $words;
    $words = preg_replace('/ +/', ' ', $words);
    foreach (explode(' ', $words) as $word) {
        $max = (strlen($word) > strlen($max)) ? $word : $max;
        $min = (strlen($word) < strlen($min)) ? $word : $min;
    }

    echo $max.PHP_EOL;
    echo $min.PHP_EOL;
}

searchWorld("Lorem Ipsum is  simply dummy text the printing and typesetting industry");
