<?php 

// enter your database credentials here
$GLOBALS['config']['db'] = array(
    'host' => 'localhost',
    'user' => 'hc',
    'password' => 'UQM3DY6xnLscMxxa',
    'database' => 'hc',
  );

// enter your geo location here
$GLOBALS['config']['geo'] = array(
    'lat' => 49.635559,
    'long' => 8.35972,
    'zenith' => 90,
    'timezone' => 'Europe/Berlin',
    'city' => 'Worms, Germany',
  );

$GLOBALS['config']['openweathermap']['api_key'] = 'c6c73e0e13af0253fae5016df62cdd52';
  
// your server's address
$GLOBALS['config']['service']['server'] = '10.32.0.10';
$GLOBALS['config']['service']['wserverurl'] = '10.32.0.10:1081';

$GLOBALS['config']['cameras'] = array(
  'cams' => array(
    array(
      'photoUrl' => 'http://10.32.4.104:8080/photo.jpg', 
      'videoUrl' => '/cam02/video',
      'id' => 'cam02', 'title' => '', 'room' => 'Living Room'),
    #array('photoUrl' => 'http://10.32.4.106:8080/photo.jpg', 'id' => 'cam03', 'title' => '', 'room' => 'Living Room'),
    array(
      'photoUrl' => 'http://10.32.0.36:8080/photo.jpg', 
      'videoUrl' => '/cam04/video',
      'id' => 'cam04', 'title' => '', 'room' => 'Office'),
    ),
  );
  
$GLOBALS['config']['sensors'] = array(
  'sensors' => array(
    ),
  );
