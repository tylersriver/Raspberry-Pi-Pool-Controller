/**
 * Created by Preston Kemp on 3/2/16
 * This file fetches the last 60 data points from the database and then graphs them using the Google Charts API
 *
 */

//Waits until the charts API has loaded before drawing the chart
google.charts.setOnLoadCallback(drawChart);

//function for drawing the temperature graph
function drawChart() {
    var jsonData = $.ajax({
        url: "http://ubuntu1.prestonkemp.com/graph/lastHour.php",
        dataType: "json",
        async: false
    }).responseText;
    jsonData=JSON.parse(jsonData);
    var jsonObj = JSON.parse(jsonData);
    var data = new google.visualization.DataTable(jsonData);
    var options = {
        title: 'Hourly Temperature Data',
        backgroundColor:'transparent',
        width:'880',
        height: '300',
        gridlines: {
            units: {
                days: {format: ['MMM dd']},
                hours: {format: ['HH:mm', 'ha']},
            }
        },
        vAxis : {

            viewWindowMode: 'pretty',
            format: 'decimal'
        },
        hAxis:
        {
            minValue: '30'
        }
    };

    var chart = new google.charts.Line(document.getElementById("tempChart"));
    chart.draw(data, google.charts.Line.convertOptions(options));
}

