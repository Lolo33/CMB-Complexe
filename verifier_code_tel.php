<?php
	include ('conf/conf.php');
	if (isset($_POST['code']) AND !empty($_POST['code'])){
		$code = htmlspecialchars($_POST['code']);
		$code = $_SESSION['code'];
		if ($_SESSION['code'] == $code){ 
			?><script> var test_code = 1; </script><?php
		}
		else{
			?><script> var test_code = 0; </script><?php
		}
	}
	else{
		?><script> var test_code = 0; </script><?php
	}
?>