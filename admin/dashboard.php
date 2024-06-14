<?php include 'include/init.php'; ?>
<?php
     if (!isset($_SESSION['id'])) {
         redirect_to("../");
     }

    $user_count =  Account_Details::count_user();
    $booking_count =  Booking::count_booking();
    $event_post =  EventWedding::count_all();
?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
<!--    <link href="css/bootstrap.css" rel="stylesheet">-->
    <link rel="stylesheet" type="text/css"
          href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <style>
        table.table.table-striped.table-bordered.table-sm {
            font-size:12px;
        }
        .tooltip {
            font-size: 12px;
        }

        td.special {
            padding: 0;
            padding-top: 8px;
            padding-left:6px;
            padding-bottom:6px;
            margin-top:5px;
            text-transform: capitalize;
        }
        .datepicker {
            font-size: 12px;
        }
        .alert-success {
            color: #fff;
            background-color: #49C8AE;
            border-color: none;
        }
        div.dataTables_wrapper div.dataTables_paginate {
            font-size: 11px;
        }

        .card-counter{
    box-shadow: 2px 2px 10px #DADADA;
    margin: 5px;
    padding: 0px 9px;
    background-color: #fff;
    height: 100px;
    border-radius: 5px;
    transition: .3s linear all;
  }

  .card-counter:hover{
    box-shadow: 4px 4px 20px #DADADA;
    transition: .3s linear all;
  }

  .card-counter.primary{
    background-color: #007bff;
    color: #FFF;
  }

  .card-counter.danger{
    background-color: #ef5350;
    color: #FFF;
  }  

  .card-counter.success{
    background-color: #66bb6a;
    color: #FFF;
  }  

  .card-counter.info{
    background-color: #26c6da;
    color: #FFF;
  }  

  .card-counter i{
    font-size: 5em;
    opacity: 0.9;
  }

  .card-counter .count-numbers{
    position: absolute;
    right: 35px;
    top: 20px;
    font-size: 32px;
    display: block;
  }

  .card-counter .count-name{
    position: absolute;
    right: 35px;
    top: 65px;
    text-transform: capitalize;
    opacity: 0.8;
    display: block;
    font-size: 16px;
  }

    </style>
</head>

<body>

<?php include_once 'include/sidebar.php'; ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="h4 mt-4">Halo, <?= ucfirst($users_profile->firstname) . ' ' . ucfirst($users_profile->lastname); ?></h4>
</div>

    <div class="row">
    <div class="col-lg-3">
      <div class="card-counter primary">
        <i class="mdi mdi-account-multiple"></i>
        <span class="count-numbers"><?=  $user_count; ?></span>
        <span class="count-name">Total Client</span>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="card-counter success">
        <i class="mdi mdi-book-open-page-variant"></i>
        <span class="count-numbers"><?=  $booking_count; ?></span>
        <span class="count-name">Total Pesanan</span>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="card-counter info">
        <i class="mdi mdi-comment-text"></i>
        <span class="count-numbers"><?=  $event_post; ?></span>
        <span class="count-name">Testimoni</span>
      </div>
    </div>
  </div>




<?php include_once 'include/footer.php';?>