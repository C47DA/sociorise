<?php
define('PATH', realpath('.'));
define('SUBFOLDER', false);
define('URL', 'https://sociorise.com' );
define('STYLESHEETS_URL', '//sociorise.com' );
date_default_timezone_set('Asia/Kolkata');

/* 
 ini_set("display_errors","1");
error_reporting(E_ERROR);  */  

error_reporting(0);
return [
  'db' => [
    'name'    =>  'socioris_try1' ,
    'host'    =>  'localhost',
    'user'    =>  'socioris_try1' ,
    'pass'    =>  'socioris_try1' ,
    'charset' =>  'utf8mb4'
  ]
];

?>