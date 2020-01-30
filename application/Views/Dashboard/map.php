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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>

</head>
<body>
<?php require __DIR__ . '/../partials/navbar.php'; ?>

<div class="container-fluid p-5">
    <div class="row">

        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5>Visualisation on the map of Europe</h5>
                </div>

                <div class="card-body">
                    <div id="map-container">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>

</div>
<?php include __DIR__ . '/../partials/javascript.php'; ?>
<!-- Leaflet map render -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js" integrity="sha256-fNoRrwkP2GuYPbNSJmMJOCyfRB2DhPQe0rGTgzRsyso=" crossorigin="anonymous"></script>
<script type="text/javascript">

    $(function() {

        var map = L.map('map').setView([48.987411, 13.752742], 5);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoicmlja2Jha2tlciIsImEiOiJjamUydTRrOWoyMG9uMnFqcjh2dm02MmVlIn0.vG--PO0h2zt0BEUV1VhR4Q', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery &copy; <a href="http://mapbox.com">Mapbox</a>',
            id: 'mapbox.streets'
        }).addTo(map);

        <?php foreach($stations as $station):
        $longitude = $station['longitude'];
        $latitude = $station['latitude']; ?>
        L.marker([<?=$latitude;?>, <?=$longitude;?>])
         .addTo(map)
         .bindPopup("<?=$station['name'];?>, <?=$station['country'];?><br />#<?=$station['stn'];?>");
        <?php endforeach; ?>

    });

</script>
</body>
</html>