<?php

namespace TripSorter\Test;

use TripSorter\Cards\BusCard;
use TripSorter\Cards\FlightCard;
use TripSorter\Cards\TrainCard;
use TripSorter\Trip;
use TripSorter\Services\CardSorter;
use PHPUnit\Framework\TestCase;

class TripTest extends TestCase{
    public function test(){
        $newTrip = new  Trip(new CardSorter());

        $newTrip->addCard(new FlightCard('Gerona Airport', 'Stockholm', '3A', 'SK455', '45B', '344'));
        $newTrip->addCard(new FlightCard('Stockholm', 'New York JFK', '7B', 'SK22', '22'));
        $newTrip->addCard(new BusCard('Barcelona', 'Gerona Airport'));
        $newTrip->addCard(new TrainCard('Madrid', 'Barcelona', '45B', '78A'));
        $newTrip->sort();
        $output = "Take train 78A from Madrid to Barcelona. Sit in seat 45B.". PHP_EOL .
            "Take the bus from Barcelona to Gerona Airport. No seat assignment.". PHP_EOL .
            "From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.". PHP_EOL .
            "From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. Baggage will be automatically transferred from your last leg.". PHP_EOL .
            "\033[32mYou have arrived at your final destination.\033[0m" . PHP_EOL;
        $this->assertEquals($newTrip->export(), $output);
    }
}