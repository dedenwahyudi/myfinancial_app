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

        <div class="col-xl-3 col-lg-3 col-xs-12 col-sm-12 mb-3">
            <button class="btn btn-primary col-12" data-bs-toggle="modal" data-bs-target="#modal_input_budget_pengeluaran">
                <i class="ri-pencil-fill"></i> Input Data Budget
            </button>
        </div>

        <div class=" col-lg-12">

            <?= $this->session->flashdata('message'); ?>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="margin-bottom: 0;">List Data</h5>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">No. </th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Periode</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Budget</th>
                                    <th class="text-center">Realisasi</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($budget_pengeluaran_bulanan as $budget_bulanan) {
                                    $no++;
                                    $status = $budget_bulanan['status'];
                                    $budget = $budget_bulanan['jumlah'];
                                    $realisasi = $budget_bulanan['total_pengeluaran'];
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <td class="text-center"><?= $budget_bulanan['kode_budget']; ?></td>
                                        <td class="text-center"><?= $budget_bulanan['bulan'] . '  ' . $budget_bulanan['tahun']; ?></td>
                                        <td class="text-center"><?= $budget_bulanan['keterangan']; ?></td>
                                        <td class="text-center">Rp. <?= number_format($budget, 0, ',', '.'); ?>,-</td>
                                        <td class="text-center">Rp. <?= number_format($realisasi !== null ? $realisasi : 0, 2); ?>,-</td>
                                        <td class="text-center">
                                            <?php
                                            $threshold = 0.1 * $budget;

                                            if ($realisasi == $budget) {
                                                echo '<span class="badge bg-success">Sesuai</span>';
                                            } else if ($realisasi != $budget) {
                                                if (abs($realisasi - $budget) <= $threshold) {
                                                    echo '<span class="badge bg-warning text-dark">Warning</span>';
                                                } else {
                                                    echo '<span class="badge bg-danger">Tidak Sesuai</span>';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openEditBudgetPengeluaran(<?= $budget_bulanan['id_budget']; ?>)">
                                                    <!-- Aksi Edit -->
                                                    <span class="badge bg-warning"><i class="ri-pencil-fill"></i></span>
                                                </a>
                                            </h6>
                                            <h6 class="d-inline">
                                                <a href="#" onclick="confirmDeleteBudget(<?= $budget_bulanan['id_budget']; ?>)">
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

<!-- Start Modal Input Budget Pengeluaran -->
<div class="modal fade" id="modal_input_budget_pengeluaran" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Input Data Budget
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_pengeluaran/input_budget_pengeluaran'); ?>" method="post" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="kode_budget" class="form-label">Kode Budget</label>
                            <input type="text" class="form-control" name="kode_budget" id="kode_budget" value="<?= $next_code ?>" readonly>
                        </div>
                        <div class="row">
                            <div class="col-6 mt-2">
                                <label for="bulan_budget" class="form-label">Bulan</label>
                                <select class="form-select" name="bulan_budget" id="bulan_budget" required>
                                    <option value="">Pilih Bulan</option>
                                    <option value="Januari">Januari</option>
                                    <option value="Februari">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="April">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Juni">Juni</option>
                                    <option value="Juli">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="September">September</option>
                                    <option value="Oktober">Oktober</option>
                                    <option value="November">November</option>
                                    <option value="Desember">Desember</option>
                                </select>
                            </div>
                            <div class="col-6 mt-2">
                                <label for="tahun_budget" class="form-label">Tahun</label>
                                <select class="form-select" name="tahun_budget" id="tahun_budget" required>
                                    <option value="">Pilih Tahun</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="keterangan_budget" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan_budget" id="keterangan_budget" placeholder="Keterangan" autocomplete="off" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="jumlah_budget" class="form-label">Jumlah</label>
                            <input type="text" class="form-control" name="jumlah_budget" id="jumlah_budget" placeholder="Rp. 0" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btn-simpan-budget">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Input Budget Pengeluaran -->

<!-- Start Modal Edit Budget Pengeluaran -->
<div class="modal fade" id="modal_edit_budget_pengeluaran" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Edit Budget Pengeluaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_pengeluaran/edit_data_budget_pengeluaran'); ?>" method="post" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <input type="hidden" class="form-control mb-2" name="id_budget" id="id_budget" placeholder="ID Budget" readonly>
                        <div class="col-12">
                            <label for="edit_bulan" class="form-label">Edit Bulan</label>
                            <select class="form-select" name="edit_bulan" id="edit_bulan" required>
                                <option value="">Pilih Bulan</option>
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="edit_tahun" class="form-label">Tahun</label>
                            <select class="form-select" name="edit_tahun" id="edit_tahun" required>
                                <option value="">Pilih Tahun</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="edit_keterangan" class="form-label">Edit Keterangan</label>
                            <input type="text" class="form-control" name="edit_keterangan" id="edit_keterangan" placeholder="Edit keterangan" autocomplete="off" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mt-2">
                                <label for="edit_jumlah_budget1" class="form-label">Perubahan</label>
                                <input type="text" class="form-control" name="edit_jumlah_budget1" id="edit_jumlah_budget1" placeholder="Rp. 0" autocomplete="off">
                            </div>
                            <div class="col-6 mt-2">
                                <label for="edit_jumlah_budget2" class="form-label">Jumlah Saat Ini</label>
                                <input type="text" class="form-control" name="edit_jumlah_budget2" id="edit_jumlah_budget2" placeholder="Rp. 0" readonly>
                            </div>
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
<!-- End Modal Edit Budget Pengeluaran -->