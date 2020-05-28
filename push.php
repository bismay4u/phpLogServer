<?php
define("ROOT",__DIR__);

include_once __DIR__."/config.php";

if(!is_dir(dirname($logFile))) {
  mkdir(dirname($logFile),0777,true);
}
if(!is_dir(dirname($logFile))) {
  exit("Could not find Log Folder. Contact System Admin");
}

if(!file_exists($logFile)) {
  file_put_contents($logFile,"");
}

$postData=file_get_contents("php://input");;
$uri=$_SERVER['REQUEST_URI'];
$timestamp=date("Y-m-d H:i:s");
$logData="{$timestamp} {$uri} {$postData}";
$a = file_put_contents($logFile, $logData.PHP_EOL , FILE_APPEND | LOCK_EX);

if(isset($forwarders[$logKey])) {
  echo forwardData($forwarders[$logKey], $postData);
} else {
  if($a>0) echo "ok";
  else echo "err";
}

exit();

function forwardData($forwardConfig, $data) {
  if(!isset($forwardConfig['URL'])) return "err, forwarding";

  if(!isset($forwardConfig['USER-AGENT'])) $forwardConfig['USER-AGENT'] = "SILKLOGGER/1.0";
  if(!isset($forwardConfig['CONTENT-TYPE'])) $forwardConfig['CONTENT-TYPE'] = "text/html; charset=UTF-8";

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $forwardConfig['URL'],//"http://13.126.176.135/services/dcumqtt",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "Accept: *",
        "Content-Type: ".$forwardConfig['CONTENT-TYPE'],
        "User-Agent: ".$forwardConfig['USER-AGENT'],
        "Content-length: ".strlen($data),
    ),
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_RETURNTRANSFER => true,
    // CURLOPT_HEADER=>true,
    // CURLOPT_ENCODING => "",
    // CURLOPT_AUTOREFERER => true,
    // CURLOPT_COOKIESESSION => true,
    // CURLOPT_FORBID_REUSE => false,
    // CURLOPT_SSL_VERIFYPEER => false,
    // CURLOPT_CONNECTTIMEOUT => 10,
    // CURLOPT_BINARYTRANSFER => true,
    // CURLOPT_MAXREDIRS => 10,
    
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);

//   var_dump( curl_getinfo( $curl, CURLINFO_HEADER_OUT ) );
  if ($err) {
    return "err, CURL Error - " . $err;
  } else {
    return $response;
  }
}

/*
function sendData($data) {
  $data=explode("/",$data);
  $time="-";
  $did=substr($data[6],2,2);
  
  //"DCU2017/MFM384/MFM384/TCP/4/03030000000ac42f/030314000a0001000103e800fa000007d0000000030006918"
  $data="XOT/{$data[0]}/{$data[1]}/{$data[2]}/{$did}/{$data[3]}/{$time}/{$data[5]}/{$data[6]}/XCT";
  
  $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://13.126.176.135/services/dcumqtt",
    CURLOPT_HEADER=>true,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "User-Agent: SELECDCU/1.0",
        "Accept: *",
        "Content-length: ".strlen($data),
        "Content-Type: text/html; charset=UTF-8",
    ),
//     CURLOPT_AUTOREFERER => true,
//     CURLOPT_BINARYTRANSFER => true,
//     CURLOPT_COOKIESESSION => true,
    CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_FORBID_REUSE => false,
    CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_SSL_VERIFYPEER => false,
//     CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 11,
    CURLOPT_ENCODING => "",
//     CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

//   var_dump( curl_getinfo( $curl, CURLINFO_HEADER_OUT ) );
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }
}


?>