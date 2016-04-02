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

        <body>

        <script>
            $(function() {
                $( "#accordion" ).accordion();
            });
        </script>

        <div id="accordion">
            <h3>Section 1</h3>
            <div>
                <p>
                    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
                    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
                    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
                    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
                </p>
            </div>
            <h3>Section 2</h3>
            <div>
                <p>
                    Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
                    purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
                    velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
                    suscipit faucibus urna.
                </p>
            </div>
            <h3>Section 3</h3>
            <div>
                <p>
                    Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
                    Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
                    ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
                    lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
                </p>
                <ul>
                    <li>List item one</li>
                    <li>List item two</li>
                    <li>List item three</li>
                </ul>
            </div>
            <h3>Section 4</h3>
            <div>
                <p>
                    Cras dictum. Pellentesque habitant morbi tristique senectus et netus
                    et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
                    faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
                    mauris vel est.
                </p>
                <p>
                    Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
                    Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
                    inceptos himenaeos.
                </p>
            </div>
        </div>

    </div>


        </div>




        </body>
</html>
