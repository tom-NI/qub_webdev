<?php
    $mainArray = array();
    $one = "tom";
    $two = "david";
    $three = "Derek";

    function printme($values){
        echo "";
    }
    
    array_push($mainArray, $one, $two, $three);
    printme(...$mainArray);
?>