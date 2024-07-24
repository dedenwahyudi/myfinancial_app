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
                    <h5 class="card-title" style="margin-bottom: 0;">Filter Data or <a href="<?= base_url('C_data_pengeluaran/history_data_pengeluaran'); ?>" class="text-danger" style="text-decoration: underline;">Reset Filter</a></h5>

                    <form action="<?= base_url('C_data_pengeluaran/history_data_pengeluaran'); ?>" method="post">
                        <div class="row">
                            <div class="col-md-3 col-12 mb-3">
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= isset($start_date) ? $start_date : '' ?>">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?= isset($end_date) ? $end_date : '' ?>">
                            </div>
                            <div class="col-md-6 col-12">
                                <button type="submit" class="btn btn-primary col-lg-4 col-md-5 col-12"><i class="ri-filter-2-fill"></i> Filter Data</button>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">No. </th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Bukti</th>
                                    <th class="text-center">Aksi</th>
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
                                                <a href="#" onclick="openBuktiHistoryDataPengeluaran(<?= $pengeluaran['id_pengeluaran']; ?>)">
                                                    <!-- Bukti -->
                                                    <span class="badge bg-info"><i class="ri-eye-line"></i></span>
                                                </a>
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openDetailHistoryDataPengeluaran(<?= $pengeluaran['id_pengeluaran']; ?>)">
                                                    <!-- Aksi Detail -->
                                                    <span class="badge bg-info"><i class="ri-eye-line"></i></span>
                                                </a>
                                            </h6>
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openEditHistoryDataPengeluaran(<?= $pengeluaran['id_pengeluaran']; ?>)">
                                                    <!-- Aksi Edit -->
                                                    <span class="badge bg-warning"><i class="ri-pencil-fill"></i></span>
                                                </a>
                                            </h6>
                                            <h6 class="d-inline">
                                                <a href="#" class="delete-btn-pengeluaran" onclick="confirmDeletePengeluaran(<?= $pengeluaran['id_pengeluaran']; ?>)">
                                                    <!-- Aksi Delete -->
                                                    <span class="badge bg-danger"><i class="ri-delete-bin-5-line"></i></span>
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
            <form action="#" method="post" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="jenis" class="form-label">Jenis</label>
                            <input type="text" class="form-control" id="jenis" placeholder="Jenis" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" placeholder="Rp. 0" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" placeholder="Keterangan" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="bukti" class="form-label">Bukti Foto / Kwitansi</label>
                            <input class="form-control" type="file" name="bukti" id="bukti" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="sisa_saldo" class="form-label">Sisa Saldo</label>
                            <input type="text" class="form-control" id="sisa_saldo" placeholder="Rp. 0" readonly>
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
<div class="modal fade" id="modal_detail_history_data_pengeluaran" tabindex="-1">
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
                    <div class="table-responsive">
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
                                    <td id="td_history_tanggal_pengeluaran">DD MM YYYYY</td>
                                    <td id="td_history_jenis_pengeluaran">-</td>
                                    <td id="td_history_jumlah_pengeluaran">Rp. 0</td>
                                    <td id="td_history_keterangan_pengeluaran">-</td>
                                    <td id="td_history_bukti_pengeluaran">-</td>
                                    <td id="td_history_status_pengeluaran">
                                        <h6 class="m-0"><span class="badge bg-secondary mt-1 mb-1" id="span_history_status_pengeluaran">Open</span></h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Detail Pengeluaran -->

<!-- Start Modal Edit Data Pengeluaran -->
<div class="modal fade" id="modal_edit_history_data_pengeluaran" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Edit Data Pengeluaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_pengeluaran/edit_data_pengeluaran'); ?>" method="post" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <input type="hidden" class="form-control mb-2" name="id_pengeluaran" id="id_pengeluaran" placeholder="ID Pengeluaran" readonly>
                        <div class="col-12">
                            <label for="edit_tanggal_history_pengeluaran" class="form-label">Edit Tanggal Pengeluaran</label>
                            <input type="date" class="form-control" name="edit_tanggal_history_pengeluaran" id="edit_tanggal_history_pengeluaran" max="<?= date('Y-m-d', strtotime('+0 days')); ?>" autocomplete="off" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="edit_jenis_history_pengeluaran" class="form-label">Edit Jenis Pengeluaran</label>
                            <input type="text" class="form-control" name="edit_jenis_history_pengeluaran" id="edit_jenis_history_pengeluaran" placeholder="Edit jenis" autocomplete="off" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mt-2">
                                <label for="edit_jumlah_history_pengeluaran1" class="form-label">Perubahan</label>
                                <input type="text" class="form-control" name="edit_jumlah_history_pengeluaran1" id="edit_jumlah_history_pengeluaran1" placeholder="Rp. 0" autocomplete="off">
                            </div>
                            <div class="col-6 mt-2">
                                <label for="edit_jumlah_history_pengeluaran2" class="form-label">Jumlah Saat Ini</label>
                                <input type="text" class="form-control" name="edit_jumlah_history_pengeluaran2" id="edit_jumlah_history_pengeluaran2" placeholder="Rp. 0" readonly>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="edit_keterangan_history_pengeluaran" class="form-label">Edit Keterangan Pengeluaran</label>
                            <input type="text" class="form-control" name="edit_keterangan_history_pengeluaran" id="edit_keterangan_history_pengeluaran" placeholder="Edit keterangan" autocomplete="off" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="edit_bukti_pengeluaran" class="form-label">Edit Bukti Foto / Kwitansi</label>
                            <div class="thumbnail-container mb-2">
                                <img id="current_image_history_pengeluaran" alt="Current Image" class="img-thumbnail">
                                <input type="hidden" class="form-control mt-2" name="foto_lama_history_pengeluaran" id="foto_lama_history_pengeluaran" placeholder="Foto lama">
                            </div>
                            <input class="form-control" type="file" name="edit_bukti_history_pengeluaran" id="edit_bukti_history_pengeluaran">
                        </div>
                        <div class="col-12 mt-2">
                            <label for="sisa_saldo" class="form-label">Sisa Saldo</label>
                            <input type="text" class="form-control" id="sisa_saldo" value="Rp. <?= number_format($sisa_saldo, 0, ',', '.'); ?>" placeholder="Rp. 0" readonly>
                        </div>
                        <div class="col-12 mt-2">
                            <input type="hidden" class="form-control" id="sisa_saldo_awal2" value="<?= $sisa_saldo; ?>" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Edit Data Pengeluaran -->

<!-- Start Modal Bukti History Pengeluaran -->
<div class="modal fade" id="modal_bukti_history_data_pengeluaran" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-file-list-3-line"></i> Bukti Pengeluaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="col-md-12">
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <img alt="Foto Bukti" id="detail_bukti_pengeluaran" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Bukti History Data Pengeluaran -->