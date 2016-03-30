/**
 * Created by preston on 3/2/16.
 */
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
    var jsonData = $.ajax({
        url: "lastHour.php",
        dataType: "json",
        async: false
    }).responseText;


    var data = new google.visualization.DataTable(jsonData);
    var options = {
        title: 'Ambient Air Temperature',
        animation:
        {
            startup: 'true'
        },
        legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById("linechart"));
    chart.draw(data, options);
}
