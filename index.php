<?php 
include 'admin/include/init.php';

$count = 0;
$error = '';
$user_firstname = $user_lastname = $user_password = $user_email = $wedding_date = '';

$account_details = new Account_Details();
$accounts = new Accounts();
$booking = new Booking();
$category = Category::find_all();
$blogEvent = EventWedding::getEventBlogs();

if (isset($_POST['register'])) {
    $user_firstname = clean($_POST['user_firstname']);
    $user_lastname = clean($_POST['user_lastname']);
    $user_email = clean($_POST['user_email']);
    $user_phone = clean($_POST['user_phone']);
    $wedding_date = clean($_POST['wedding_date']);

    $checkdate = $booking->check_wedding_date($wedding_date);
    if ($checkdate) {
        redirect_to("index.php");
        $session->message('<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><i class="mdi mdi-alert"></i></strong> The wedding you enter is already booked. Please Try another set of date!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
    }

    if (empty($user_firstname) ||
        empty($user_phone) ||
        empty($user_email) ||
        empty($user_lastname) ||
        empty($wedding_date)) {
        redirect_to("index.php");
        $session->message('<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><i class="mdi mdi-alert"></i></strong> Please Fill up all the fields.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
    }

    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
        redirect_to("index.php");
        $session->message('<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><i class="mdi mdi-alert"></i></strong> Incorrect email format.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
    }

    $check_email = $accounts->email_exists($user_email);
    if ($check_email) {
        redirect_to("index.php");
        $session->message('<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><i class="mdi mdi-alert"></i></strong> Email is already Exists.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
    } else {
        if ($error == '') {
            $count = $count + 1;
            $account_details->firstname = $user_firstname;
            $account_details->lastname = $user_lastname;
            $account_details->status = 'pending';
            $account_details->datetime_created = date("y-m-d h:m:i");
            $account_details->phone = $user_phone;
            if ($account_details->save()) {
                $account_details->user_id = mysqli_insert_id($db->connection);
                if ($account_details->update()) {
                    $accounts->user_id = $account_details->user_id;
                    $accounts->user_email = $user_email;
                    if ($accounts->save()) {
                        $booking->user_id = $accounts->user_id;
                        $booking->user_email = $user_email;
                        $booking->wedding_date = $wedding_date;
                        $booking->save();
                        redirect_to("user/thank_you.php");
                    }
                }
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wedding Planner</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .alert {
            font-size: 12px;
        }
        .error {
            background-color: #F2DEDE;
        }
        .alert.alert-danger.text-center {
            font-size: 16px;
        }
        .mdi.mdi-alert-circle.mr-3 {
            font-size: 16px;
        }
        .bgact {
            background: rgb(14 14 14 / 49%);
            padding: 15px;
        }
    </style>
</head>
<body>
<?php include 'user/include/nav.php'; ?>

<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="hero">
            <div class="row justify-content-md-center">
                <div class="col col-lg-3"></div>
                <div class="col col-lg-5" style="margin-top: 10%;">
                    <?php if ($session->message()) echo $session->message(); ?>
                    <form class="bgact" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h2 class="text-center hero-lead">Prebook Wedding Plan</h2>
                        <p class="lead text-center" style="color:white;">Silahkan mengisi form berikut</p>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="user_firstname" placeholder="Nama Depan" id="user_firstname">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" id="user_lastname" class="form-control" name="user_lastname" placeholder="Nama Belakang">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="user_email" id="user_email" placeholder="Masukan Email">
                        </div>
                        <div class="form-group">
                            <input type="text" aria-describedby="phoneHelpBlock" class="form-control" name="user_phone" id="user_phone" placeholder="Nomor Telepon">
                        </div>
                        <div class="form-row">
                            <div class="input-group col-md-5">
                                <input type="text" class="form-control" name="wedding_date" data-provide="datepicker" id="wedding_date"
                                       placeholder="Tanggal Pernikahan">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background: white;"><i
                                                style="font-size: 20px;color:#19b5bc;" class="mdi mdi-calendar-check"
                                                id="review" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" name="register" class="btn btn-danger btn-sm text-uppercase fb" style="margin-top: -5px;">Reservasi</button>
                        </div>
                    </form>
                </div>
                <div class="col col-lg-3"></div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid custom-container">
    <div class="row">
        <div class="col-lg-12">
            <hr>
            <h2 class="h2 text-uppercase text-center mb-4">Daftar Paket Pernikahan</h2>

            <div class="row">
                <?php foreach ($category as $category_row) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="admin/<?= $category_row->preview_image_picture(); ?>" class="card-img-top img-fluid" alt="" style="max-width: 100%; max-height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title text
                                class="card-title text-center text-uppercase"><?= $category_row->wedding_type; ?></h5>
                                <h6 class="card-subtitle mb-2 text-center text-muted">Fitur Paket</h6>
                                <ul class="list-group list-unstyled">
                                    <?php $feature = Features::find_by_feature_all($category_row->id); ?>
                                    <?php foreach ($feature as $feature_item) : ?>
                                        <li class="list-group-item"><?= $feature_item->title; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <p class="card-text text-center font-weight-bold">Price: Rp <?= number_format($category_row->price); ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <a href="user/package_detail.php?id=<?= $category_row->id; ?>" class="btn btn-custom btn-primary">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="h2 text-uppercase text-center mb-3">Testimoni Pelanggan</h2>
            <h6 class="h6 text-uppercase text-center text-muted mb-3">Bingung dengan paket pernikahan, berikut testimoninya</h6>

            <div class="row">
                <?php foreach($blogEvent as $blog_item) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img class="card-img-top img-fluid" src="admin/<?= $blog_item->preview_image_picture(); ?>" alt="Card image cap" style="max-height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <a href="wedding_details.php?id=<?= $blog_item->id; ?>" class="text-decoration-none">
                                    <h6 class="card-title text-center font-weight-bold text-uppercase"><?= $blog_item->title; ?></h6>
                                    <p class="card-text text-center text-muted"><?= $blog_item->wedding_type; ?> Wedding</p>
                                    <p class="card-text text-center text-muted"><i class="mdi mdi-map-marker"></i> <?= $blog_item->location; ?></p>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-4">
                <a href="user/testimoni.php" class="btn btn-custom btn-lg btn-block">Testimoni lain</a>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-custom {
        background-color: #19b5bc;
        color: white;
    }

    .btn-custom:hover {
        background-color: #17a2b8;
        color: white;
    }
</style>

<footer class="pt-3">
    <div class="row">
        <div class="col-12 col-md">
            <div class="text-center">
                <small class="d-block mb-3 text-muted">&copy; <?php echo date('Y')?> - Wedding JWP</small>
            </div>
        </div>
    </div>
</footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.2.1.slim.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/savy.js"></script>
<script>

    $(document).ready(function () {
        $('#wedding_date').datepicker();
        <?php
        if($count == 0) {
        ?>
        $('#user_firstname').savy('load');
        $('#user_lastname').savy('load');
        $('#user_email').savy('load');
        $('#user_phone').savy('load');
        $('#wedding_date').savy('load');
        <?php } else { ?>
        $('#user_firstname').savy('destroy');
        $('#user_email').savy('destroy');
        $('#user_lastname').savy('destroy');
        $('#user_phone').savy('destroy');
        $('#wedding_date').savy('destroy');
        <?php } ?>
    });
</script>
</body>
</html>
