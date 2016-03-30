<!-- Created by:
Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 22 February 2016
-->
<html>

<head>

    <title>RPi Pool Controller</title>

    <script type="text/javascript" language="javascript">

        function updateTempStats() {

            $.get("../php/temp.php", function(data) {

                $("#chart_div").html(data)

            });

            window.setTimeout("updateTempStats();", 10000);

        }


        $(document).ready(function() {

            updateTempStats();

        });

    </script>
    <link rel="stylesheet" href="styles.css">
    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load the Visualization API and the piechart package.
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);

        $.ajax({
            type: "POST",
            url: "../php/temperature.php",
            data: somedata,
            success function(json_data){
                var data_array = $.parseJSON(json_data);

                //access your data like this:
                var plum_or_whatever = data_array['output'];.
                //continue from here...
            }
        });

        function drawChart() {
            var airTemp = "<?php echo $dataArray ?>";
            var waterTemp = "<?php echo $dataArray2 ?>";
            airTemp= parseFloat(airTemp);
            waterTemp = parseFloat(waterTemp);

            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Water', airTemp]
            ]);

            var data2 = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Ambient', waterTemp]
            ]);

            var options = {
                width: 200, height: 200,
                redFrom: 100, redTo: 110,
                yellowFrom:90, yellowTo: 100,
                minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
            var chart2 = new google.visualization.Gauge(document.getElementById('chart_div2'));

            chart.draw(data, options);
            chart2.draw(data2, options);

        }

    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#myonoffswitch').click(function(){
                var myonoffswitch=$('#myonoffswitch').val();
                if ($("#myonoffswitch:checked").length == 0)
                {
                    var a="off";
                }
                else
                {
                    var a="on";
                }

                $.ajax({
                    type: "POST",
                    url: "../php/temperature.php",
                    data: somedata,
                success function(json_data){
                    var data_array = $.parseJSON(json_data);

                    //access your data like this:
                    var plum_or_whatever = data_array['output'];.
                    //continue from here...
                }
            });

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#myonoffswitch2').click(function(){
                var myonoffswitch=$('#myonoffswitch2').val();
                if ($("#myonoffswitch2:checked").length == 0)
                {
                    var a="off";
                }
                else
                {
                    var a="on";
                }

                $.ajax({
                    type: "POST",
                    url: "ledcontrol2.php",
                    data: "value="+a ,
                    success: function(html){
                        $("#display").html(html).show();
                    }
                });

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready( function(){
            $(".cb-enable").click(function(){
                var parent = $(this).parents('.switch');
                $('.cb-disable',parent).removeClass('selected');
                $(this).addClass('selected');
                $('.checkbox',parent).attr('checked', true);
            });
            $(".cb-disable").click(function(){
                var parent = $(this).parents('.switch');
                $('.cb-enable',parent).removeClass('selected');
                $(this).addClass('selected');
                $('.checkbox',parent).attr('checked', false);
            });
        });
    </script>

</head>

<body>
<div class="jumbotron">
    <h1>Raspberry Pi Pool Controller</h1>
    <h1>
        <iframe src="http://free.timeanddate.com/clock/i52vnyfd/n184/fcfff/tct/pct/ftb/tt0/tw1/tm1" frameborder="0" width="227" height="18" allowTransparency="true"></iframe>
    </h1>
    <table>
        <tr>
            <td>
                <div class="temp_container">
                    <table>
                        <tr><td colspan="2">
                                <h4>Temperature</h4>
                            </td></tr>
                        <tr>
                            <td><div id="chart_div"></div></td>
                            <td><div id="chart_div2"></div></td>
                        </tr>
                    </table>
                </div>
            </td>

            <td>
                <div class="controls">
                    <div class="buttonContainer">
                        <h4>Heater</h4>
                        <div class="onoffswitch">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch"/>
                            <?php
	
  													  $servername = "173.194.86.153";
															$username = "pi";
															$password = "rn4R9EfAarJpY5VwY8rnBlL2";
															$dbname = "temp_db";
															// Create connection
															$mysqli = new mysqli($servername, $username, $password, $dbname);
															// Check connection
															if ($mysqli->connect_error) {
																	die("Connection failed: " . $mysqli->connect_error);
															}
															echo "Connected successfully";

                            $query3="select * from choice where id=1";
                            $qresult = $mysqli->query($query3);
                            if($qresult['choice']=="on")
                            {
                                echo "checked";
                            }
                            ?>

                            <label class="onoffswitch-label" for="myonoffswitch">
                                <div class="onoffswitch-inner"></div>
                                <div class="onoffswitch-switch"></div>
                            </label></div>
                    </div>

                    <div class="buttonContainer">
                        <h4>Pump</h4>
                        <div class="onoffswitch">
                            <input type="checkbox" name="onoffswitch2" class="onoffswitch-checkbox" id="myonoffswitch2"/>
                            <?php
                            $query3="select * from choice where id=2";
                            $qresult = $mysqli->query($query3);
                            if($qresult['choice']=="on")
                            {
                                echo "checked";
                            }

                            ?>
                            <label class="onoffswitch-label" for="myonoffswitch2">
                                <div class="onoffswitch-inner"></div>
                                <div class="onoffswitch-switch"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </td>

</body>
</html>
