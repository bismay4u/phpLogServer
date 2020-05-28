# PHPLogServer

A simple PHP based weblog server meant to be used while development.

This project is used by me in various projects of mine to log data from the web apps, mobile apps and IOT devices.

Simple to host, just unzip this folder on a apache2 or nginx-php server, and starting pushing and viewing data.

To Push Data
> POST <WEBROOTPATH>/push.php?logkey=<any_key> with log data as plain body of post params

To View Data
> <WEBROOTPATH>/?logkey=<any_key>&date=<date as Y-m-d> will display log for eh log key and date. Default values for logkey is test, and date is today's date.


Thank you
Bismay
