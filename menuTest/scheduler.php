<html>
<!-- Created by:
Raspberry Pi Pool Controller

Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 1 March 2016
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
                    <ul>
                        <li>
                            <div class="clock">
                                <a href="/index.php">Scheduler</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </td>
        </table>
    </div>
</div>
</body>
</html>
