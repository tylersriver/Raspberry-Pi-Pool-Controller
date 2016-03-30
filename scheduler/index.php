<html ng-app="app">
<!-- Created by:
Raspberry Pi Pool Controller

Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 8 March 2016
-->
<head>

    <title>Scheduling</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>

    <script src="jquery.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/ngTimepicker-master/src/css/ngTimepicker.css">



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
                        <div>
                            <li><a href="/scheduler/index.php" class="button">Scheduler</a></li>
                            <li><a href="/index.php" class="button">Dashboard</a></li>
                            <li><a href="/settings/index.php" class="button">Settings</a></li>
                            <li><a href="/stats/index.php" class="button">Stats</a></li>
                        </div>
                    </ul>
                </div>
            </td>
        </table>

        <body ng-controller="Ctrl as ctrl">

        <div class="doublewidthTile">
            <ng-timepicker ng-model="ctrl.time"></ng-timepicker>
            {{ ctrl.time }}

            <ng-timepicker ng-model="ctrl.time2" theme="red" show-meridian="true"></ng-timepicker>
            {{ ctrl.time2 }}

            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular.min.js"></script>
            <script type="text/javascript" src="/ngTimepicker-master/src/js/ngTimepicker.min.js"></script>

            <script type="text/javascript">
                var app = angular.module('app', ['jkuri.timepicker']);
                app.controller('Ctrl', [function() {

                }]);
            </script>

            </div>

    </div>


        </div>




        </body>
</html>
