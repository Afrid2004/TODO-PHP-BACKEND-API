<?php

//Remote
// define("SERVER", "localhost");
// define("USER", "faisalfr_fast_drop_2026");
// define("DATABASE", "faisalfr_fast_drop_2026");
// define("PASSWORD", "faisalfr_fast_drop_2026");


//Local
define("SERVER", "localhost");
define("USER", "root");
define("DATABASE", "todo_management");
define("PASSWORD", "");


$db = new mysqli(SERVER, USER, PASSWORD, DATABASE);
$tx = "";
