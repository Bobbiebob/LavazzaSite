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
            <div class="col-md-3 offset-md-9">
                <div class="form-group">
                    <select id="station">
                        <option selected disabled>---- Select station ----</option>
                        <?php
                            $db = new \Application\Helpers\DB();
                            $query = $db->select()
                            ->table('stations')
                            ->run();
                            $stations = $query->fetchAll();
                            foreach($stations as $station):
                        ?>
                        <option value="<?=$station['stn'];?>"><?=$station['country'];?>, <?=$station['name'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Temperature</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="tempChart" width="100%" height="40%"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Visibility</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="visibilityChart" width="100%" height="40%"></canvas>
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

        <?php include __DIR__ . '/../partials/footer.php'; ?>


    </div>

    <?php include __DIR__ . '/../partials/javascript.php'; ?>

<script src="/assets/chart/Chart.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sifter/0.6.0/sifter.min.js" integrity="sha256-OPRG6xXnYZSE3aI8usa7auAG9o9zHxiF3Cqy2iT5Itc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/microplugin/0.0.3/microplugin.min.js" integrity="sha256-9UZrVQrjiOOmlikpy2EDDytjXQBC/f/iC9yG6dqCCR4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js" integrity="sha256-zwkv+PhVN/CSaFNLrcQ/1vQd3vviSPiOEDvu2GxYxQc=" crossorigin="anonymous"></script>

    <script>
        $(document).ready( function () {

            $('#station').selectize({
                create: false,
                sortField: 'text',
                onDropdownOpen: function () {
                    this.clear();
                }
                // persist: false
            });

            $("#station").on("click", function () {
                console.log("CLEAR");
                var selectize = $select[0].selectize;
                selectize.clear();

            });

            var table = $('.datatables#stations').DataTable({
                "ajax": '/api/all_current_data'
            });

            // TODO: look into reloading without DT re-sorting
            // setInterval(function () {
            //     table.ajax.reload();
            // }, 10000);

            $("#query").on("change paste keyup", function(e) {
                e.preventDefault();
                var value = $(this).val();
                table.search(value).draw(false);
            });

            // Toggle columns
            $('.toggle-column').change(function (e) {
                e.preventDefault();

                var column = table.column( $(this).attr('data-column-id') );
                // column.visible( ! column.visible() );
                column.visible($(this).is(':checked'));
            } );
        } );

        var stationId = null;

        $('#station').change(function() {
            stationId = $(this).val();
        });

        function getData() {
            if(stationId == null) {
                return;
            }
            $.get("/api/graph/" + stationId + "/temperature", function(data) {
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

                window.tempChart.data.datasets[0].data = data;

                window.tempChart.update();

            });

            $.get("/api/graph/" + stationId + "/visibility", function(data) {
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

                window.visibilityChart.data.datasets[0].data = data;

                window.visibilityChart.update();

            });

        }

        getData();
        setInterval(getData, 1000);



        var ctx = document.getElementById('tempChart');
        var ctv = document.getElementById('visibilityChart');

        window.tempChart = new Chart(ctx,{
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
                            displayFormats: {
                                'millisecond': 'H:mm',
                                'second': 'H:mm',
                                'minute': 'H:mm',
                                'hour': 'H:mm',
                                'day': 'H:mm',
                                'week': 'H:mm',
                                'month': 'H:mm',
                                'quarter': 'H:mm',
                                'year': 'H:mm',
                            }
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            min: -5,
                            max: 30,
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

        window.visibilityChart = new Chart(ctv,{
            type: 'line',
            data: {
                datasets: [{
                    label: 'Visibility in meters',
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
                            displayFormats: {
                                'millisecond': 'H:mm',
                                'second': 'H:mm',
                                'minute': 'H:mm',
                                'hour': 'H:mm',
                                'day': 'H:mm',
                                'week': 'H:mm',
                                'month': 'H:mm',
                                'quarter': 'H:mm',
                                'year': 'H:mm',
                            }
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            min: -5,
                            max: 30,
                            stepSize: 5
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Meters'
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>