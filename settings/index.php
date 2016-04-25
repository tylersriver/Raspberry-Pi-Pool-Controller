<html>
<!-- Created by:
Raspberry Pi Pool Controller

Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016
Last Revision: 5 April 2016
-->
<head>
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1">
    -->
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="../styles.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="rangeslider.css"/>
    <script src="rangeslider.min.js"></script>
    <script>
        // Initialize a new plugin instance for all
        // e.g. $('input[type="range"]') elements.
        $('input[type="range"]').rangeslider();

        // Destroy all plugin instances created from the
        // e.g. $('input[type="range"]') elements.
        $('input[type="range"]').rangeslider('destroy');

        // Update all rangeslider instances for all
        // e.g. $('input[type="range"]') elements.
        // Usefull if you changed some attributes e.g. `min` or `max` etc.
        $('input[type="range"]').rangeslider('update', true);
    </script>

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
        <div id="header_padding"></div>
        <h1>Settings</h1>
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
        </div>
    </div>

    <div id="widgets">
        <div class="tile">
            <h4>Temperature Units</h4>
            <ul>
                <li><input id="fahrenheit" type="radio" onClick="fahrenheit(this);" />Fahrenheit</li>
                <li><input id="celsius" type="radio" onClick="celsius(this);"/>Celsius</li>
            </ul>
            <script>
                $(function() {
                    var settings = $.ajax({
                        url: "getState.php",
                        dataType: "json",
                        async: false
                    }).responseText;
                    settings = JSON.parse(settings);
                    console.log(settings);
                    console.log(settings.units);
                    if(settings.units == "F") {
                        document.getElementById('celsius').checked = false;
                        document.getElementById('fahrenheit').checked = true;

                    }
                    else {
                        document.getElementById('fahrenheit').checked = false;
                        document.getElementById('celsius').checked = true;
                    }
                });
            </script>
            <script>
                function fahrenheit(obj) {
                    if (obj.checked == true) {
                        var a = 'F';
                        console.log("F selected");
                        document.getElementById("celsius").checked = false;
                        $.ajax({
                            type: "POST",
                            url: "updateState.php",
                            data: "value=" + a,
                            success: function (html) {
                                $("#display").html(html).show();
                            }
                        });
                    }
                }
                function celsius(obj) {
                    if (obj.checked == true) {
                        var a = 'C';
                        console.log("C selected");
                        document.getElementById("fahrenheit").checked = false;
                        $.ajax({
                            type: "POST",
                            url: "updateState.php",
                            data: "value=" + a,
                            success: function (html) {
                                $("#display").html(html).show();
                            }
                        });
                    }
                }
            </script>
        </div>
        <!--<div class="tile">
            <h4>Manual Temperature Setting</h4>
            
        </div>
        -->
       <!-- <div class="doublewidthTile">
            <h4>Automatic Water Circulation</h4>
            <h6>This secton can be used to automatically circulate water for a specified amount of time every hour.</h6>
            <input type="range" min="10" max="1000" step="10" value="300" data-orientation="vertical"/>
        </div>
        --->

    </div>
</div>


</body>
</html>
