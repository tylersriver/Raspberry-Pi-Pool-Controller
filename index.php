<html>
<!-- Created by:
Raspberry Pi Pool Controller

Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 12 April 2016
-->
<head>
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
        function convertMS(ms) {
            var d, h, m, s;
            s = Math.floor(ms / 1000);
            m = Math.floor(s / 60);
            s = s % 60;
            h = Math.floor(m / 60);
            m = m % 60;
            d = Math.floor(h / 24);
            h = h % 24;
            return { d: d, h: h, m: m, s: s };
        }


        $(document).ready(function () {
                var buttonData = $.ajax({
                    url: "supporting/php/getStatus.php",
                    dataType: "json",
                    async: false
                }).responseText;


                //parse the json array
                buttonData = JSON.parse(buttonData);
                buttonData = JSON.parse(buttonData);
            console.log(buttonData);

                //get the values we need
                var pump = buttonData[0].status;
                var heater = buttonData[1].status;
                var setPoint = buttonData[3].setPoint;
                var interrupt = buttonData[2].manual;
            console.log(pump);
            console.log(heater);





            setInterval(function ()
            {
                var pumpTime = new Date(buttonData[0].time).getTime()-now.getTime();
                var heaterTime = new Date(buttonData[1].time).getTime()-now.getTime();

                var pumpState;
                var heaterState;

                if(pump == 1)
                {
                    pumpState = "ON";
                }
                else
                {
                    pumpState = "OFF";
                }
                if(heater == 1)
                {
                    heaterState = "ON";
                }
                else
                {
                    heaterState = "OFF";
                }

                pumpTime = convertMS(-pumpTime);
                heaterTime = convertMS(-heaterTime);

                $("#heaterStateTime").html("<h4>Heater " + heaterState + " for: " + heaterTime.d +":"+ heaterTime.h + ":" + heaterTime.m + ":" + heaterTime.s + "</h4>");
                $("#pumpStateTime").html("<h4>Pump  " + pumpState + " for: " + pumpTime.d +":"+ pumpTime.h + ":" + pumpTime.m + ":" + pumpTime.s +  "</h4>");

            }, 1000);




                var pumpState = "";
                var heaterState = "";

                if (pump == 1) {
                    pumpState = "checked";
                    document.getElementById("myonoffswitch2").checked = true;
                }
                if (heater == 1) {
                    heaterState = "checked";
                    document.getElementById("myonoffswitch").checked = true;
                }
               if (interrupt == 1) {
                     heaterState = "checked";
                     document.getElementById("myonoffswitch3").checked = true;
              }






                console.log(pump);
                console.log(heater);

            $('#myonoffswitch').click(function () {
                var myonoffswitch = $('#myonoffswitch').val();
                if ($("#myonoffswitch:checked").length == 0) {
                    var b = "0";
                    $('#myonoffswitch2').prop("disabled", false);
                    $('.buttonContainer:nth-child(2)').fadeTo(500,1);

                }
                else {
                    var b = "1";
                    if($("#myonoffswitch2:checked").length == 0)
                    {
                        $("#myonoffswitch2").trigger("click");
                    }
                    $('#myonoffswitch2').prop("disabled", true);
                    $('.buttonContainer:nth-child(2)').fadeTo(500,.2);

                }

                $.ajax({
                    type: "POST",
                    url: "supporting/php/equipment_update/heaterUpdate.php",
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
                            url: "supporting/php/equipment_update/pumpUpdate.php",
                            data: "value=" + a,
                            success: function (html) {
                                $("#display").html(html).show();
                            }
                        });

                });

            });
        </script>
    <script>
        $(document).ready(function () {
            $('#myonoffswitch3').click(function () {
                var myonoffswitch = $('#myonoffswitch3').val();
                //set both Pump and Heater to off
                if ($("#myonoffswitch3:checked").length == 1) {
                    var b = "1";
                    $('#myonoffswitch2').prop("disabled", false);
                    $('#myonoffswitch').prop("disabled", false);
                    $('.buttonContainer:nth-child(1)').fadeTo(500, 1);
                    $('.buttonContainer:nth-child(2)').fadeTo(500, 1);


                }
                if ($("#myonoffswitch3:checked").length == 0) {
                    var b = "0";
                    document.getElementById("myonoffswitch").checked = false;
                    document.getElementById("myonoffswitch2").checked = false;
                    $('#myonoffswitch2').prop("disabled", true);
                    $('.buttonContainer:nth-child(2)').fadeTo(500, .2);
                    $('#myonoffswitch').prop("disabled", true);
                    $('.buttonContainer:nth-child(1)').fadeTo(500, .2);
                    $.ajax({
                        type: "POST",
                        url: "supporting/php/equipment_update/heaterUpdate.php",
                        data: "value=" + 0,
                        success: function (html) {
                            $("#display").html(html).show();
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "supporting/php/equipment_update/pumpUpdate.php",
                        data: "value=" + 0,
                        success: function (html) {
                            $("#display").html(html).show();
                        }
                    });

                }
                $.ajax({
                    type: "POST",
                    url: "supporting/php/equipment_update/manualUpdate.php",
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
            if($("#myonoffswitch:checked").length == 1)
        {
            $('#myonoffswitch2').prop("disabled", true);
            $('.buttonContainer:nth-child(2)').fadeTo(500,.2);
        }
            if($("#myonoffswitch3:checked").length == 0) {
                $('#myonoffswitch2').prop("disabled", true);
                $('.buttonContainer:nth-child(2)').fadeTo(500, .2);
                $('#myonoffswitch').prop("disabled", true);
                $('.buttonContainer:nth-child(1)').fadeTo(500, .2);
            }

        });
    </script>
</head>

<body>

<div id="dashboard">
    <div id="header">
        <div id="header_padding"></div>
        <h1>Dashboard</h1>
            <div id="widgets">
                <table>
                    <td>
                        <div class="nav">
                            <ul><li><div id="clock"></div></li></ul>
                        </div>
                        <div class="stateTime" id="heaterStateTime">

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
                        <div class="stateTime" id="pumpStateTime">

                        </div>
                    </td>
                </table>
            </div>
    </div>

    <div id="widgets">
        <div class="tile">
            <h4>Temperature</h4>
            <div id="tempGauges">
            </div>
            <div id ="heaterSetPoint"></div>

        </div>
        <div class="tile">
            <div id="buttonControlTile">
                <div class="buttonContainer">
                    <h4>Heater</h4>
                    <div class="onoffswitch">

                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" />


                        <label class="onoffswitch-label" for="myonoffswitch" >
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label></div>
                </div>

                <div class="buttonContainer">
                    <h4>Pump</h4>
                    <div class="onoffswitch">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch2" />

                            <label class="onoffswitch-label" for="myonoffswitch2">
                                <div class="onoffswitch-inner"></div>
                                <div class="onoffswitch-switch"></div>
                            </label>
                    </div>
                </div>
                <div class="buttonContainer">
                    <h4>Manual Control</h4>
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch3" />

                        <label class="onoffswitch-label" for="myonoffswitch3">
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
