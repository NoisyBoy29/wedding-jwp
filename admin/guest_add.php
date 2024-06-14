<?php include 'include/init.php'; ?>
<?php

    $booking_id = $_GET['booking_id'];
    $user_id = $_GET['user_id'];
    $links='booking_id='.$booking_id.'&user_id='.$user_id;

    if (!isset($_SESSION['id'])) { redirect_to("../"); }

    $booking_id = $_GET['booking_id'];
    $user_id = $_GET['user_id'];

    $guest = new Guest();

    if (isset($_POST['submit'])) {

        $fullname = clean($_POST['fullname']);
        $guestname = clean($_POST['guestname']);
        $address = clean($_POST['address']);
        $city = clean($_POST['city']);
        $state = clean($_POST['state']);
        $zipcode = clean($_POST['zipcode']);
        $priority = clean($_POST['priority']);
        $out_of_town = clean($_POST['out_of_town']);
        $relationship = clean($_POST['relationship']);
        $messages = clean($_POST['messages']);

         if (empty($fullname) || empty($guestname) || empty($address) || empty($city) || empty($state) || empty($zipcode) || empty($priority) || empty($out_of_town) || empty($relationship)) {
            redirect_to("guest_add.php?$links");
            $session->message("
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-account-alert'></i></strong> Please Fill up all the information.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        $guest->booking_id = $booking_id;
        $guest->fullname = $fullname;
        $guest->address = $address;
        $guest->city = $city;
        $guest->priority = $priority;
        $guest->relationship = $relationship;
        $guest->message = $messages;
        $guest->save();
        redirect_to("guest_list.php?$links");
        $session->message("
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-check'></i></strong> {$guest->fullname} is successfully added.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
    }


?>
<?php $users_profile = Users::find_by_id($_SESSION['id']); ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Tambah Daftar Tamu</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.materialdesignicons.com/2.1.19/css/materialdesignicons.min.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
        <style>
            body {
                margin-bottom: 2%;
            }
            .box-shadow {
                box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.3);
                font-size: 12px;
            }
            .form-control {
                font-size: 12px;
            }
            .datepicker {
                font-size: 12px;
            }
        </style>
    </head>

<body>

<?php include_once 'include/sidebar.php'; ?>

    <div class="container">

        <div class="row">

            <div class="col-lg-8 offset-2 pl-3 pb-3 box-shadow mt-4">
            
                <form method="post" action="">

                    <h4 class="h4 mt-4 pb-2" style="border-bottom: 1px solid #dee2e6!important;">Tambah Daftar Tamu
                        <a href="guest_list.php?<?= $links;?>" class="btn btn-sm btn-danger float-right" style="font-size: 12px;"><i class="mdi mdi-close-circle mr-2"></i> Batal</a>

                        <button type="submit" name="submit" class="btn btn-sm btn-success float-right mr-2" style="font-size: 12px;"><i class="mdi mdi-account-plus mr-2"></i> Simpan</button>
                    </h4>

                    <?php
                        if ($session->message()) {
                            echo ' <div class="form-group col-md-12">' . $session->message() . '</div>';
                        }
                    ?>

                    <div class="form-group">
                        <label for="inputfullname">Nama Lengkap</label>
                        <input type="text" name="fullname" class="form-control" id="inputfullname"  placeholder="Enter fullname">
                       
                    </div>

                     <div class="form-group">
                            <label for="relationship">Hubungan dari</label>
                            <select name="relationship" class="form-control" id="relationship">
                                <option value="b">Pengantin Wanita</option>
                                <option value="g">Pengantin Pria</option>
                            </select>
                        </div>

                    <div class="form-group">
                        <label for="inputAddress">Alamat</label>
                        <textarea rows="5" name="address" class="form-control" id="inputAddress"  placeholder="Enter address"></textarea>
                    </div>

                    <div class="form-row">
                         <div class="form-group col-md-6">
                            <label for="inputPriority">Tamu Prioritas</label>
                            <select name="priority" id="inputPriority" class="form-control">
                                <option value="A">A (Keluarga)</option>
                                <option value="B">B (Sahabat)</option>
                                <option value="C">C (Rekan kerja)</option>
                                <option value="D">D (Teman)</option>
                                <option value="E">E (-)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputstate">Kota</label>
                            <input type="text" name="city" class="form-control" id="inputstate" placeholder="Enter state">
                        </div>
                     
                    </div>

                    <div class="form-group">
                        <label for="inputmessage">Message</label>
                        <textarea rows="5" name="messages" class="form-control" id="inputmessage"  placeholder="Masukan pesan untuk pengantin"></textarea>
                    </div>

                </form>
            </div>
        </div>
    </div>



<?php include_once 'include/footer.php';?>
