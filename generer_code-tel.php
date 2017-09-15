<?php
	include ('sms/smsenvoi.php');
	include ('conf/conf.php');

	if (isset($_POST['tel']) AND !empty($_POST['tel'])){
		$tel = sanitize($_POST['tel']);

		if (test_format_tel($tel)){
			if (/*!test_tel_exsite($tel)*/ 1 == 1){
				$code = rand(1000,9999);

				$_SESSION['tel'] = $tel;
				$_SESSION['code'] = $code;

				$tel = substr($tel, 1);
				$tel = "+33" . $tel;
				
				//$sms = new smsenvoi();
				//$sms->sendSMS($tel, "Votre code de confirmation : " . $code);
				?> <script> var test_tel = 1; </script> <?php
			}
			else{
				echo "Ce téléphone est déjà enregistré";
				?> <script> var test_tel = 0; </script> <?php
			}
		}
		else{
			echo "erreur format téléphone";
			?> <script> var test_tel = 0; </script> <?php
		}
	}
	else{
		echo "Pas de numéro saisi";;
	}
?>