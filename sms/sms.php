<?php
	include ('../conf.php');
	require("smsenvoi.php");

	$sms=new smsenvoi();
	$sms->sendSMS('+33682564985','Mon premier SMS en PHP');
?>