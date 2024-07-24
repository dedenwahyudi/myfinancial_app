<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('C_dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active"><?= $title; ?></li>
        </ol>
    </nav>
</div>

<?php
$threshold = 0.1 * $limit_budget;

if ($saldo_utama == 0.0) {
?>
    <div class="alert alert-danger alert-dismissible fade show" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);" role="alert">
        Saldo kamu habis Rp. 0,-
    </div>
<?php
} else if ($saldo_utama <= $threshold) {
?>
    <div class="alert alert-danger alert-dismissible fade show" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);" role="alert">
        Pengeluaran mendekati budget maksimal bulan ini. Kelola keuangan dengan baik.
    </div>
<?php
}
?>

<?php if (empty($limit_budget)) { ?>
    <div class="alert alert-warning alert-dismissible fade show" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);" role="alert">
        Belum ada Budget Pengeluaran bulan ini. Buat <a href="<?= base_url('C_data_pengeluaran/budget_pengeluaran'); ?>" class="nav-link-ajax">Budget Pengeluaran</a>.
    </div>
<?php } else { ?>
    <div class="alert alert-info alert-dismissible fade show" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);" role="alert">
        Budget pengeluaran kamu bulan ini sebesar <span class="text-danger" style="font-weight: bold;">Rp. <?= number_format($limit_budget, 0, ',', '.'); ?>,-</span>
    </div>
<?php } ?>

<?= $this->session->flashdata('message'); ?>

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-12" style="padding-top: 12px;">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Saldo Utama</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 style="font-size: 2em;">Rp. <?= number_format($saldo_utama, 0, ',', '.'); ?>,-</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Pemasukan</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ri-arrow-down-line"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>Rp. <?= number_format($data_pemasukan, 0, ',', '.'); ?>,-</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Pengeluaran</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ri-arrow-up-line"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>Rp. <?= number_format($data_pengeluaran, 0, ',', '.'); ?>,-</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">History Aktivitas</h5>

                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">No</th>
                                            <th class="text-center" scope="col">Menu</th>
                                            <th class="text-center" scope="col">Keterangan</th>
                                            <th class="text-center" scope="col">User</th>
                                            <th class="text-center" scope="col">Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        foreach ($data_action_log as $log) {
                                            $no++;
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no; ?></td>
                                                <td><?= $log['menu']; ?></td>
                                                <td><?= $log['keterangan']; ?></td>
                                                <td><?= $log['firstname'] . ' ' . $log['lastname']; ?></td>
                                                <td><?= $log['timestamp']; ?></td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div><!-- End Recent Sales -->
            </div>
        </div><!-- End Left side columns -->
    </div>
</section>