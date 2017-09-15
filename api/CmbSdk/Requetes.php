<?php

/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 01/08/2017
 * Time: 14:06
 */

namespace CmbSdk;

class Requetes
{
    protected $url;
    protected $header;

    const API_URL = "http://quandsereunir.fr";
    const TEST_URL = "http://localhost/api/web/app_dev.php";

    public function __construct($url, $api_key)
    {
        $this->url = $url;
        $this->header = array("Autorisation: ".$api_key);
    }

    public function sendPostRequest($content)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);

        curl_close($curl);
        return $result;
    }

    public function sendGetRequest(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);

        //if (FALSE === $result)
        //throw new Exception(curl_error($result), curl_errno($result));

        curl_close($curl);
        return $result;
    }

}



