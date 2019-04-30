<?php

include_once(__DIR__ . '/keys.php');

# This page retrieves information from St. Catharines transit, prints it, and passes variables to the next session

# ----------------------------------------------------------------------------------------
# APPROACH PREDICTION

# This section looks for predictions at the Flora Egerter Way stop, and predicts that a bus will be approaching the tower soon

# EDITABLE VARIABLES ---------------------------
$stpid2 = "1067";
$format2 = "xml";


# BUILDING THE API CALL ----------------------------
$mainurl2 = "http://whereis.yourbus.com/bustime/api/v1/getpredictions?key={$st_catharines_transit_api_key}&stpid={$stpid2}&format={$format2}";
$xml2 = simplexml_load_file($mainurl2); 


# PARSING & PROCESSING -------------------------
foreach ($xml2->prd as $prediction2) {
        $arrival2 = strtotime($prediction2->prdtm);
		$now2 = strtotime($prediction2->tmstmp);
        $route2 = $prediction2->rt;
        $mins2 = round(abs($arrival2 - $now2) / 60,0);
    
# PRINTING NOTIFICATION ------------------------ 
    
    if ($mins2 <= 1) {
        echo "
        <div class='approachingpanel'><div class='approachingcontainer'><h8>Bus {$route2} is now approaching the tower</h8></div></div>
        ";
    }
    
# End of foreach
}

# ----------------------------------------------------------------------------------------
# SCHEDULE PREDICTION



# EDITABLE VARIABLES ---------------------------
$stpid = "BRU";
$format = "xml";


# BUILDING THE API CALL ----------------------------
$mainurl = "http://whereis.yourbus.com/bustime/api/v1/getpredictions?key={$st_catharines_transit_api_key}&stpid={$stpid}&format={$format}";
$xml = simplexml_load_file($mainurl); 


#NO BUSES ERROR CATCHER ------------------------
    $error = $xml->error->msg;
if ($error == 'No arrival times') {
echo "<div class='arrivalpanel'><div class='errorcontainer'><h5>Sorry! No departures are currently scheduled.</h5></div></div>";
    die;
};

if ($error == 'No service scheduled') {
    echo "<div class='arrivalpanel'><div class='errorcontainer'><h5>Bus service has finished for the day. See you tomorrow, Badgers!</h5></div></div>";
    die;
};

# PARSING & PROCESSING -------------------------
foreach ($xml->prd as $prediction) {
        $arrival = strtotime($prediction->prdtm);
		$now = strtotime($prediction->tmstmp);
        $vid = $prediction->vid;
        $route = $prediction->rt;
        $to = ucwords(strtolower($prediction->des));
    
		if($prediction->dly != "true") {
			$mins = round(abs($arrival - $now) / 60,0). " mins";
		} else $mins = "<div style='Color:#cc0000!important;'>Delayed</div>";
    

    
# BUILDING THE MAP URL & ARRIVAL PANEL -------------------------
		   
        
    
	echo "
    <div class='arrivalpanel'>
        <div class='busnumber'>
            <h2>{$route}</h2>
        </div>
        <div class='busdescrip'>
            <p>{$to}</p>
        </div>
        <div class='arrivaltime'>
            <h3>{$mins}</h3>
        </div>
    </div>
    ";
    
# End of foreach
}


#EOF
?>