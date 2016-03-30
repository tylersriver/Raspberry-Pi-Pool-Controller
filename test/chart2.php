<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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

$sqlResult = $mysqli->query('SELECT * FROM tempLog LIMIT 30');
//$sql = mysqli_query($mysqli, 'SELECT * FROM analoog0');
$results = array(
    'cols' => array (
        array('label' => 'datetime', 'type' => 'datetime'),
        array('label' => 'temperature', 'type' => 'string')
    ),
    'rows' => array()
);
while($row = mysqli_fetch_assoc($sqlResult)) {
    // date assumes "yyyy-MM-dd" format
    $dateArr = explode('-', $row['datetime']);
    $year = (int) $dateArr[0];
    $month = (int) $dateArr[1] - 1; // subtract 1 to make month compatible with javascript months
    $day = (int) $dateArr[2];

    // time assumes "hh:mm:ss" format
    $timeArr = explode(':', $row['datetime']);
    $hour = (int) $timeArr[0];
    $minute = (int) $timeArr[1];
    $second = (int) $timeArr[2];

    $results['rows'][] = array('c' => array(
        array('v' => "Date($year, $month, $day, $hour, $minute, $second)"),
        array('v' => $row['temperature'])
    ));
}
$json = json_encode($results, JSON_NUMERIC_CHECK);
echo $json;

?>
    
    
    
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

      function drawChart() {
      $.ajax({
        dataType: 'json',
        success: function (jsonData) {
            // Create our data table out of JSON data loaded from server.
            var data = new google.visualization.DataTable(jsonData);

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, {width: 400, height: 240});
        }
    });
}

    </script>
    
  </head>

  <body>
    <div id="chart_div"></div>
  </body>
</html>