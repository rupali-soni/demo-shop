<?php
namespace Demoshop\config;

/**
 * This class defines all values related to configurations required in project
 */
class Config {
    /**
     * Get all configuration values.
     * @return array
     */
    public static function getConfig(){

        $config = array(
            "host"              => "localhost",
            "user"              => "root",
            "password"          => "root",
            "dbname"            => "shop",
            "port"              => 3306
        );
        $config['baseUrl']        = "/shop/";
        $config['assetsPath']     = $config['baseUrl'] . "assets/";
        $config['currencySymbol'] = '&euro;';
        return $config;
    }
}