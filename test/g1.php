<html>
<head>
    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            //   var data = google.visualization.arrayToDataTable(<?=$jsonTable?>);
            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Temperature', {$gauge_data}]
            ]);

            var options = {
                width: 400, height: 400,
                redFrom: 90, redTo: 100,
                yellowFrom:75, yellowTo: 90,
                minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

            chart.draw(data, options);

        <!--           setInterval(function() {
        data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
                        chart.draw(data, options);
                    }, 13000);
                    setInterval(function() {
                        data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
                        chart.draw(data, options);
                    }, 5000);
                    setInterval(function() {
                        data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
                        chart.draw(data, options);
                    }, 26000);
                }
                -->
    </script>
</head>





<body>
<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "temp_database";
// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Connected successfully";
// The Chart table contains two fields: weekly_task and percentage
// This example will display a pie chart. If you need other charts such as a Bar chart, you will need to modify the code$



$query = "SELECT * FROM mytable ORDER BY id DESC LIMIT 1";
$qresult = $mysqli->query($query);
$results = array();

$gauge_data = array();

foreach($results as $result)
{
    $gauge_data[] = array($result['temperature']);
}
$gauge_data = json_encode($gauge_data);

$mysqli_free_result($qresult);
<!--this is the div that will hold the pie chart-->
<div id="chart_div"></div>
</body>
</html>
