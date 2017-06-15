<?php
namespace MeetingFinder;

require_once __DIR__ . '/vendor/autoload.php';

use MeetingFinder\Services\ConfigServiceProvider;
use MeetingFinder\Services\MeetingServiceProvider;

$meetingService = new MeetingServiceProvider(new ConfigServiceProvider());
$results = $meetingService->getMeetings("San Diego", "CA");

foreach($results as $meeting){
    echo $meeting["meeting_name"] . '. Distance -> ' . $meeting["distance_from"] .'<br>';
}
