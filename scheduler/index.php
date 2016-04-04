<html>
<!-- Created by:
Raspberry Pi Pool Controller

Preston Kemp
Tyler Sriver
Embedded Systems Design SP2016

Last Revision: 8 March 2016
-->
<head>
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1">
    -->
    <title>Scheduler</title>
    <link rel="stylesheet" type="text/css" href="../styles.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">

    <style>
        #feedback { font-size: 1.4em; }
        #selectable .ui-selecting { background: #FECA40; }
        #selectable .ui-selected { background: #F39814; color: white; }
        #selectable { list-style-type: none; margin: 0; padding: 0;  }
        #selectable li { margin: 3px; padding: 1px; float: left; width: 50px; height: 40px; font-size: 2em; text-align: center; }
    </style>
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
        <div class="skinnyTile">

        </div>

        <div class="doublewidthTile">
            <ol id="selectable">
                <li class="ui-state-default">M</li>
                <li class="ui-state-default">T</li>
                <li class="ui-state-default">W</li>
                <li class="ui-state-default">TH</li>
                <li class="ui-state-default">F</li>
                <li class="ui-state-default">S</li>
                <li class="ui-state-default">SU</li>
            </ol>
            </div>
        <div class="doublewidthTile">

            <div id="clonedInput1" class="clonedInput">
                <div>
                    <label for="txtCategory" class="">Learning category <span class="requiredField">*</span></label>
                    <select class="" name="txtCategory[]" id="category1">
                        <option value="">Please select</option>
                    </select>
                </div>
                <div>
                    <label for="txtSubCategory" class="">Sub-category <span class="requiredField">*</span></label>
                    <select class="" name="txtSubCategory[]" id="subcategory1">
                        <option value="">Please select category</option>
                    </select>
                </div>
                <div>
                    <label for="txtSubSubCategory">Sub-sub-category <span class="requiredField">*</span></label>
                    <select name="txtSubSubCategory[]" id="subsubcategory1">
                        <option value="">Please select sub-category</option>
                    </select>
                </div>
                <div class="actions">
                    <button class="clone">Clone</button>
                    <button class="remove">Remove</button>
                </div>
                </div>




        </div>
    </div>


</body>
</html>
