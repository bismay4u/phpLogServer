<?php
define("ROOT",__DIR__);

include_once __DIR__."/config.php";

if(!isset($_GET['date'])) {
  $_GET['date']=date("Y-m-d");
}
$date=$_GET['date'];
$logFile = __DIR__."/logs/{$logKey}/{$date}.log";

if(file_exists($logFile)) {
  echo "<pre>";
  readfile($logFile);
  echo "</pre>";
} else {
  echo "No log file found on {$date} for $logKey";
}
?>