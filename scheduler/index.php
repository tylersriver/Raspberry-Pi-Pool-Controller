<html>
<!-- Created by:
Raspberry Pi Pool Controller

Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 6 April 2016
-->
<head>
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1">
    -->
    <title>Scheduler</title>
    <link rel="stylesheet" type="text/css" href="../styles.css"/>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.js"></script>
    <script type="text/javascript" src="jquery.timepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="../timepicker/jquery.timepicker.css" />

    <link rel="stylesheet" type="text/css" href="../timepicker/lib/site.css"/>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="../timepicker/jquery.timepicker.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var scheduleData = $.ajax({
                url: "getSchedule.php",
                dataType: "json",
                async: false
            }).responseText;


            //parse the json array

            scheduleData = JSON.parse(scheduleData);
            if(scheduleData.length != 0) {
                console.log(scheduleData);
                console.log(scheduleData[0]);
                for (var i = 0, len = scheduleData.length; i < len; i++) {
                    var day;
                    var dayNum = scheduleData[i].day;
                    switch (dayNum) {
                        case "0":
                            day = "Monday";
                            break;
                        case "1":
                            day = "Tuesday";
                            break;
                        case "2":
                            day = "Wednesday";
                            break;
                        case "3":
                            day = "Thursday";
                            break;
                        case "4":
                            day = "Friday";
                            break;
                        case "5":
                            day = "Saturday";
                            break;
                        case "6":
                            day = "Sunday";
                            break;
                    }
                    console.log(day);
                    document.getElementById(day).classList.add("ui-selected");
                }


                //get the values we need
                var start = scheduleData[0].start;
                var stop = scheduleData[0].stop;
                // var day = scheduleData.
                $('#startTime').val(start);
                $('#stopTime').val(stop);



            }

        });
            </script>


    <script>
        $(function() {
            $('#startTime').timepicker({'step': 15, 'timeFormat': 'H:i'});
            $('#stopTime').timepicker({'step': 15, 'timeFormat': 'H:i'});

            $('#startTime').on('changeTime', function() {
                    console.log($(this).val());
             //   console.log($(this).css("background-color"));
                if($(this).val() > $('#stopTime').val() && $('#stopTime').val() != "")
                {
                    alert("You must select a stop time greater than the start time.")
                    $(this).val($("#stopTime").val());
                    $(this).css("background-color", "red");
                }
                else {
                    $(this).css("background-color", "white");
                    $('#stopTime').css("background-color", "white");
                }
                });
            $('#stopTime').on('changeTime', function() {
                console.log($(this).val());
                console.log( $('#startTime').val())
                if($(this).val() < $('#startTime').val() && $('#startTime').val() != "")
                {
                    alert("You must select a stop time greater than the start time.")
                    $(this).val($("#startTime").val());
                    $(this).css("background-color", "red");
                }
                else {
                    $(this).css("background-color", "white");
                    $('#startTime').css("background-color", "white");
                }
            });



        });
    </script>
    <script type="text/javascript">
        $(function() {
            $("#selectable").selectable({
                selected: function (event , ui) {
                            console.log(ui.selected.id + " selected!");
                }
            });
        });

    </script>
    <script>
        $(function () {
            $('button').click(function () {
                var ids = $('#selectable .ui-selected').map(function () {
                    return $(this).data('userid');
                });
                var data = {
                    days: ids.toArray(),
                    startTime: $('#startTime').val(),
                    stopTime: $('#stopTime').val()
                };
                console.log(data);
                console.log(JSON.stringify(data));

                console.log('userid: ' + ids.toArray().join(',') + '\n The time selected is: ' + $('#startTime').val() + ' to ' + $('#stopTime').val());
              //  data = $(this).serialize() + "&" + $.param(JSON.stringify(data));
                jsonData = JSON.stringify(data);
                console.log(data);

                $.ajax({
                    type: "POST",
                    url: "updateSchedule.php", //Relative or absolute path to response.php file
                    data: {
                        days: ids.toArray(),
                        startTime: $('#startTime').val(),
                        stopTime: $('#stopTime').val()
                    },
                    success:function(result)//we got the response
                    {
                        console.log(result);
                   //     alert('Successfully called');
                    },
                    error:function(exception){alert('Exeption:'+exception);}
                });
            });
        });
    </script>

    <script>
        $(function() {
            $( "#selectable" ).selectable();
        });
    </script>
    <script type="text/javascript">
        var regex = /^(.+?)(\d+)$/i;
        var cloneIndex = $(".clonedInput").length;

        function clone(){
            $(this).parents(".clonedInput").clone()
                .appendTo("body")
                .attr("id", "clonedInput" +  cloneIndex)
                .find("*")
                .each(function() {
                    var id = this.id || "";
                    var match = id.match(regex) || [];
                    if (match.length == 3) {
                        this.id = match[1] + (cloneIndex);
                    }
                })
                .on('click', 'button.clone', clone)
                .on('click', 'button.remove', remove);
            cloneIndex++;
        }
        function remove(){
            $(this).parents(".clonedInput").remove();
        }
        $("button.clone").on("click", clone);

        $("button.remove").on("click", remove);
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
        <h1>Scheduler</h1>
        <div id="widgets">
            <table>
                <td>
                    <div class="nav">
                        <ul><li><div id="clock"></div></li></ul>
                    </div>
                </td>
                <td> <div class="nav">
                        <div class="navButtons">
                            <ul>
                                <li><a href="/index.php" class="button">Dashboard</a></li>
                                <li><a href="/scheduler/index.php" class="button">Scheduler</a></li>
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


        <div class="doublewidthTileSkinny">
            <div id="timeSelection">
                <div class = "timeContainer">
                Start Time:
                    <input id="startTime" type="text" class="time ui-timepicker-input" autocomplete="off">
                </div>
                <div class="timeContainer">
                Stop Time:
                <input id="stopTime" type="text" class="time ui-timepicker-input" autocomplete="off">
                </div>
            </div>
            <div id="daysOfWeek">
            <ol id="selectable">
                <li id="Monday" class="ui-state-default" data-userid="Monday">M</li>
                <li id="Tuesday" class="ui-state-default" data-userid="Tuesday">T</li>
                <li id="Wednesday" class="ui-state-default" data-userid="Wednesday">W</li>
                <li id="Thursday" class="ui-state-default" data-userid="Thursday">TH</li>
                <li id="Friday" class="ui-state-default" data-userid="Friday">F</li>
                <li id="Saturday" class="ui-state-default" data-userid="Saturday">S</li>
                <li id="Sunday" class="ui-state-default" data-userid="Sunday">SU</li>
            </ol>


                <p>Hold "ctrl" (Command on Mac) to select multiple days.</p>
                <p><button>Save</button></p>
                </div>
            </div>

    </div>


</body>
</html>
