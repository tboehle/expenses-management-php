/**
 * Created by thorb on 25.04.2017.
 */
// Wir holen uns die Daten per AJAX
$(document).ready(function()
{
    $.ajax({
        url: "http://localhost:8080/projektmanagement/chartjs/data.php",
        method: "GET",
        success: function (data) {
            console.log(data);
            var player = [];
            var score = [];

            for (var i in data)
            {
                player.push("Player " + data[i].playerid);
                player.push(data[i].score);
            }

            // Daten fürs Chart bereitstellen:
            var chartdata = {
                labels: player,
                datasets : [
                    {
                        label: 'Player Score',
                        backgroundColor: 'rgba(200, 200, 200, 0.75)',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: score
                    }
                ]
            };

            // Bezug zum Element in der HTML
            var ctx = $("#mycanvas");

            // Kreieren eines Chartobjekts, um Graph zu zeichnen
            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
});