<?php
define("ROOT",__DIR__);

include_once __DIR__."/config.php";

if(!isset($_GET['date'])) {
  $_GET['date']=date("Y-m-d");
}
$date=$_GET['date'];
$logFile = __DIR__."/logs/{$logKey}/{$date}.log";
$logDir = __DIR__."/logs/{$logKey}/";


if(file_exists($logDir) && is_dir($logDir)) {
	$fs = scandir($logDir);
	array_shift($fs);array_shift($fs);
} else {
	$fs = [];
}

$fs = array_merge([date("Y-m-d")], $fs);

function printLogFile($logFile) {
	if(file_exists($logFile)) {
	  //echo "<pre>";
	  readfile($logFile);
	  //echo "</pre>";
	} else {
	  echo "No log file found";//on {$date} for $logKey
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Log Server</title>
	<META name="viewport" content="width=device-width, initial-scale=1.0" />
	<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<META http-equiv="Pragma" content="no-cache" />
	<META http-equiv="Cache-Control" content="no-cache" />
	<META http-equiv="Expires" content="0" />

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<style type="text/css">
html,body {
    width: 100%;
    height: 100%;
}
* {
	border-radius: 0px !important;
}
h1.page-header {
    margin-top: -5px;
}

.sidebar {
    padding-left: 0;
}

.main-container { 
    background: #FFF;
    padding-top: 15px;
    margin-top: -20px;
    padding: 0px;
    width: 100%;
    height: 100%;
    height: calc(100% - 51px);
}
.main-content {
	padding: 0px;
}
.footer {
    width: 100%;
}
pre {
    background: transparent;
    border: 0px;
    /*white-space: break-spaces;*/
}
body.activeSidebar .sidebar {
	display: block !important;
}
.mobile-buttons {
	display: none;
	background: transparent;
    color: #666;
    margin: 8px;
}
@media (max-width: 767px) {
	body .sidebar {
		display: none;
	}
	.mobile-buttons {
		display: block;
	}
	body.activeSidebar .sidebar {
		display: block !important;
	}
}
</style>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<!-- <button type="button" class="navbar-toggle mobile-buttons" data-toggle="collapse" data-target="#mySidebar" onclick="$('body').toggleClass('activeSidebar');">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button> -->
			<button type="button" class="btn btn-default mobile-buttons pull-right" onclick="$('body').toggleClass('activeSidebar');">
				<i class="glyphicon glyphicon-calendar" style="font-size: 18px;"></i>
			</button>
			<a href="javascript:window.location.reload();" class="btn btn-default mobile-buttons pull-right"><i class="glyphicon glyphicon-refresh" style="font-size: 18px;"></i></a>
			<a class="navbar-brand" href="#">
				SILKLogger
			</a>
		</div>

		<div class="nav navbar-nav navbar-right hidden-xs hidden-sm">
			<a href='javascript:window.location.reload();' class="btn btn-default" style='margin: 5px;padding: 9px;'><i class="glyphicon glyphicon-refresh" style="font-size: 20px;"></i></a>
		</div>
		
		<!-- Collect the nav links, forms, and other content for toggling -->
		<!-- <div class="collapse navbar-collapse hidden" id="bs-example-navbar-collapse-1">			
			<form class="navbar-form navbar-left" method="GET" role="search">
				<div class="form-group">
					<input type="text" name="q" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="http://www.pingpong-labs.com" target="_blank">Visit Site</a></li>
				<li class="dropdown ">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Account
						<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-header">SETTINGS</li>
							<li class=""><a href="#">Other Link</a></li>
							<li class=""><a href="#">Other Link</a></li>
							<li class=""><a href="#">Other Link</a></li>
							<li class="divider"></li>
							<li><a href="#">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div> -->
	</nav>
	<div class="container-fluid main-container">
		<div id="mySidebar" class="col-md-2 sidebar" style="padding: 0px;height: 100%;border-right: 1px solid #CCC;">
			<ul class="nav nav-pills nav-stacked">
				<?php
					foreach ($fs as $f) {
						$fName = str_replace(".log", "", $f);
						$link = "./?logkey={$logKey}&date={$fName}";//index.php
						if($fName == $_GET['date']) {
							echo "<li class='active'><a href='#'>{$fName} <i class='glyphicon glyphicon-chevron-right pull-right' style='font-size: 20px;margin-top: -2px;margin-right: -15px;'></i></a></li>";
						} else {
							echo "<li><a href='{$link}'>{$fName}</a></li>";
						}
					}
					//<li class="active"><a href="#">Home</a></li>
				?>
			</ul>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-10 content main-content">
			<pre><?php
					printLogFile($logFile);
				?></pre>
            <div class="panel panel-default hidden">
                <div class="panel-heading">
                    Dashboard
                </div>
                <div class="panel-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    			    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </div>
		</div>
		<footer class="pull-left footer hidden">
			<p class="col-md-12">
				</p><hr class="divider">
				Copyright © 2015 <a href="http://www.pingpong-labs.com">Gravitano</a>
			<p></p>
		</footer>
	</div>
                            
</body>
<script type="text/javascript">

</script>
</html>
