<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Pengeluaran</li>
            <li class="breadcrumb-item active"><?= $title; ?></li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">

        <div class="col-xl-4 col-lg-4 col-xs-12 col-sm-12 mb-3">
            <button class="btn btn-primary col-12" data-bs-toggle="modal" data-bs-target="#modal_input_data_pengeluaran">
                <i class="ri-pencil-fill"></i> Input Data Pengeluaran
            </button>
        </div>

        <div class="col-lg-12">
            <?php if (empty($current_budget)) { ?>
                <div class="alert alert-warning alert-dismissible fade show" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);" role="alert">
                    Kamu belum menentukan budget pengeluaran bulan ini.
                    Silahkan buat <a href="<?= base_url('C_data_pengeluaran/budget_pengeluaran'); ?>">Budget Pengeluaran</a>.
                </div>
            <?php } else { ?>
                <div class="alert alert-info alert-dismissible fade show" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);" role="alert">
                    Budget pengeluaran kamu bulan ini sebesar <span class="text-danger" style="font-weight: bold;">Rp. <?= number_format($current_budget); ?>,-</span>
                </div>
            <?php } ?>

            <?= $this->session->flashdata('message'); ?>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List Data Pengeluaran</h5>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">No. </th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $months = array(
                                    'January' => 'Januari',
                                    'February' => 'Februari',
                                    'March' => 'Maret',
                                    'April' => 'April',
                                    'May' => 'Mei',
                                    'June' => 'Juni',
                                    'July' => 'Juli',
                                    'August' => 'Agustus',
                                    'September' => 'September',
                                    'October' => 'Oktober',
                                    'November' => 'November',
                                    'December' => 'Desember'
                                );
                                ?>
                                <?php
                                $no = 0;
                                foreach ($data_pengeluaran as $pengeluaran) {
                                    $no++;

                                    $date = new DateTime($pengeluaran['tanggal']);
                                    $formatted_date = $date->format('d F Y');
                                    $formatted_date = str_replace(array_keys($months), array_values($months), $formatted_date);
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <td class="text-center"><?= $formatted_date; ?></td>
                                        <td class="text-center"><?= $pengeluaran['jenis']; ?></td>
                                        <td class="text-center">Rp. <?= number_format($pengeluaran['jumlah'], 0, ',', '.'); ?>,-</td>
                                        <td class="text-center">
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openDetailDataPengeluaran(<?= $pengeluaran['id_pengeluaran']; ?>)">
                                                    <!-- Aksi Detail -->
                                                    <span class="badge bg-info"><i class="ri-eye-line"></i></span>
                                                </a>
                                            </h6>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Start Modal Input Data Pengeluaran -->
<div class="modal fade" id="modal_input_data_pengeluaran" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Input Data Pengeluaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_pengeluaran/input_data_pengeluaran'); ?>" method="post" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="kode_budget" class="form-label">Kode Budget</label>
                            <select class="form-select" name="kode_budget" id="kode_budget" required>
                                <option value="">Pilih Kode Budget</option>
                                <?php foreach ($data_budget as $dt_budget) { ?>
                                    <option value="<?= $dt_budget['kode_budget']; ?>"><?= $dt_budget['kode_budget']; ?>/<?= strtoupper($dt_budget['bulan']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="tanggal_pengeluaran" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal_pengeluaran" id="tanggal_pengeluaran" max="<?= date('Y-m-d', strtotime('+1 days')); ?>" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="jenis_pengeluaran" class="form-label">Jenis</label>
                            <input type="text" class="form-control" name="jenis_pengeluaran" id="jenis_pengeluaran" placeholder="Jenis pengeluaran" autocomplete="off" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="jumlah_pengeluaran" class="form-label">Jumlah</label>
                            <input type="text" class="form-control" name="jumlah_pengeluaran" id="jumlah_pengeluaran" placeholder="Rp. 0" autocomplete="off" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="keterangan_pengeluaran" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan_pengeluaran" id="keterangan_pengeluaran" placeholder="Keterangan pengeluaran" autocomplete="off" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="bukti_pengeluaran" class="form-label">Bukti Foto / Kwitansi</label>
                            <input class="form-control" type="file" name="bukti_pengeluaran" id="bukti_pengeluaran" required>
                        </div>
                        <div class="col-12 mt-2">
                            <input class="form-check-input" type="checkbox" name="tanpa_bukti" id="tanpa_bukti" value="Tanpa lampiran bukti">
                            <label class="form-check-label" for="tanpa_bukti">
                                Tanpa lampiran
                            </label>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="sisa_saldo" class="form-label">Sisa Saldo</label>
                            <input type="text" class="form-control" name="sisa_saldo" id="sisa_saldo" value="Rp. <?= number_format($sisa_saldo, 0, ',', '.'); ?>" placeholder="Rp. 0" readonly>
                        </div>
                        <div class="col-12 mt-2">
                            <input type="hidden" id="sisa_saldo_awal1" value="<?= $sisa_saldo; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Input Data Pengeluaran -->

<!-- Start Modal Detail Pengeluaran -->
<div class="modal fade" id="modal_detail_data_pengeluaran" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-file-list-3-line"></i> Detail Data Pengeluaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="col-md-12">
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Bukti</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td id="td_tanggal_pengeluaran">DD MM YYYYY</td>
                                <td id="td_jenis_pengeluaran">-</td>
                                <td id="td_jumlah_pengeluaran">Rp. 0</td>
                                <td id="td_keterangan_pengeluaran">-</td>
                                <td id="td_bukti_pengeluaran">-</td>
                                <td id="td_status_pengeluaran">
                                    <h6 class="m-0"><span class="badge bg-secondary mt-1 mb-1" id="span_status_pengeluaran">Open</span></h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Detail Pengeluaran -->