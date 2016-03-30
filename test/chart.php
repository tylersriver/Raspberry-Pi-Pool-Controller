<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="refresh" content="180" >

<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>
Google Visualization API Sample
</title>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load('visualization', '1', {packages: ['corechart']});
</script>
<script type="text/javascript">

function drawVisualization() {
// Create and populate the data table.
var data = new google.visualization.DataTable();
data.addColumn('string', 'time');
data.addColumn('number', 'Last Month');
  
<?php

$db_host = "173.194.86.153";
$db_user = "pi";
$db_password = "rn4R9EfAarJpY5VwY8rnBlL2";
$db_database = "temp_db";
    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_database);
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    echo "Connected successfully";

  
$sqlQuery =
  "SELECT `tempLog`.`datetime` as time, `tempLog`.`temperature`\n as temp"
    . "FROM tempLog\n"
    . "ORDER BY `tempLog`.`datetime` DESC\n"
    . " LIMIT 0, 30 ";
    $sqlResult = $mysqli->query('SELECT * FROM tempLog');
//$sql = mysqli_query($mysqli, 'SELECT * FROM analoog0');

    while($row = mysqli_fetch_array($sqlResult)) 
    {
    // date assumes "yyyy-MM-dd" format
    $dateArr = explode('-', $row['Date']);
    $year = (int) $dateArr[0];
    $month = (int) $dateArr[1] - 1; // subtract 1 to make month compatible with javascript months
    $day = (int) $dateArr[2];

    // time assumes "hh:mm:ss" format
    $timeArr = explode(':', $row['Time']);
    $hour = (int) $timeArr[0];
    $minute = (int) $timeArr[1];
    $second = (int) $timeArr[2];

    $results['rows'][] = array('c' => array(
        array('v' => "Date($year, $month, $day, $hour, $minute, $second)"),
        array('v' => $row['Temperature'])
    ));
    }
$json = json_encode($results, JSON_NUMERIC_CHECK);
echo $json;

?>

// Create and draw the visualization.
new google.visualization.LineChart(document.getElementById('visualization')).
draw(data, {curveType: "none",
title: "Monthly Margin",
titleTextStyle: {color: "orange"},
width: 1600, height: 400,
//vAxis: {maxValue: 10},
vAxis: {minValue: 0},
vAxis: {title: 'Euro'},
vAxis: {baseline: 0},
vAxis: {gridlines: {count: 10}  },
vAxis: {title: "Euro", titleTextStyle: {color: "orange"}},
hAxis: {title: "Day", titleTextStyle: {color: "orange"}},
interpolateNulls: 1
}
);
}

google.setOnLoadCallback(drawVisualization);
</script>
</head>
<body style="font-family: Arial;border: 0 none;">
<div id="visualization" style="width: 500px; height: 400px;"></div>
</body>
</html>