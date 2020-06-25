<?php
function sieveOfEratosthenes ($n) {
    $array = range($n, 2, -1);

    $result = [];
    while ($array) {
        $result[] = $number = array_pop($array);
        foreach ($array as $key => $item) {
            if (($item % $number) === 0) {
                unset($array[$key]);
            }
        }
    }

    return $result;
}

echo implode(', ', sieveOfEratosthenes(10)).PHP_EOL;
echo implode(', ', sieveOfEratosthenes(15)).PHP_EOL;
echo implode(', ', sieveOfEratosthenes(50)).PHP_EOL;