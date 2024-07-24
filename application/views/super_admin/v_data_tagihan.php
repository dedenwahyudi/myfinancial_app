<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Tagihan</li>
            <li class="breadcrumb-item active"><?= $title; ?></li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">

        <div class="col-xl-4 col-lg-3 col-xs-12 col-sm-12 mb-3">
            <button class="btn btn-primary col-12" data-bs-toggle="modal" data-bs-target="#modal_buat_data_tagihan">
                <i class="ri-pencil-fill"></i> Buat Data Tagihan
            </button>
        </div>

        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List Data Tagihan</h5>
                    <div class="table-responsive">
                        <table class="table datatable table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center nowrap">No. </th>
                                    <th class="text-center nowrap">Merchant</th>
                                    <th class="text-center nowrap">Tenor</th>
                                    <th class="text-center nowrap">Jml. Bayar</th>
                                    <th class="text-center nowrap">Sudah Dibayar</th>
                                    <th class="text-center nowrap">Belum Dibayar</th>
                                    <th class="text-center nowrap">Jatuh Tempo</th>
                                    <th class="text-center nowrap">Status</th>
                                    <th class="text-center nowrap">Aksi</th>
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
                                foreach ($data_tagihan as $tagihan) {
                                    $no++;

                                    $date = new DateTime($tagihan['tgl_jatuh_tempo']);
                                    $formatted_date = $date->format('d F Y');
                                    $formatted_date = str_replace(array_keys($months), array_values($months), $formatted_date);

                                    $status = $tagihan['status'];
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <td class="text-center"><?= $tagihan['nama_merchant']; ?></td>
                                        <td class="text-center"><?= $tagihan['jml_tenor']; ?> bln</td>
                                        <td class="text-center">Rp. <?= number_format($tagihan['jml_bayar'], 0, ',', '.'); ?>,-</td>
                                        <td class="text-center"><?= $tagihan['sudah_dibayar']; ?></td>
                                        <td class="text-center"><?= $tagihan['belum_dibayar']; ?></td>
                                        <td class="text-center"><?= $formatted_date; ?></td>
                                        <td class="text-center">
                                            <?php if ($status == 0) { ?>
                                                <span class="badge bg-warning">Belum Lunas</span>
                                            <?php } else if ($status == 1) { ?>
                                                <span class="badge bg-success">Lunas</span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openEditDataTagihan(<?= $tagihan['id_tagihan']; ?>)">
                                                    <!-- Aksi Edit -->
                                                    <span class="badge bg-warning"><i class="ri-pencil-fill"></i></span>
                                                </a>
                                            </h6>
                                            <h6 class="d-inline">
                                                <a href="#" class="delete-btn" onclick="confirmDeleteTagihan(<?= $tagihan['id_tagihan']; ?>)">
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

<!-- Start Modal Buat Data Tagihan -->
<div class="modal fade" id="modal_buat_data_tagihan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Buat Data Tagihan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_tagihan/buat_data_tagihan'); ?>" method="post" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="nama_merchant" class="form-label">Nama Merchant</label>
                            <input type="text" class="form-control" name="nama_merchant" id="nama_merchant" placeholder="Nama merchant" autocomplete="off" required>
                        </div>

                        <div class="row">
                            <div class="col-4 mt-2">
                                <label for="jumlah_tenor" class="form-label">Tenor</label>
                                <input type="number" class="form-control" name="jumlah_tenor" id="jumlah_tenor" min="0" placeholder="0" autocomplete="off" required>
                            </div>
                            <div class="col-8 mt-2">
                                <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
                                <input type="text" class="form-control" name="jumlah_bayar" id="jumlah_bayar" placeholder="Rp. 0" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mt-2">
                                <label for="sudah_dibayar" class="form-label">Sudah Dibayar</label>
                                <input type="number" class="form-control" name="sudah_dibayar" id="sudah_dibayar" min="0" placeholder="0" autocomplete="off" required>
                            </div>
                            <div class="col-6 mt-2">
                                <label for="belum_dibayar" class="form-label">Belum Dibayar</label>
                                <input type="number" class="form-control" name="belum_dibayar" id="belum_dibayar" min="0" placeholder="0" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="jatuh_tempo" class="form-label">Jatuh Tempo</label>
                            <input type="date" class="form-control" name="jatuh_tempo" id="jatuh_tempo" placeholder="Jatuh tempo" autocomplete="off" required>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" autocomplete="off" required></textarea>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="">Pilih Status</option>
                                <option value="0">Belum Lunas</option>
                                <option value="1">Lunas</option>
                            </select>
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
<!-- End Modal Buat Data Tagihan -->

<!-- Start Modal Edit Data Tagihan -->
<div class="modal fade" id="modal_edit_data_tagihan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Edit Data Tagihan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_tagihan/edit_data_tagihan'); ?>" method="post" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <input type="hidden" class="form-control mb-2" name="id_tagihan" id="id_tagihan" placeholder="ID Tagihan" readonly>

                        <div class="col-12">
                            <label for="edit_nama_merchant" class="form-label">Nama Merchant</label>
                            <input type="text" class="form-control" name="edit_nama_merchant" id="edit_nama_merchant" placeholder="Nama merchant" autocomplete="off" required>
                        </div>

                        <div class="row">
                            <div class="col-4 mt-2">
                                <label for="edit_jumlah_tenor" class="form-label">Tenor</label>
                                <input type="number" class="form-control" name="edit_jumlah_tenor" id="edit_jumlah_tenor" min="0" placeholder="0" autocomplete="off" required>
                            </div>
                            <div class="col-8 mt-2">
                                <label for="edit_jumlah_bayar" class="form-label">Jumlah Bayar</label>
                                <input type="text" class="form-control" name="edit_jumlah_bayar" id="edit_jumlah_bayar" placeholder="Rp. 0" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mt-2">
                                <label for="edit_sudah_dibayar" class="form-label">Sudah Dibayar</label>
                                <input type="number" class="form-control" name="edit_sudah_dibayar" id="edit_sudah_dibayar" min="0" placeholder="0" autocomplete="off" required>
                            </div>
                            <div class="col-6 mt-2">
                                <label for="edit_belum_dibayar" class="form-label">Belum Dibayar</label>
                                <input type="number" class="form-control" name="edit_belum_dibayar" id="edit_belum_dibayar" min="0" placeholder="0" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="edit_jatuh_tempo" class="form-label">Jatuh Tempo</label>
                            <input type="date" class="form-control" name="edit_jatuh_tempo" id="edit_jatuh_tempo" placeholder="Jatuh tempo" autocomplete="off" required>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="edit_keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" name="edit_keterangan" id="edit_keterangan" placeholder="Keterangan" autocomplete="off" required></textarea>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" name="edit_status" id="edit_status" required>
                                <option value="">Pilih Status</option>
                                <option value="0">Belum Lunas</option>
                                <option value="1">Lunas</option>
                            </select>
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
<!-- End Modal Edit Data Tagihan -->