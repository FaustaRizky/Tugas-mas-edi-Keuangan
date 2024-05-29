<?php
session_start();
require "function/functions.php";

// session dan cookie multilevel user
if (isset($_COOKIE['login'])) {
    if ($_COOKIE['level'] == 'user') {
        $_SESSION['login'] = true;
        $ambilNama = $_COOKIE['login'];
    } elseif ($_COOKIE['level'] == 'admin') {
        $_SESSION['login'] = true;
        header('Location: administrator');
    }
} elseif ($_SESSION['level'] == 'user') {
    $ambilNama = $_SESSION['user'];
} else {
    if ($_SESSION['level'] == 'admin') {
        header('Location: administrator');
        exit;
    }
}

if (empty($_SESSION['login'])) {
    header('Location: login');
    exit;
}

if (isset($_POST["submit"])) {
    if (tambahKeluar($_POST) > 0) {
        echo "
                <script>
                    alert('data berhasil ditambahkan!');
                    document.location.href = 'pengeluaran';
                </script>
                ";
    } else {
        echo "
                <script>
                    alert('data gagal ditambahkan!');
                </script>
                ";
    }
}

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="img/icon.png">
    <title>Dompet-Qu - Tambah Data</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styler.css?v=1.0">
    <link rel="stylesheet" href="css/tambah.css">
    <script src="js/jquery-3.3.1.min.js"></script>

    <style>
        .wide-input {
            width: 100%;
        }

        @media (max-width: 600px) {
            .wide-input {
                width: 100%;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
            vertical-align: top;
        }

        .form-control {
            width: 100%;
        }

        .btn-block {
            display: block;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="header" style="background-color: #9E9CFE;">
        <img src="img/icon.png" width="25px" height="25px" class="float-left logo-fav">
        <h3 class="text font-weight-bold float-left logo">Financial</h3>
        <!-- <h3 class="text-secondary font-weight-bold float-left logo">Financial</h3>
        <h3 class="text-secondary float-left logo2">- Manage</h3> -->

        <a href="logout">
            <div class="logout" style="color: black;">
                <i class="fas fa-sign-out-alt float-right log"></i>
                <p class="float-right logout" style=" font-family: 'Poppins';">Logout</p>
            </div>
        </a>
    </div>

    <div class="sidebar" style="background-color: #E8E8FF;">
        <nav>
            <ul>
                <!-- fungsi slide -->
                <script>
                    $(document).ready(function() {
                        $("#flip").click(function() {
                            $("#panel").slideToggle("medium");
                            $("#panel2").slideToggle("medium");
                        });
                        $("#flip2").click(function() {
                            $("#panel3").slideToggle("medium");
                            $("#panel4").slideToggle("medium");
                        });
                    });
                </script>

                <!-- dashboard -->
                <a href="dashboard" style="text-decoration: none;">
                    <li>
                        <div>
                            <span class="fas fa-tachometer-alt"></span>
                            <span>Dashboard</span>
                        </div>
                    </li>
                </a>

                <!-- Input -->
                <li class="klik2" id="flip2" style="cursor:pointer;">
                    <div>
                        <span class="fas fa-plus-circle"></span>
                        <span>Input Data</span>
                        <i class="fas fa-caret-up float-right" style="line-height: 20px;"></i>
                    </div>
                </li>

                <a href="tambahPemasukkan" class="linkAktif">
                    <li id="panel3">
                        <div style="margin-left: 20px;">
                            <span><i class="fas fa-file-invoice-dollar"></i></span>
                            <span>Pemasukkan</span>
                        </div>
                    </li>
                </a>

                <a href="tambahPengeluaran" class="linkAktif">
                    <li class="aktif" style="border-left: 5px solid #306bff;" id="panel4">
                        <div style="margin-left: 20px;">
                            <span><i class="fas fa-hand-holding-usd"></i></span>
                            <span>Pengeluaran</span>
                        </div>
                    </li>
                </a>
                <!-- Input -->

                <!-- data -->
                <li class="klik" id="flip" style="cursor:pointer;">
                    <div>
                        <span class="fas fa-database"></span>
                        <span>Data Harian</span>
                        <i class="fas fa-caret-right float-right" style="line-height: 20px;"></i>
                    </div>
                </li>

                <a href="pemasukkan" class="linkAktif">
                    <li id="panel" style="display: none;">
                        <div style="margin-left: 20px;">
                            <span><i class="fas fa-file-invoice-dollar"></i></span>
                            <span>Data Pemasukkan</span>
                        </div>
                    </li>
                </a>

                <a href="pengeluaran" class="linkAktif">
                    <li id="panel2" style="display: none;">
                        <div style="margin-left: 20px;">
                            <span><i class="fas fa-hand-holding-usd"></i></span>
                            <span>Data Pengeluaran</span>
                        </div>
                    </li>
                </a>
                <!-- dashboard -->


                <!-- laporan -->
                <a href="laporan" style="text-decoration: none;">
                    <li>
                        <div>
                            <span><i class="fas fa-clipboard-list"></i></span>
                            <span>Laporan</span>
                        </div>
                    </li>
                </a>

                <!-- change icon -->
                <script>
                    $(".klik").click(function() {
                        $(this).find('i').toggleClass('fa-caret-up fa-caret-right');
                        if ($(".klik").not(this).find("i").hasClass("fa-caret-right")) {
                            $(".klik").not(this).find("i").toggleClass('fa-caret-up fa-caret-right');
                        }
                    });
                    $(".klik2").click(function() {
                        $(this).find('i').toggleClass('fa-caret-up fa-caret-right');
                        if ($(".klik2").not(this).find("i").hasClass("fa-caret-right")) {
                            $(".klik2").not(this).find("i").toggleClass('fa-caret-up fa-caret-right');
                        }
                    });
                </script>
                <!-- change icon -->
            </ul>
        </nav>
    </div>

    <div class="main-content">
        <div class="konten">
            <div class="konten_dalem">
                <h2 class="head" style="color: #4b4f58;">Tambah Data Pengeluaran</h2>
                <hr style="margin-top: -5px;">
                <div class="headline" style="background-color: #B3B5FF;">
                    <h5 style="color: black;">Tambah Data Pengeluaran</h5>
                </div>
                <div style="margin-left: -10px;">
                    <div class="konten_isi">
                        <form class="form-text" action="" method="post">
                            <table class="table" style="width: 100%;">
                                <tr>
                                    <td class="label-column" style="width: 30%; line-height: 1.2;">Tanggal Pengeluaran</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;"><input class="form-control" type="date" value="<?= $today ?>" name="tanggal" required></td>
                                </tr>
                                <tr>
                                    <td class="label-column" style="width: 30%; line-height: 1.2;">Keterangan Pengeluaran</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;"><input class="form-control wide-input" type="text" name="keterangan" autocomplete="off" required></td>
                                </tr>
                                <tr>
                                    <td class="label-column" style="width: 30%; line-height: 1.2;">Keperluan Pengeluaran</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;">
                                        <select name="keperluan" class="form-control">
                                            <option>Makan dan Minum</option>
                                            <option>Hutang</option>
                                            <option>Peralatan</option>
                                            <option>Organisasi</option>
                                            <option>Kendaraan</option>
                                            <option>Keperluan pribadi</option>
                                            <option>Lain - lain</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column" style="width: 30%; line-height: 1.2;">Jumlah Pengeluaran</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 65%;"><input class="form-control" type="text" name="jumlah" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: center;">
                                        <input type="hidden" name="username" value="<?= $ambilNama ?>">
                                        <button class="btn btn-primary" type="submit" name="submit">Tambah Data</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <script src="js/bootstrap.min.js"></script>
</body>

</html>