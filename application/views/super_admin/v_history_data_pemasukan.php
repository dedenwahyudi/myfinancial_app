<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Pemasukan</li>
            <li class="breadcrumb-item active"><?= $title; ?></li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <?= $this->session->flashdata('message'); ?>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="margin-bottom: 0;">Filter Data or <a href="<?= base_url('C_data_pemasukan/history_data_pemasukan'); ?>" class="text-danger" style="text-decoration: underline;">Reset Filter</a></h5>

                    <form action="<?= base_url('C_data_pemasukan/history_data_pemasukan'); ?>" method="post">
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
                        <table class="table datatable table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">No. </th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Sumber Dana</th>
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
                                foreach ($history_data_pemasukan as $h_pemasukan) {
                                    $no++;

                                    $date = new DateTime($h_pemasukan['tanggal']);
                                    $formatted_date = $date->format('d F Y');
                                    $formatted_date = str_replace(array_keys($months), array_values($months), $formatted_date);
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <td class="text-center"><?= $formatted_date; ?></td>
                                        <td class="text-center"><?= $h_pemasukan['sumber_dana']; ?></td>
                                        <td class="text-center">Rp. <?= number_format($h_pemasukan['jumlah'], 0, ',', '.'); ?>,-</td>
                                        <td class="text-center">
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openBuktiHistoryDataPemasukan(<?= $h_pemasukan['id_pemasukan']; ?>)">
                                                    <!-- Bukti -->
                                                    <span class="badge bg-info"><i class="ri-file-list-3-line"></i></span>
                                                </a>
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openDetailHistoryDataPemasukan(<?= $h_pemasukan['id_pemasukan']; ?>)">
                                                    <!-- Aksi Detail -->
                                                    <span class="badge bg-info"><i class="ri-eye-line"></i></span>
                                                </a>
                                            </h6>
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openEditHistoryDataPemasukan(<?= $h_pemasukan['id_pemasukan']; ?>)">
                                                    <!-- Aksi Edit -->
                                                    <span class="badge bg-warning"><i class="ri-pencil-fill"></i></span>
                                                </a>
                                            </h6>
                                            <h6 class="d-inline">
                                                <a href="#" class="delete-btn" onclick="confirmDeletePemasukan(<?= $h_pemasukan['id_pemasukan']; ?>)">
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

<!-- Start Modal Detail History Data Pemasukan -->
<div class="modal fade" id="modal_detail_history_data_pemasukan" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-file-list-3-line"></i> Detail Data Pemasukan
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
                                    <th scope="col">Sumber Dana</th>
                                    <th scope="col">Tujuan</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Bukti</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td id="td_history_tanggal">DD MM YYYY</td>
                                    <td id="td_history_sumber_dana">Rp. 0</td>
                                    <td id="td_history_tujuan">-</td>
                                    <td id="td_history_keterangan">-</td>
                                    <td id="td_history_jumlah">Rp. 0</td>
                                    <td id="td_history_bukti">-</td>
                                    <td>
                                        <h6 class="m-0"><span class="badge bg-secondary mt-1 mb-1" id="span_history_status">Open</span></h6>
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
<!-- End Modal Detail History Data Pemasukan -->

<!-- Start Modal Edit History Data Pemasukan -->
<div class="modal fade" id="modal_edit_history_data_pemasukan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Edit Data Pemasukan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_pemasukan/edit_data_pemasukan'); ?>" method="post" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <input type="hidden" class="form-control mb-2" name="id_pemasukan" id="id_pemasukan" placeholder="ID Pemasukan" readonly>
                        <div class="col-12">
                            <label for="edit_tanggal" class="form-label">Edit Tanggal</label>
                            <input type="date" class="form-control" name="edit_tanggal" id="edit_tanggal" max="<?= date('Y-m-d', strtotime('+1 days')); ?>" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="edit_sumber_dana" class="form-label">Edit Sumber Dana</label>
                            <input type="text" class="form-control" name="edit_sumber_dana" id="edit_sumber_dana" placeholder="Sumber dana" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="edit_tujuan" class="form-label">Edit Tujuan</label>
                            <select class="form-select" name="edit_tujuan" id="edit_tujuan" required>
                                <option value="">Pilih Tujuan</option>
                                <option value="Tabungan">Tabungan</option>
                                <option value="Planning">Perencanaan / Planning</option>
                                <option value="Main">Main</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="edit_keterangan" class="form-label">Edit Keterangan</label>
                            <input type="text" class="form-control" name="edit_keterangan" id="edit_keterangan" placeholder="Keterangan" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mt-2">
                                <label for="edit_jumlah1" class="form-label">Perubahan</label>
                                <input type="text" class="form-control" name="edit_jumlah1" id="edit_jumlah1" placeholder="Rp. 0" autocomplete="off">
                            </div>
                            <div class="col-6 mt-2">
                                <label for="edit_jumlah2" class="form-label">Jumlah Saat Ini</label>
                                <input type="text" class="form-control" name="edit_jumlah2" id="edit_jumlah2" placeholder="Rp. 0" readonly>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="edit_bukti" class="form-label">Edit Bukti Foto / Kwitansi</label>
                            <div class="thumbnail-container mb-2">
                                <img id="current_image_history" alt="Current Image" class="img-thumbnail">
                                <input type="hidden" class="form-control mt-2" name="foto_lama" id="foto_lama" placeholder="Foto lama">
                            </div>
                            <input class="form-control" type="file" name="edit_bukti" id="edit_bukti">
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
<!-- End Modal Edit History Data Pemasukan -->

<!-- Start Modal Bukti History Pemasukan -->
<div class="modal fade" id="modal_bukti_history_data_pemasukan" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-file-list-3-line"></i> Bukti Pemasukan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="col-md-12">
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <img alt="Foto Bukti" id="detail_bukti" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Bukti History Data Pemasukan -->