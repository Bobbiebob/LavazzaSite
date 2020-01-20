<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css">

    <title>Lavazza Weather App</title>
</head>
<body>

    <div class="container mt-2">
        <div class="row justify-content-center align-items-center text-center p-2">
                <?php require __DIR__ . '/../partials/messages.php'; ?>
        </div>
        <div class="row justify-content-center align-items-center text-center p-2">
            <div class="m-1 col-sm-8 col-md-6 col-lg-4 shadow-sm p-3 mb-5 border rounded bg-white">
                <div class="pt-5">

                    <svg id="logo-lavazza-extended" viewBox="0 0 182 73" width="100%" height="100%"><path d="M22.6 64.3v6.4h-1.9v-6.4h-2.5v-1.7H25v1.7zM31.2 64.1c-1.3 0-2.2 1.1-2.2 2.5 0 1.5.9 2.5 2.2 2.5 1.3 0 2.2-1.1 2.2-2.5s-.9-2.5-2.2-2.5zm0 6.7c-2.5 0-4.1-1.8-4.1-4.2 0-2.4 1.7-4.2 4.2-4.2s4.1 1.8 4.1 4.2c0 2.4-1.7 4.2-4.2 4.2zM40.9 64.2c-.3 0-.5 0-.7.1v2.2h.6c.9 0 1.5-.4 1.5-1.3-.1-.6-.6-1-1.4-1zm1.7 6.5L41.2 68h-1v2.7h-1.9v-8.1c.7-.1 1.4-.1 2.4-.1 2.5 0 3.5 1.2 3.5 2.7 0 1-.5 1.8-1.4 2.4l1.9 3.1h-2.1zM47.2 70.7h1.9v-8.1h-1.9zM59.1 70.8l-4.9-4.4v4.3h-1.9v-8.3h.3l4.8 4.4v-4.2h1.9v8.2zM66.3 64.1c-1.3 0-2.2 1.1-2.2 2.5 0 1.5.9 2.5 2.2 2.5 1.3 0 2.2-1.1 2.2-2.5s-.9-2.5-2.2-2.5m0 6.7c-2.5 0-4.1-1.8-4.1-4.2 0-2.4 1.7-4.2 4.2-4.2s4.1 1.8 4.1 4.2c0 2.4-1.7 4.2-4.2 4.2M73 72.2l-.2-.2c.5-.4.7-.7.8-1.2-.5 0-.9-.4-.9-.9s.4-.8.8-.8c.6 0 .9.5.9 1.1.1.7-.6 1.7-1.4 2M79.1 70.7H81v-8.1h-1.9zM87.8 64.3v6.4h-1.9v-6.4h-2.5v-1.7h6.8v1.7zM94.9 65.8l-.8 2h1.6l-.8-2zm2 4.9l-.6-1.5h-2.8l-.6 1.5H91l3.8-8.2h.2l3.8 8.2h-1.9zM101.1 70.7v-8.1h1.9V69h3.3v1.7zM108.7 70.7h1.9v-8.1h-1.9zM116.9 65.8l-.8 2h1.6l-.8-2zm2 4.9l-.6-1.5h-2.8l-.6 1.5H113l3.8-8.2h.3l3.8 8.2h-2zM123.4 72.2l-.2-.2c.5-.4.7-.7.8-1.2-.5 0-.9-.4-.9-.9s.4-.8.8-.8c.6 0 .9.5.9 1.1.1.7-.6 1.7-1.4 2M129.9 70.7v-6.2l-1.4.5-.5-1.4 3.1-1.2h.7v8.3zM137.6 64.1c-.6 0-1 .4-1 1s.4.9 1 .9c.5 0 .9-.3.9-.9 0-.6-.3-1-.9-1m0 3.2c-.6 0-1 .4-1 .9s.4 1 1 1 1-.4 1-1-.4-.9-1-.9m0 3.5c-1.8 0-3-1-3-2.3 0-.8.4-1.6 1.3-2-.7-.4-1.1-1.1-1.1-1.9 0-1.3 1.1-2.3 2.8-2.3 1.7 0 2.8 1 2.8 2.3 0 .8-.5 1.6-1.1 1.9 1 .4 1.4 1.1 1.4 2-.1 1.3-1.3 2.3-3.1 2.3M146 66.6c.7 0 1.1-.6 1.1-1.3 0-.7-.5-1.3-1.1-1.3-.7 0-1.2.6-1.2 1.3 0 .7.5 1.3 1.2 1.3m0-4.2c1.9 0 3.1 1.4 3.1 3.1 0 3-2.2 4.4-4.8 5.5l-.8-1.5c1.2-.4 2.5-1.1 3.3-2-.4.2-.8.3-1.3.3-1.5 0-2.5-1.1-2.5-2.6-.1-1.3 1-2.8 3-2.8M153.5 70.8c-.7 0-1.5-.1-2.2-.4l.3-1.6c.5.2 1.1.3 1.7.3 1.1 0 1.7-.4 1.7-1.1 0-.6-.5-1.2-1.7-1.2-.4 0-1.2.1-1.6.2l-.1-.1v-4.5h5.1v1.7h-3.2v1.3h.7c1.9 0 2.8 1.1 2.8 2.5.1 1.7-1.2 2.9-3.5 2.9M35.9 21.8v11.6h-3l3-11.6zM20.3 46.3h9.9l1.1-4.7h4.6v4.7h9.9V13.9H27.5l-7.2 32.4zM18.4 13.9H7.3L0 46.3h18l2.2-9.9h-6.8zM64.8 13.9l-5.1 23v-23H49.6v32.4h18.2L75 13.9zM165.9 33.3V21.7l3 11.6h-3zm8.4-19.4H156v32.4h9.9v-4.7h4.6l1.1 4.7h9.8l-7.1-32.4zM146.9 36.7l2.4-22.8h-20.7l1.8 10.4h6.8l-2 22H155l-2-9.6zM124.4 36.7l2.4-22.8H106l1.9 10.4h6.8l-2.1 22h19.9l-2-9.6zM87.4 28.4l3.3-17.7 3.4 17.7h-6.7zM81.9.3l-10.4 46h12.8l1.5-7.9h10l1.5 7.9H110L99.7.3H81.9z"></path></svg>

                    <p class="text-center text-uppercase mt-3">Benvenuto! Accedere prego.</p>
                    <form class="form text-center" action="/" method="POST">
                        <div class="form-group input-group-md">
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                            <!--<div class="invalid-feedback">
                                 Errors in email during form validation, also add .is-invalid class to the input fields
                            </div> -->
                        </div>
                        <div class="form-group input-group-md">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <button class="btn btn-lg btn-block btn-primary mt-4" type="submit">
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>