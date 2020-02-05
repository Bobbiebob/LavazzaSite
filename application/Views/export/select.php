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

        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5>Export data</h5>
                </div>

                <div class="card-body">

                    <p>Please select the data you would like to export and click the "Export" button.</p>

                    <form action="/exporter/download" method="post">
                        <div class="form-group row">
                            <label for="select" class="col-4 col-form-label">Station</label>
                            <div class="col-8">
                                <select id="select" name="station" class="custom-select">
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
                                <p class="muted">Select one specific station to export measurements of.</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="timespan" class="col-4 col-form-label">Timespan</label>
                            <div class="col-8">
                                <select id="timespan" name="timespan" class="custom-select">
                                    <?php foreach([50, 100, 150, 250, 500] as $amount): ?>
                                        <option value="<?=$amount;?>">Last <?=$amount;?> most recent measurements</option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="muted">Select the amount of measurements you like to export.</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-4 col-8">
                                <button name="submit" type="submit" class="btn btn-primary">Export</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>

</div>

<?php include __DIR__ . '/../partials/javascript.php'; ?>
</body>
</html>