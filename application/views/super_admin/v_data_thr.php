<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">THR</li>
            <li class="breadcrumb-item active"><?= $title; ?></li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">

        <div class="col-xl-4 col-lg-3 col-xs-12 col-sm-12 mb-3">
            <button class="btn btn-primary col-12" data-bs-toggle="modal" data-bs-target="#modal_buat_data_thr">
                <i class="ri-pencil-fill"></i> Buat Data THR
            </button>
        </div>

        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List Data THR</h5>
                    <div class="table-responsive">
                        <table class="table datatable table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center nowrap">No. </th>
                                    <th class="text-center nowrap">Penerima</th>
                                    <th class="text-center nowrap">Nominal</th>
                                    <th class="text-center nowrap">Keterangan</th>
                                    <th class="text-center nowrap">Status</th>
                                    <th class="text-center nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($data_thr as $thr) {
                                    $no++;
                                    $status = $thr['status'];
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <td class="text-center"><?= $thr['penerima']; ?></td>
                                        <td class="text-center">Rp. <?= number_format($thr['nominal'], 0, ',', '.'); ?>,-</td>
                                        <td class="text-center"><?= $thr['keterangan']; ?></td>
                                        <td class="text-center">
                                            <?php if ($status == 0) { ?>
                                                <span class="badge bg-warning">Rencana</span>
                                            <?php } else if ($status == 1) { ?>
                                                <span class="badge bg-success">Diterima</span>
                                            <?php } else if ($status == 2) { ?>
                                                <span class="badge bg-info">Tidak Diterima</span>
                                            <?php } else if ($status == 3) { ?>
                                                <span class="badge bg-danger">Batal</span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openEditDataThr(<?= $thr['id_thr']; ?>)">
                                                    <!-- Aksi Edit -->
                                                    <span class="badge bg-warning"><i class="ri-pencil-fill"></i></span>
                                                </a>
                                            </h6>
                                            <h6 class="d-inline">
                                                <a href="#" class="delete-btn" onclick="confirmDeleteThr(<?= $thr['id_thr']; ?>)">
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

<!-- Start Modal Buat Data THR -->
<div class="modal fade" id="modal_buat_data_thr" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Buat Data THR
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_thr/buat_data_thr'); ?>" method="post" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="penerima" class="form-label">Penerima</label>
                            <input type="text" class="form-control" name="penerima" id="penerima" placeholder="Penerima" autocomplete="off" required>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Nominal" autocomplete="off" required>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" autocomplete="off" required></textarea>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="">Pilih Status</option>
                                <option value="0">Rencana</option>
                                <option value="1">Diterima</option>
                                <option value="2">Tidak Diterima</option>
                                <option value="3">Batal</option>
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
<!-- End Modal Buat Data THR -->

<!-- Start Modal Edit Data THR -->
<div class="modal fade" id="modal_edit_data_thr" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Edit Data THR
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_thr/edit_data_thr'); ?>" method="post" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <input type="hidden" class="form-control mb-2" name="id_thr" id="id_thr" placeholder="ID THR" readonly>

                        <div class="col-12">
                            <label for="edit_penerima" class="form-label">Penerima</label>
                            <input type="text" class="form-control" name="edit_penerima" id="edit_penerima" placeholder="Penerima" autocomplete="off" required>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="edit_nominal" class="form-label">Nominal</label>
                            <input type="text" class="form-control" name="edit_nominal" id="edit_nominal" placeholder="Nominal" autocomplete="off" required>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="edit_keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" name="edit_keterangan" id="edit_keterangan" placeholder="Keterangan" autocomplete="off" required></textarea>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" name="edit_status" id="edit_status" required>
                                <option value="">Pilih Status</option>
                                <option value="0">Rencana</option>
                                <option value="1">Diterima</option>
                                <option value="2">Tidak Diterima</option>
                                <option value="3">Tidak Diterima</option>
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
<!-- End Modal Edit Data THR -->