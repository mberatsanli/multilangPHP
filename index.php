<?php

include "src/multilangphp.php";


$mlang = new multilangPHP();

$mlang->setLanguage("tr");
$mlang->setFrom("json");


echo $mlang->call("test");

