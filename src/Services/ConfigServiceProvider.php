<?php

namespace MeetingFinder\Services;

/**
 * ConfigServiceProvider
 *
 *Basic class for parsing a .config file for credentials / other values
 *
 * @package MeetingFinder
 * @author George Hernandez <geoherna@outlook.com>
 */

class ConfigServiceProvider{

    public function __construct(){
        $configFile = static::getPath() . '/.config';
        $this->parseFile($configFile);
    }

    public function getValue($name){
        return $this->$name;
    }

    private function parseFile($path){
        $parsedArray = [];
        $fileContents = file_get_contents($path);
        $resultArray = explode(PHP_EOL, $fileContents);

        foreach($resultArray as $item){
            if(strpos($item, '=')){
                $parsedArray[trim(strstr($item, '=', true))] = trim(substr(strstr($item, '='), 1));
            }
        }
        foreach ($parsedArray as $key => $value) {
            $this->setValue($key, $value);
        }
    }

    private function setValue($name, $value){
        $this->$name = $value;
    }

    private static function getPath(){
        return realpath(__DIR__ . '/../..');
    }
}
