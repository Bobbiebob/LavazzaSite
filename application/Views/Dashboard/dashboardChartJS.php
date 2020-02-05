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
                        <option value="<?=$station['stn'];?>"><?=$station['country'];?>, <?=$station['name'];?>, #<?=$station['stn'];?></option>
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
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Rainfall</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="rainfallChart" width="100%" height="40%"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Snowfall</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="snowfallChart" width="100%" height="40%"></canvas>
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
            getData();
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
                rawData = JSON.parse(data).data;
                data = []
                $.each(rawData, function (key, value) {
                    data.push({
                        x: new Date(value.x*1000),
                        y: value.y
                    });
                });
                window.visibilityChart.data.datasets[0].data = data;
                window.visibilityChart.update();
            });

            $.get("/api/graph/" + stationId + "/snowfall", function(data) {
                rawData = JSON.parse(data).data;
                data = []
                $.each(rawData, function (key, value) {
                    data.push({
                        x: new Date(value.x*1000),
                        y: value.y
                    });
                });
                window.snowfallChart.data.datasets[0].data = data;
                window.snowfallChart.update();
            });

            $.get("/api/graph/" + stationId + "/rainfall", function(data) {
                rawData = JSON.parse(data).data;
                data = []
                $.each(rawData, function (key, value) {
                    data.push({
                        x: new Date(value.x*1000),
                        y: value.y
                    });
                });
                window.rainfallChart.data.datasets[0].data = data;
                window.rainfallChart.update();
            });

        }

        getData();
        setInterval(getData, 10000);

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
                            min: -55,
                            max: 55,
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
                    label: 'Visibility in km',
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
                            min: -0,
                            max: 100,
                            stepSize: 10
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Kilometers'
                        }
                    }]
                }
            }
        });

        window.rainfallChart = new Chart(document.getElementById('rainfallChart'),{
            type: 'line',
            data: {
                datasets: [{
                    label: 'Rainfall in millimeters',
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
                            min: 0,
                            max: 20,
                            stepSize: 2
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Millimeters'
                        }
                    }]
                }
            }
        });

        window.snowfallChart = new Chart(document.getElementById('snowfallChart'),{
            type: 'line',
            data: {
                datasets: [{
                    label: 'Snowfall in millimeters',
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
                            min: 0,
                            max: 20,
                            stepSize: 2
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Millimeters'
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>