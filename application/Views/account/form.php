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
            <?php require __DIR__ . '/../partials/messages.php'; ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5>User settings</h5>
                </div>

                <div class="card-body">
                    <form method="post" action="/account/save">
                        <div class="form-group row">
                            <label for="first_name" class="col-4 col-form-label">First name</label>
                            <div class="col-8">
                                <input id="first_name" name="first_name" autofocus placeholder="First name" type="text" class="form-control" required="required" value="<?=htmlspecialchars($user['first_name']);?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-4 col-form-label">Last name</label>
                            <div class="col-8">
                                <input id="last_name" name="last_name" placeholder="Last name" type="text" class="form-control" required="required" value="<?=htmlspecialchars($user['last_name']);?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-4 col-form-label">E-mail address</label>
                            <div class="col-8">
                                <input id="email" name="email" placeholder="E-mail address" type="text" class="form-control" required="required" value="<?=htmlspecialchars($user['email']);?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="preferred_view" class="col-4 col-form-label">Role</label>
                            <div class="col-8">
                                <select id="preferred_view" name="preferred_view" class="custom-select" required="required" aria-describedby="preferred_viewHelpBlock">
                                    <option value="colombia" <?=($user['preferred_view'] == 'colombia' ? 'selected' : '');?>>I am a farmer</option>
                                    <option value="europe" <?=($user['preferred_view'] == 'europe' ? 'selected' : '');?>>I am a truck driver</option>
                                </select>
                                <span id="preferred_viewHelpBlock" class="form-text text-muted">Your role determines which view will open first. You can still switch using the links above.</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-4 col-8">
                                <button name="submit" type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br />

    <div class="row">

        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5>Change your password</h5>
                </div>

                <div class="card-body">
                    <form method="post" action="/account/password">
                        <div class="form-group row">
                            <label for="current_password" class="col-4 col-form-label">Current password</label>
                            <div class="col-8">
                                <input id="current_password" name="current_password" placeholder="Current password" type="password" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_password" class="col-4 col-form-label">New password</label>
                            <div class="col-8">
                                <input id="new_password" name="new_password" placeholder="New password" type="password" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_password2" class="col-4 col-form-label">Repeat new password</label>
                            <div class="col-8">
                                <input id="new_password2" name="new_password2" placeholder="Repeat new password" type="password" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-4 col-8">
                                <button name="submit" type="submit" class="btn btn-primary">Save</button>
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