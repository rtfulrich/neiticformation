<?php

$size = "large";
$var_array1 = array(
    "color" => "blue",
    "size"  => "medium",
    "shape" => "sphere"
);
$var_array2 = array(
    "color" => "blue",
    "size"  => "medium",
    "shape" => "sphere"
);

$array = [
    
]

extract($var_array, EXTR_PREFIX_SAME, "wddx");

echo "$color, $size, $shape, $wddx_size\n";