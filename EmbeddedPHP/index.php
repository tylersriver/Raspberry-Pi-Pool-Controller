<html>
<!-- Created by:
Raspberry Pi Pool Controller

Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 7 March 2016
-->
<head>
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
    $query = "SELECT `tempLog`.`temperature`\n"
        . "FROM tempLog\n"
        . "ORDER BY `tempLog`.`datetime` DESC\n"
        . " LIMIT 1, 1 ";
    $qresult = $mysqli->query($query);
    $table = array();

    $query2 = "SELECT `waterTemp`.`temperature`\n"
        . "FROM waterTemp\n"
        . "ORDER BY `waterTemp`.`datetime` DESC\n"
        . " LIMIT 1, 1 ";

    $qresult2 = $mysqli->query($query2);

    //  $dataArray = array(array('temperature'));
    while ($row = mysqli_fetch_array($qresult)) {
        // parse the "SpeciesA" and "SpeciesB" values as integer (int) or floating point (float), as appropriate
        $dataArray = (float)$row['temperature'];
    }
    while ($row = mysqli_fetch_array($qresult2)) {
        // parse the "SpeciesA" and "SpeciesB" values as integer (int) or floating point (float), as appropriate
        $dataArray2 = (float)$row['temperature'];
    }
    ?>
    <title>Pool Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <!--Load the Ajax API-->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="graph/hourTempGraph.js"></script>
    <script type="text/javascript" src="graph/tempGauges.js"></script>
    <script>
        var now = new Date(<?php echo time() * 1000 ?>);
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }

        today = mm + '/' + dd + '/' + yyyy;
        function startInterval() {
            setInterval('updateTime();', 1000);
        }
        startInterval();//start it right away
        function updateTime() {
            var nowMS = now.getTime();
            nowMS += 1000;
            now.setTime(nowMS);
            var clock = document.getElementById('clock');
            if (clock) {
                clock.innerHTML = 'System Time: ' + today + ' ' + (now.toTimeString()).split(' ', 1);
            }

        }

    </script>



    <script type="text/javascript">
        $(document).ready(function () {
            $('#myonoffswitch').click(function () {
                var myonoffswitch = $('#myonoffswitch').val();
                if ($("#myonoffswitch:checked").length == 0) {
                    var b = "0";
                }
                else {
                    var b = "1";
                }
                $.ajax({
                    type: "POST",
                    url: "heaterUpdate.php",
                    data: "value=" + b,
                    success: function (html) {
                        $("#display").html(html).show();
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
                $('#myonoffswitch2').click(function () {
                    var myonoffswitch2 = $('#myonoffswitch2').val();
                    if ($("#myonoffswitch2:checked").length == 0) {
                        var a = "0";
                    }
                    else {
                        var a = "1";
                    }

                    $.ajax({
                        type: "POST",
                        url: "pumpUpdate.php",
                        data: "value=" + a,
                        success: function (html) {
                            $("#display").html(html).show();
                        }
                    });
                });
            });
        </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".cb-enable").click(function () {
                var parent = $(this).parents('.switch');
                $('.cb-disable', parent).removeClass('selected');
                $(this).addClass('selected');
                $('.checkbox', parent).attr('checked', true);
            });
            $(".cb-disable").click(function () {
                var parent = $(this).parents('.switch');
                $('.cb-enable', parent).removeClass('selected');
                $(this).addClass('selected');
                $('.checkbox', parent).attr('checked', false);
            });
        });
    </script>
</head>

<body>

<div id="dashboard">
    <div id="header">
        <h1>Pool Dashboard</h1>
    </div>

    <div id="widgets">
        <table>
            <td>
                <div class="nav">
                    <ul><li><div id="clock"></div></li></ul>
                </div>
            </td>
            <td> <div class="nav">
                    <div class="linkButtons">
                    <ul>

                            <li><a href="/scheduler/index.php" class="button">Scheduler</a></li>
                            <li><a href="/index.php" class="button">Dashboard</a></li>
                            <li><a href="/settings/index.php" class="button">Settings</a></li>
                            <li><a href="/stats/index.php" class="button">Stats</a></li>
                    </ul>
                    </div>
                </div>
            </td>
        </table>
        <div class="tile">
            <h4>Temperature</h4>
            <div id="tempGauges">
            </div>
        </div>
        <div class="tile">
            <div id="buttonControlTile">
                <div class="buttonContainer">
                    <h4>Heater</h4>
                    <div class="onoffswitch">
                        <?php
                        $db_host = "173.194.86.153";
                        $db_user = "pi";
                        $db_password = "rn4R9EfAarJpY5VwY8rnBlL2";
                        $db_database = "equipment";
                        $con = new mysqli($db_host, $db_user, $db_password, $db_database);
                        $sql = "select * from status order by id desc limit 1";
                        $exec = mysqli_query($con,$sql);
                        $result = mysqli_fetch_array($exec);

                        ?>
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" <?php if ($result['heater'] == "1") {
                            echo "checked";
                        }?>/>


                        <label class="onoffswitch-label" for="myonoffswitch" >
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label></div>
                </div>

                <div class="buttonContainer">
                    <h4>Pump</h4>
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch2" <?php if ($result['pump'] == "1") {
                            echo "checked";
                        }?>/>

                        <label class="onoffswitch-label" for="myonoffswitch2">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="doublewidthTile">
            <div id="tempChart"></div>
        </div>
    </div>
</div>
</body>
</html>
