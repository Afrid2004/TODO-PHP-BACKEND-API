<?php

//Remote
define("SERVER", "localhost");
define("USER", "faisalfr_todos_management");
define("DATABASE", "faisalfr_todos_management");
define("PASSWORD", "faisalfr_todos_management");


//Local
// define("SERVER", "localhost");
// define("USER", "root");
// define("DATABASE", "todo_management");
// define("PASSWORD", "");


$db = new mysqli(SERVER, USER, PASSWORD, DATABASE);
$tx = "";