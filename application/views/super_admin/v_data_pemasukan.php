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

        <div class="col-xl-4 col-lg-3 col-xs-12 col-sm-12 mb-3">
            <button class="btn btn-primary col-12" data-bs-toggle="modal" data-bs-target="#modal_input_data_pemasukan">
                <i class="ri-pencil-fill"></i> Input Data Pemasukan
            </button>
        </div>

        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List Data Pemasukan</h5>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">No. </th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Sumber Dana</th>
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
                                foreach ($data_pemasukan as $pemasukan) {
                                    $no++;

                                    $date = new DateTime($pemasukan['tanggal']);
                                    $formatted_date = $date->format('d F Y');
                                    $formatted_date = str_replace(array_keys($months), array_values($months), $formatted_date);
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <td class="text-center"><?= $formatted_date; ?></td>
                                        <td class="text-center"><?= $pemasukan['sumber_dana']; ?></td>
                                        <td class="text-center">Rp. <?= number_format($pemasukan['jumlah'], 0, ',', '.'); ?>,-</td>
                                        <td class="text-center">
                                            <h6 class="d-inline">
                                                <a href="#" onclick="openDetailPemasukan(<?= $pemasukan['id_pemasukan']; ?>)">
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

<!-- Start Modal Input Data Pemasukan -->
<div class="modal fade" id="modal_input_data_pemasukan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-pencil-fill"></i> Input Data Pemasukan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('C_data_pemasukan/input_data_pemasukan'); ?>" method="post" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-12">
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" max="<?= date('Y-m-d', strtotime('+1 days')); ?>" required>
                        </div>
                        <div class=" col-12 mt-2">
                            <label for="sumber_dana" class="form-label">Sumber Dana</label>
                            <input type="text" class="form-control" name="sumber_dana" id="sumber_dana" placeholder="Sumber dana" autocomplete="off" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="tujuan" class="form-label">Tujuan</label>
                            <select class="form-select" name="tujuan" id="tujuan" required>
                                <option value="">Pilih Tujuan</option>
                                <option value="Tabungan">Tabungan</option>
                                <option value="Planning">Perencanaan / Planning</option>
                                <option value="Main">Main</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" autocomplete="off" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Rp. 0" autocomplete="off" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="bukti" class="form-label">Bukti Foto / Kwitansi</label>
                            <input class="form-control" type="file" name="bukti" id="bukti" required>
                        </div>
                        <div class="col-12 mt-2">
                            <input class="form-check-input" type="checkbox" name="tanpa_bukti" id="tanpa_bukti" value="Tanpa lampiran bukti">
                            <label class="form-check-label" for="tanpa_bukti">
                                Tanpa lampiran
                            </label>
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
<!-- End Modal Input Data Pemasukan -->

<!-- Start Modal Detail Pemasukan -->
<div class="modal fade" id="modal_detail_data_pemasukan" tabindex="-1">
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
                                    <td id="td_tanggal">DD MM YYYY</td>
                                    <td id="td_sumber_dana">Rp. 0</td>
                                    <td id="td_tujuan">-</td>
                                    <td id="td_keterangan">-</td>
                                    <td id="td_jumlah">Rp. 0</td>
                                    <td id="td_bukti">-</td>
                                    <td id="td_status">
                                        <h6 class="m-0"><span class="badge bg-secondary mt-1 mb-1" id="span_status">Open</span></h6>
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
<!-- End Modal Detail Pemasukan -->