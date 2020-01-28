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
    
    <style>
        body {
            background: #eaeaea;
        }
    </style>

</head>
<body>
    <?php require __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container-fluid p-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Temperature</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" width="100%" height="40%"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Data per station</h5>
                    </div>
                    <div class="card-body">
                        <table class="table datatables">
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
                                <tr>
                                    <th scope="row-1"></th>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>

<script src="/assets/chart/Chart.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

    <script>

        $(document).ready( function () {
            $('.datatables#table_id').DataTable();
        } );

        function getData() {
            $.get("/api/graph/12912/temperature", function(data) {
                // console.log(data);

                rawData = JSON.parse(data).data;
                data = []
                $.each(rawData, function (key, value) {

                    // console.log(value);

                    data.push({
                        x: new Date(value.x*1000),
                        y: value.y
                    });
                });

                window.chart.data.datasets[0].data = data;

                window.chart.update();

            });
        }

        getData();
        setInterval(getData, 1000);

        var ctx = document.getElementById('myChart');

        window.chart = new Chart(ctx,{

            type: 'line',
            data: {
                datasets: [{
                    label: 'Temperature in deg C',
                    borderColor: "#003087",
                    fill: false,
                    lineTension: 0.1,
                    clip: {left: 5, top: true, right: -2, bottom: 0},
                    data: [],
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    xAxes: [{
                        type: 'time',
                        time: {
                            unit: 'month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            // min: -5,
                            // max: 60,
                            stepSize: 5
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Degrees Celsius'
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>