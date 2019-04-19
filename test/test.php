<?php
require_once("../lib/multilang.php");

multilang::set("dir", "../demo/langs/");
multilang::setup();

echo multilang::get("dir");


echo "Output:". multilang::lang('hw');
echo "Output:". multilang::lang('hwa');

echo "<br/>";
echo multilang::listlang("html");



print_r(multilang::get("log", 1));