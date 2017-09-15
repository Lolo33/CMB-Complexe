<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 29/08/2017
 * Time: 13:29
 */

include 'includes/init.php';
session_destroy();
header("Location: index.php");