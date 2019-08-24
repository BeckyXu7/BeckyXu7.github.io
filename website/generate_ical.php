<?php

$event = array(
	'id' => "1",
	'title' => "UQ Party",
	'description' => "Hey",
	'datestart' => "20131016T085200Z",
	'dateend' => "20131016T085312Z"
);
// iCal date format: yyyymmddThhiissZ


// Build the ics file
$ical = 'BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
DTEND:' . $event['dateend'] . '
UID:' . md5($event['title']) . '
DTSTAMP:' . time() . '
DESCRIPTION:' . addslashes($event['description']) . '
URL;
SUMMARY:' . addslashes($event['title']) . '
DTSTART:' . $event['datestart'] . '
END:VEVENT
END:VCALENDAR';
//set correct content-type-header
if($event['id']){
	header('Content-type: text/calendar; charset=utf-8');
	header('Content-Disposition: attachment; filename=dueDateSchedule.ics');
	echo $ical;
} else {
	// If $id isn't set, then kick the user back to home. Do not pass go,
        // and do not collect $200. Currently it's _very_ slow.
	header('Location: /');
}
?>