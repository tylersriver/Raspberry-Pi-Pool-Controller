 <?php
    $db_host = "173.194.86.153";
    $db_user = "pi";
    $db_password = "rn4R9EfAarJpY5VwY8rnBlL2";
    $db_database = "temp_database";
 $con = new mysqli($db_host, $db_user, $db_password, $db_database);
 //$con = mysqli_connect('hostname','username','password','database');
?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <meta charset="utf-8">
        <title>
            {DEV} Temperature Graph - Google Charts
        </title>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([

                    [{type: 'timeofday', label: 'Time'}, 'Temperature'],
                    <?php
//                    $sqlQuery =
//                        "SELECT  `airTemp`.`id` ,  `airTemp`.`temperature`
//                          FROM airTemp
//                          ORDER BY  `airTemp`.`id` DESC
//                            LIMIT 0 , 60";

                    $sqlQuery =
                        "(select * from airTemp order by id desc limit 30) order by id asc\n"
                        . "";

                    $exec = mysqli_query($con,$sqlQuery);
                    while($row = mysqli_fetch_array($exec)){

                        //        date assumes "yyyy-MM-dd" format
                        $dateArr = explode('-', $row['datetime']);
                        $year = (int) $dateArr[0];
                        $month = (int) $dateArr[1] - 1; // subtract 1 to make month compatible with javascript months
                        $day = (int) $dateArr[2];


                        $time = explode(' ', $row['datetime']);
                        // time assumes "hh:mm:ss" format
                        $timeArr = explode(':', $time[1]);
                        $hour = (int) $timeArr[0];
                        $minute = (int) $timeArr[1];
                        $second = (int) $timeArr[2];

                    //    echo "['".$row['id']."',".$row['temperature']."],";
                    //    echo "['".(int)$timeArr[1]."',".$row['temperature']."],";
                   //     echo "['".$row['datetime']."',".$row['temperature']."],";
                        echo "[[".$hour.",".$minute.",".$second."],".$row['temperature']."],";

                    }
                    ?>

                ]);

                var options = {
                    title: 'Ambient Air Temperature',
                    animation:
                    {
                        startup: 'true'
                    },
//                    hAxis: {
//                        format: 'HH:MM:SS',
//                        gridlines: {count: 15}
//                    },
                    legend: { position: 'bottom' }
                };

                var chart = new google.visualization.LineChart(document.getElementById("linechart"));
                chart.draw(data, options);
            }
        </script>
    </head>
<body>
<div id="linechart" style="width: 90%; height: 500px;"></div>
</body>
</html>