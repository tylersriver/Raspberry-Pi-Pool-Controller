<html>
<head>

    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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

    //$mysqli_free_result($qresult);
    ?>
    <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Temperature', 50]
            ]);

            var options = {
                width: 400, height: 400,
                redFrom: 90, redTo: 100,
                yellowFrom: 75, yellowTo: 90,
                minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

            chart.draw(data, options);
        }

    </script>
</head>

<body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="chart_div" style="width: 400px; height: 120px;"></div>
</body>
</html>