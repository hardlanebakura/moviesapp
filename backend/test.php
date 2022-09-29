<?php
    $string = "Dragan is king";
    echo "1";
    $pattern = "/King/i";
    $string1 = "banana banana";
    $pattern = "/ba(na){2}/i";
    echo(preg_match_all($pattern, $string1));
    function k ($c) {
        return ($c) ? "true" : "false";
    }

    echo k(2 == 2);
    $arr = ["1", 2, 3];
    echo count($arr);
    $object = '{ "name": "asd", "duck": "white" }';
    $object = json_decode($object);
    echo $object->name;
    $arr1 = ["name", "color"];
    $arr2 = ["Dragan", "gold"];
    $arr = array_combine($arr1, $arr2);
    print_r($arr);
    $s = "";
    for ($x = 0; $x < 4; $x++) {
        $s .= chr(rand(97, 122));
    }
    for ($x = 0; $x < 5; $x++) {
        $s .= rand(0, 9);
    }
    $d = "";
    for ($x = 0; $x < 4; $x++) {
        $d .= chr(rand(97, 122));
    }
    for ($x = 0; $x < 5; $x++) {
        $d .= rand(0, 9);
    }
    echo $s;
    echo $d;
    $str1 = "ASD";
    $str1 = str_replace("A", "ASD", $str1);
    echo strstr($str1, "S");
    print($str1);
    print(strpos($str1, "S"));
?>