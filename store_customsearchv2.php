<?php
$effective_start_date=$_POST['effective_start_date'];
$effective_end_date=$_POST['effective_end_date'];
$location_code=$_POST['location_code'];

$url = 'http://110.0.100.70:8080/external/v2/report/storecustomsearchbatch';
$data = array('effective_start_date' => $effective_start_date, 'effective_end_date' => $effective_end_date, 'location_code' => $location_code);

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