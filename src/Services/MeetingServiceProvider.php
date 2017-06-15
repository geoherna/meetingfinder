<?php

namespace MeetingFinder\Services;

use JsonRPC\Client;
use Location\Coordinate;
use Location\Distance\Vincenty;
use Symfony\Component\Config\Definition\Exception\Exception;

class MeetingServiceProvider{

    private $host;
    private $user;
    private $password;
    private $client;
    private $coords;
    const JSON_METHOD = 'byLocals';

    public function __construct(ConfigServiceProvider $config){
        $this->host = $config->getValue('host');
        $this->user = $config->getValue('user');
        $this->password = $config->getValue('pass');
        $this->client = new Client($this->host);
        $this->client->getHttpClient()
            ->withUsername($this->user)
            ->withPassword($this->password);
        $this->coords = new Coordinate("32.710734", "-117.160735");

    }

    public function getMeetings($city, $state){
        $mondayResults = [];
        try{
            $results = $this->client->execute('byLocals',['state_abbr' => $state, 'city' => $city]);
        }catch (Exception $e){
            return $e->getMessage();
        }

        foreach($results as $meeting){
            if($meeting["time"]["day"] == "monday"){
                array_push($mondayResults, $meeting);
            }
        }


        return $this->sort($results);
    }

    function cmp($a, $b){
        return $a["distance_from"] - $b["distance_from"];
    }

    private function sort($results){
        $sorted = [];
        foreach($results as $meeting){
            $meetingSite = new Coordinate($meeting["address"]["lat"], $meeting["address"]["lng"]);
            $distance = $this->coords->getDistance($meetingSite, new Vincenty());
            $meeting["distance_from"] = $distance;
            $sorted[] = $meeting;
        }
        usort($sorted, array($this, "cmp"));
        return $sorted;
    }



}