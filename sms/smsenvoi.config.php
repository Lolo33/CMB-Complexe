<?php

define('SMSENVOI_EMAIL','tim.footensalle@gmail.com');
define('SMSENVOI_APIKEY','P23K6NLL36EM3R6E9R8U');
define('SMSENVOI_VERSION','3.0.4');
//ADDED SINCE 3.0.1 : STOPS
//ADDED SINCE 3.0.2 : CALLS
//ADDED SINCE 3.0.3 : RICHSMS

function iscurlinstalled() {
	if  (in_array  ('curl', get_loaded_extensions())) {
		return true;
	}
	else{
		return false;
	}
}

if(!iscurlinstalled()){ die("L'API SMSENVOI NECESSITE L'INSTALLATION DE CURL"); }

?>