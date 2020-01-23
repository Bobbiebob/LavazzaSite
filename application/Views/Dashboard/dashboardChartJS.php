<?php
$dayHour = [];
$day = [
    "0" => "Monday ",
    "1" => "Tuesday ",
    "2" => "Wednesday ",
    "3" => "Thursday ",
    "4" => "Friday ",
    "5" => "Saturday ",
    "6" => "Sunday "
];
$time = [
    "0" => "00:00",
    "1" => "01:00",
    "2" => "02:00",
    "3" => "03:00",
    "4" => "04:00",
    "5" => "05:00",
    "6" => "06:00",
    "7" => "07:00",
    "8" => "08:00",
    "9" => "09:00",
    "10" => "10:00",
    "11" => "11:00",
    "12" => "12:00",
    "13" => "13:00",
    "14" => "14:00",
    "15" => "15:00",
    "16" => "16:00",
    "17" => "17:00",
    "18" => "18:00",
    "19" => "19:00",
    "20" => "20:00",
    "21" => "21:00",
    "22" => "22:00",
    "23" => "23:00"
];
for ($i = 0; $i < 7; $i++){
    for ($x = 0; $x < 24; $x++){
        array_push($dayHour, $day[$i].($time[$x]));
    }
}
$datapoints = [
        -1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4,-1,-2,-4,-5,-5,-4,-3,-2,-1,0,3,5,6,7,9,10,7,4
];

$station = [
    "0" => "Peru 1",
    "1" => "Peru 2",
    "2" => "Peru 3",
    "3" => "Peru 4",
    "4" => "Peru 5",
    "5" => "Peru 6",
    "6" => "Peru 7"
];
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!--    <link rel="stylesheet" href="assets/css/main.css">-->

    <title>Lavazza Weather App</title>



</head>
<body>
    <?php require __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <canvas id="myChart" width="100%" height="40%"></canvas>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Station location</th>
                <th scope="col">Airpresure station level</th>
                <th scope="col">Airpresure sea level</th>
                <th scope="col">Dew point</th>
                <th scope="col">°C</th>
                <th scope="col">Visability km</th>
                <th scope="col">windspeed km/h</th>
                <th scope="col">rainfall cm</th>
                <th scope="col">snowfall cm</th>
            </tr>
            </thead>
            <tbody>
                <?php for($stationNumber = 0; $stationNumber < sizeof($station); $stationNumber++){?>
                    <tr>
                        <th scope="row-1"><?php echo $station[$stationNumber] ?></th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="/assets/chart/Chart.js" crossorigin="anonymous"></script>

    <script>
        var dayHourArray = <?php echo json_encode($dayHour); ?>;
        var datapointsArray = <?php echo json_encode($datapoints); ?>;
        var ctx = document.getElementById('myChart');

        var myChart = new Chart(ctx,{

            type: 'line',
            data: {
                labels: dayHourArray,
                datasets: [{
                    label: 'Degree Celcius',
                    borderColor: "#003087",
                    fill: false,
                    lineTension: 0.1,
                    clip: {left: 5, top: true, right: -2, bottom: 0},
                    data: datapointsArray,
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                }
            }
        });
    </script>
</body>
</html>