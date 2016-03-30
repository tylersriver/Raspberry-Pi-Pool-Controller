<html>
<!-- Created by:
Raspberry Pi Pool Controller

Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 1 March 2016
-->
<head>

    <title>Scheduling</title>
    <link rel="stylesheet" href="jquery.timepicker.css">
    <!--Load the Ajax API-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.timepicker.min.js"</script>
    <script; type="text/javascript"; src="lib/bootstrap-datepicker.js"></script>

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
                        <div class="clock">
                            <li><a href="/time-test /index.php">Scheduler</a></li>
                            <li><a href="/index.php">Dashboard</a> </li>
                        </div>
                    </ul>
                </div>
            </td>
        </table>
        <div class="doubleWidthTile">
            <p id="datepairExample">
                <input type="text" class="date start" />
                <input type="text" class="time start" /> to
                <input type="text" class="time end" />
                <input type="text" class="date end" />
            </p>

            <script type="text/javascript" src="datepair.js"></script>
            <script type="text/javascript" src="jquery.datepair.js"></script>
            <script>
                // initialize input widgets first
                $('#datepairExample .time').timepicker({
                    'showDuration': true,
                    'timeFormat': 'g:ia'
                });

                $('#datepairExample .date').datepicker({
                    'format': 'yyyy-m-d',
                    'autoclose': true
                });

                // initialize datepair
                $('#datepairExample').datepair();
            </script>
        </div>
        <div class="doublewidthTile">
            <div id="tempChart"></div>
        </div>
    </div>
</div>
</body>
</html>
