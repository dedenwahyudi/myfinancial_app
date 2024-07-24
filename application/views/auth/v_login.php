<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login - MyFinancial</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?= base_url('assets/img/logo/fm.png'); ?>" rel="icon">
    <link href="<?= base_url('assets/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/boxicons/css/boxicons.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/quill/quill.snow.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/quill/quill.bubble.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/remixicon/remixicon.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/simple-datatables/style.css'); ?>" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-2">
                                        <h5 class="card-title text-center pb-0 fs-4 text-primary">
                                            <!-- <i class="ri-money-dollar-circle-line" style="font-size: 3em;"></i> -->
                                            <img src="<?= base_url('assets/img/logo/fm.png') ?>" alt="Logo" class="mb-2" style="width: 30%;">
                                            <br>myfinance<br>
                                            <span class="text-muted">Financial Management</span>
                                        </h5>
                                        <hr style="border: 1px dashed;">

                                        <?= $this->session->flashdata('message'); ?>
                                    </div>

                                    <form action="<?= base_url('C_auth/login'); ?>" method="post" class="row g-3 needs-validation" novalidate>
                                        <div class="col-12">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" id="username" placeholder="Username" autocomplete="off" required>
                                            <div class="invalid-feedback">Please enter your username!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="off" required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">
                                                <i class="bi bi-box-arrow-in-right"></i> Login
                                            </button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Tidak punya akun? <a href="#">Buat akun</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('assets/vendor/apexcharts/apexcharts.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/chart.js/chart.umd.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/echarts/echarts.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/quill/quill.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/simple-datatables/simple-datatables.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/tinymce/tinymce.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/php-email-form/validate.js'); ?>"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>

</body>

</html>