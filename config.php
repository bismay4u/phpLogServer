<?php
if(!defined("ROOT")) exit("Direct access to this file not allowed");

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$forwarders = [
	"test2121"=>[
		"URL"=> "http://log.dev.smartinfologiks.net/push.php?logkey=test1"
	]
];

//load plugins
$pluginPath = __DIR__."/plugins/";
if(is_dir($pluginPath)) {
	$plugins = scandir($pluginPath);
	array_shift($plugins);array_shift($plugins);
	foreach($plugins as $p) {
		include_once $pluginPath.$p;
	}
}

//Setup other params
$date=date("Y-m-d");
$logFile= __DIR__."/logs/{$date}.log";
$logKey = "test";

if(isset($_GET["logkey"]) && strlen($_GET["logkey"])>0) {
  $logKey = $_GET["logkey"];
  unset($_GET["logkey"]);
}
$logFile = __DIR__."/logs/{$logKey}/{$date}.log";
