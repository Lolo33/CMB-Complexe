<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 29/08/2017
 * Time: 12:49
 */

namespace CmbSdk;

/**
 * Class Autoloader
 */
class Autoloader{

    /**
     * Enregistre notre autoloader
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function registerRacine(){
        spl_autoload_register(array(__CLASS__, 'autoloadRacine'));
    }

    static function registerExceptions(){
        spl_autoload_register(array(__CLASS__, 'autoloadException'));
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    static function autoload($class){
        require "../".$class . '.php';
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    static function autoloadRacine($class){
        require $class . '.php';
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    static function autoloadException($class){
        require "../Exceptions/".$class . '.php';
    }

}

Autoloader::register();
Autoloader::registerExceptions();