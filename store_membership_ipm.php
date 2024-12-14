<?php
$start_date=$_POST['start_date'];
$end_date=$_POST['end_date'];
$location_code=$_POST['location_code'];

$url = 'http://110.0.100.135:8081/v3/api/ipmstoremembershipbatch';
$data = array('start_date' => $start_date, 'end_date' => $end_date, 'location_code' => $location_code);

$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => json_encode($data)
    )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
if ($result === FALSE) { /*Handle error*/ }

var_dump($result);
?>
