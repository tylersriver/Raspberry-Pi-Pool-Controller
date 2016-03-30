<html>
<head>
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



  //  $query = "SELECT * FROM tempLog ORDER BY id DESC LIMIT 1";
    $query = "SELECT `tempLog`.`temperature`\n"
        . "FROM tempLog\n"
        . "ORDER BY `tempLog`.`datetime` DESC\n"
        . " LIMIT 1, 1 ";
    $qresult = $mysqli->query($query);
    $table = array();

  //  $dataArray = array(array('temperature'));
    while($row = mysqli_fetch_array($qresult)) {
        // parse the "SpeciesA" and "SpeciesB" values as integer (int) or floating point (float), as appropriate
        $dataArray= (float) $row['temperature'];
    }
   // $dataArray= json_encode($dataArray);
    print $dataArray;
    //$mysqli_free_result($qresult);
    ?>

    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        var value = "<?php echo $dataArray ?>";
        value = parseFloat(value);
        // Load the Visualization API and the piechart package.
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var value1 = "<?php echo $dataArray ?>";
            value1= parseFloat(value1);
            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Temperature', value1]]);

            var options = {
                width: 400, height: 400,
                redFrom: 100, redTo: 110,
                yellowFrom:90, yellowTo: 100,
                minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>

</head>

<body>
<div id="chart_div" style="width: 400px; height: 120px;"></div>
</body>
</html>