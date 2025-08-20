
/*=============================================================
Authour URL: www.htmladmin.com

http://www.htmladmin.com/

License: MIT

http://opensource.org/licenses/MIT

100% Free To use For Personal And Commercial Use.

IN EXCHANGE JUST TELL PEOPLE ABOUT THIS WEBSITE

======================================================== */

// BAR CHART SCRIPTS

var barChartData = {
    labels: ["2010", "2011", "2012", "2013", "2014", "2015"],
    datasets: [
        {
            //SET COLORS BELOW
            fillColor: "rgba(76,194,88,0.5)",
            strokeColor: "rgba(76,194,88,0.8)",
            highlightFill: "rgba(76,194,88,0.75)",
            highlightStroke: "rgba(76,194,88,1)",
            data: [35, 45, 90, 100, 150, 160] // SET YOUR DATA POINTS HERE
        },
        {
            fillColor: "rgba(44,98,191,0.5)",
            strokeColor: "rgba(44,98,191,0.8)",
            highlightFill: "rgba(44,98,191,0.75)",
            highlightStroke: "rgba(44,98,191,1)",
            data: [15, 55, 40, 80, 50, 180] // SET YOUR DATA POINTS HERE
        }
    ]

}

// LINE CHART SCRIPTS

var lineChartData = {
    labels: ["January", "February", "March", "April", "May", "June"],
    datasets: [
        {
            label: "My First dataset",
            fillColor: "rgba(44,98,191,0.75)", // SET COLORS BELOW
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(250,250,250,1)",
            data: [35, 45, 90, 20, 90, 160] // SET YOUR DATA POINTS HERE
        },
        {
            label: "My Second dataset",
            fillColor: "rgba(229, 83, 76, 0.4)", // SET COLORS BELOW
            strokeColor: "rgba(229, 83, 76, 0.6)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#000",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [15, 55, 40, 80, 120, 160] // SET YOUR DATA POINTS HERE
        }
    ]

}

window.onload = function () {

    var ctx = document.getElementById("my-bar-chart").getContext("2d");
    window.myLine = new Chart(ctx).Bar(barChartData, {
        responsive: true
    });

    var ctxl = document.getElementById("my-line-chart").getContext("2d");
    window.myLine = new Chart(ctxl).Line(lineChartData, {
        responsive: true
    });
};