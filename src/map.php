<?php

include_once(__DIR__ . '/keys.php');

# IMPORTING & SANITIZING VARIABLES ------------------
$vid = (int) $_GET['vid'];

# GETTING GPS COORDINATES & BUS DATA ----------------
$GPSurl = "http://whereis.yourbus.com/bustime/api/v1/getvehicles?key={$st_catharines_transit_api_key}&vid={$vid}";
$xml = simplexml_load_file($GPSurl);

$latitude = $xml->vehicle->lat;
$longitude = $xml->vehicle->lon;  
$heading = $xml->vehicle->hdg;
$speed = $xml->vehicle->spd;
$route = $xml->vehicle->rt;
$to = $xml->vehicle->des;
$error = $xml->error->msg;

# REQUESTING DEPARTURE TIME FOR BUS -----------------
$departurefrombrock = "http://whereis.yourbus.com/bustime/api/v1/getpredictions?key={$st_catharines_transit_api_key}&vid={$vid}&format=json";
$xml2 = simplexml_load_file($departurefrombrock);
$deptime = $xml2->prd[0]->prdtm;
$brockdeparturetime = substr($deptime, -5);
$departsin = ("Departs Brock at: {$brockdeparturetime}");


#ERROR CATCHER -------------------------------------
if ($error == 'No data found for parameter') {
    echo"<!DOCTYPE html><head><title>No Information Available</title><link rel='stylesheet' type='text/css' href='/static/css/style.css' media='screen' />
</head><body><div class='error'><a href='index.html'><h1 id='errortextmap'>Sorry, no further information is available. Click to return.</h1></a></div></body></html>";
die();
};


# BUILDING GMAPS REQUEST ----------------------------
$iframeURL = "https://www.google.com/maps/embed/v1/streetview?key={$google_maps_api_key}&location={$latitude},{$longitude}&heading={$heading}&pitch=10&fov=100";
$iframeURL2 = "https://www.google.com/maps/embed/v1/view?key={$google_maps_api_key}&center={$latitude},{$longitude}&zoom=18";


# BUILDING THE PAGE --------------------------------

echo "
<!DOCTYPE html>
<head>
<title>Bus {$route} - {$to}</title>
<link rel='stylesheet' type='text/css' href='/static/css/mapstyle.css' />
<link rel='stylesheet' media='screen and (max-width: 800px)' href='/static/css/mobilemap.css' />
<link rel='stylesheet' media='screen and (max-device-width: 800px)' href='/static/css/mobilemap.css' />
</head>
<body>
<div class='header'>
<h1>{$route} - {$to}</h1>
<h3>Currently travelling: {$speed} kph</h3>
<h3>{$departsin}</h3>
</div>
<div class='headerbottom'></div>
<a href='index.html'><div class='backbutton'><img src='/static/img/back-button.png' id='goback' alt='Go Back'></div></a>
<div class='streetview'>
<iframe
  width='100%'
  height='100%'
  frameborder='0' style='border:0'
  src='{$iframeURL}'>
</iframe>
</div>
<div class='mapbackground'>
<iframe
  width='100%'
  height='100%'
  frameborder='0' style='border:0'
  src='{$iframeURL2}' >
</iframe>
</div>
 
</body>
</html>

";


?>

