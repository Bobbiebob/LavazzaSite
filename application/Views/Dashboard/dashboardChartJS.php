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

    <?php require __DIR__ . '/../partials/styles.php'; ?>

</head>
<body>
    <?php require __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Temperature</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" width="100%" height="40%"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Todo</h5>
                    </div>
                    <div class="card-body">
                        <p>Think of something great to do here...</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Overview of all stations in Europe</h5>
                    </div>

                    <div class="card-body">
                        <p><strong>Filters</strong></p>
                            <div class="form-group">
                                <label for="query">Search</label>
                                <input name="query" type="text" class="form-control" id="query" aria-describedby="query">
                                <small class="form-text text-muted">Any column containing (part of) this value, will be shown.</small>
                            </div>
                        <p>Turn on/off the visibility of certain data</p>
                            <form class="form-inline">
                            <?php foreach([
                                                'Location',
                                                'Air Pressure station level',
                                                'Air Pressure sea level',
                                                'Dew Point',
                                                'Temperature',
                                                'Visibility',
                                                'Wind Speed',
                                                'Rainfall',
                                                'Snowfall'
                                          ] as $key => $column): ?>
                            <?php if($key == 0)
                                continue;
                            ?>
                                <div class="form-check mb-2 mr-sm-2">
                                    <input class="form-check-input form-check-inline toggle-column" checked type="checkbox" value="" data-column-id="<?=$key;?>" id="column-visibility-<?=$key;?>">
                                    <label class="form-check-label" for="column-visibility-<?=$key;?>">
                                        <?=$column;?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            </form>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatables" id="stations">
                                <thead>
                                <tr>
                                    <th scope="col">Location </th>
                                    <th scope="col">Air Pressure station level</th>
                                    <th scope="col">Air Pressure sea level</th>
                                    <th scope="col">Dew Point</th>
                                    <th scope="col">Temperature</th>
                                    <th scope="col">Visibility</th>
                                    <th scope="col">Windspeed</th>
                                    <th scope="col">Rainfall</th>
                                    <th scope="col">Snowfall</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr />
        <div class="row">
            <div class="col-12">
                <p class="float-left">Version 1.0</p>
                <p class="float-right">Made with <span style="color: red";>&hearts;</span> by SunInHome B.V.</p>
            </div>
        </div>

    </div>

    <?php include __DIR__ . '/../partials/javascript.php'; ?>

<script src="/assets/chart/Chart.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready( function () {

            var table = $('.datatables#stations').DataTable({
                "ajax": '/api/all_current_data'
            });

            $("#query").on("change paste keyup", function(e) {
                e.preventDefault();
                var value = $(this).val();
                table.search(value).draw();
            });

            // Toggle columns
            $('.toggle-column').change(function (e) {
                e.preventDefault();

                var column = table.column( $(this).attr('data-column-id') );
                // column.visible( ! column.visible() );
                column.visible($(this).is(':checked'));
            } );
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
                    borderColor: "#B53471",
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