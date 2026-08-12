<?php
date_default_timezone_set("Asia/Dhaka");
$now = date("Y-m-d H:i:s");
// $base_url = "http://localhost/pwad_71_class/class/php/project/admin/";
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
// $base_url = $protocol . '://' . $_SERVER['HTTP_HOST'].
//   dirname($_SERVER['SCRIPT_NAME']) . '';
// remove estra / 
$base_url = rtrim(
  $protocol . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']),
  '/'
);
