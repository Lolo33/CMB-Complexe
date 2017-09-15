<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 29/08/2017
 * Time: 15:17
 */

namespace CmbSdk;

class CmbApi extends Requetes
{
    public $UtilisateursAction;

    public function __construct($url, $api_key)
    {
        parent::__construct($url, $api_key);
        $this->UtilisateursAction = new Actions($url . Routes::URL_USER , $api_key);
    }

}

