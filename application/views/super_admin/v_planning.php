<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Perencanaan</li>
            <li class="breadcrumb-item active"><?= $title; ?></li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">

        <div class="col-xl-3 col-lg-3 col-xs-12 col-sm-12 mb-3">
            <button class="btn btn-primary col-12" data-bs-toggle="modal" data-bs-target="#modal_input_data_planning">
                <i class="ri-pencil-fill"></i> Buat Planning
            </button>
        </div>

        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List Data Planning</h5>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">No. </th>
                                    <th class="text-center">Tanggal Planning</th>
                                    <th class="text-center">Tanggal Deadline</th>
                                    <th class="text-center">Tujuan</th>
                                    <th class="text-center">Jumlah Anggaran</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($data_planning as $planning) {
                                    $no++;
                                    $status = $planning['status'];
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <td class="text-center"><?= $planning['tanggal_rencana']; ?></td>
                                        <td class="text-center"><?= $planning['tanggal_deadline']; ?></td>
                                        <td class="text-center"><?= $planning['tujuan']; ?></td>
                                        <td class="text-center">Rp. <?= number_format($planning['jumlah_anggaran'], 0, ',', '.'); ?>,-</td>
                                        <td class="text-center">
                                            <?php if ($status == 0) { ?>
                                                <span class="badge bg-warning">Open</span>
                                            <?php } else if ($status == 1) { ?>
                                                <span class="badge bg-success">Sudah di Review</span>
                                            <?php } else if ($status == 2) { ?>
                                                <span class="badge bg-danger">Belum di Review</span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openDetailDataPlanning(<?= $planning['id_planning']; ?>)">
                                                    <!-- Aksi Detail -->
                                                    <span class="badge bg-info"><i class="ri-eye-line"></i></span>
                                                </a>
                                            </h6>
                                            <h6 class="d-inline">
                                                <a href="#" onclick="confirmDeletePlanning(<?= $planning['id_planning']; ?>)">
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

<!-- Start Modal Input Data Planning -->
<div class="modal fade" id="modal_input_data_planning" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Buat Planning
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_planning/input_data_planning'); ?>" method="post" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-6">
                                <label for="tanggal_planning" class="form-label">Tanggal Rencana</label>
                                <input type="date" class="form-control" name="tanggal_planning" id="tanggal_planning" required>
                            </div>
                            <div class="col-6">
                                <label for="deadline_planning" class="form-label">Deadline</label>
                                <input type="date" class="form-control" name="deadline_planning" id="deadline_planning" required>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="tujuan_planning" class="form-label">Tujuan</label>
                            <input type="text" class="form-control" name="tujuan_planning" id="tujuan_planning" placeholder="Tujuan" autocomplete="off" required>
                        </div>

                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="jumlah_anggaran_planning" class="form-label">Target Uang</label>
                                <input type="text" class="form-control" name="jumlah_anggaran_planning" id="jumlah_anggaran_planning" placeholder="Rp. 0" autocomplete="off" required>
                            </div>
                            <div class="col-6">
                                <label for="dana_tersedia" class="form-label">Uang Tabungan</label>
                                <input type="text" class="form-control" name="dana_tersedia" id="dana_tersedia" value="Rp. <?= number_format($total_pemasukan, 0, ',', '.'); ?>,-" placeholder="Rp. 0" readonly>
                            </div>
                        </div>

                        <hr style="border: 1px dashed;">

                        <div id="detail_container">
                            <div class="row mb-2 detail-row">
                                <div class="col-5">
                                    <label for="item_planning_0" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" name="item_planning[0]" id="item_planning_0" placeholder="Item" autocomplete="off" required>
                                </div>
                                <div class="col-5">
                                    <label for="estimasi_harga_0" class="form-label">Estimasi Harga</label>
                                    <input type="text" class="form-control estimasi_harga" name="estimasi_harga[0]" id="estimasi_harga_0" placeholder="Rp. 0" required>
                                </div>
                                <div class="col-2 d-flex align-items-end">
                                    <button class="btn btn-outline-primary col-12" type="button" id="btn_add_detail_anggaran"><i class="ri-add-fill"></i></button>
                                </div>
                            </div>
                        </div>

                        <hr style="border: 1px dashed;">

                        <div class="row">
                            <div class="col-5"></div>
                            <div class="col-5">
                                <input type="text" class="form-control" name="total_harga_planning" id="total_harga_planning" placeholder="Rp. 0" readonly>
                            </div>
                            <div class="col-2"></div>
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
<!-- End Modal Input Data Planning -->

<!-- Start Modal Detail Planning -->
<div class="modal fade" id="modal_detail_data_planning" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-file-list-3-line"></i> Detail Data Planning
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="col-md-12">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Detail Kebutuhan</th>
                                    <th class="text-center">:</th>
                                    <th>Estimasi Harga</th>
                                </tr>
                            </thead>
                            <tbody id="detail_data_planning_body">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="font-weight: bold;">Total</td>
                                    <td class="text-center">:</td>
                                    <td style="font-weight: bold;" id="total_estimasi_planning">Rp. 0</td>
                                </tr>
                            </tfoot>
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
<!-- End Modal Detail Planning -->