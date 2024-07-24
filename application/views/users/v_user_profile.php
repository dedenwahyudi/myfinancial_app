<main id="main" class="main">

    <div class="pagetitle">
        <h1><?= $title; ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">User Profile</li>
            </ol>
        </nav>
    </div>

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <div class="position-relative d-inline-block mb-3">
                            <img src="<?= $foto; ?>" alt="Profile" class="rounded-circle">
                            <a href="#" onclick="openEditFotoProfile()" class="badge bg-primary text-white position-absolute start-50 translate-middle-x" style="bottom: -10px; border: 2px solid #fff;">
                                <i class="bi bi-pencil"></i> Ganti Foto
                            </a>
                        </div>

                        <h2><?= $nama; ?></h2>
                        <h3><?= $profesi; ?></h3>
                        <p class="text-muted mb-0"><?= $email; ?></p>
                        <p class="text-muted"><?= $no_telp; ?></p>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <h3><i class="ri-pencil-fill"></i> Edit Profile</h3>
                        </ul>
                        <div class="tab-content pt-2">
                            <?= $this->session->flashdata('message'); ?>
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <form action="<?= base_url('C_user_profile/edit_profile'); ?>" method="post" class="row g-3">
                                    <!-- ID User -->
                                    <div class="col-md-12">
                                        <input type="hidden" class="form-control" name="id_user" id="id_user" placeholder="-" value="<?= $id_user; ?>" readonly>
                                    </div>
                                    <!-- Username -->
                                    <div class="col-md-12">
                                        <label for="edit_username" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="edit_username" id="edit_username" placeholder="-" value="<?= $username; ?>" readonly>
                                    </div>
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <label for="edit_firstname" class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="edit_firstname" id="edit_firstname" value="<?= $firstname; ?>" placeholder="-">
                                    </div>
                                    <!-- Last Name -->
                                    <div class="col-md-6">
                                        <label for="edit_lastname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="edit_lastname" id="edit_lastname" value="<?= $lastname; ?>" placeholder="-">
                                    </div>
                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="edit_email" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="edit_email" id="edit_email" value="<?= $email; ?>" placeholder="-">
                                    </div>
                                    <!-- No. Telp -->
                                    <div class="col-md-6">
                                        <label for="edit_no_telp" class="form-label">No. Telp</label>
                                        <input type="text" class="form-control" name="edit_no_telp" id="edit_no_telp" value="<?= $no_telp; ?>" placeholder="-">
                                    </div>
                                    <!-- Profesi -->
                                    <div class="col-md-12">
                                        <label for="edit_profesi" class="form-label">Profesi</label>
                                        <input type="text" class="form-control" name="edit_profesi" id="edit_profesi" value="<?= $profesi; ?>" placeholder="-">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary mt-3">Edit Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<!-- Start Modal Edit Foto Profile -->
<div class="modal fade" id="modal_edit_foto_profile" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form_ganti_foto" action="<?= base_url('C_user_profile/edit_foto'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ri-file-list-3-line"></i> Ganti Foto Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="#" id="preview_foto" class="img-fluid mb-3" style="display: none; max-width: 50%; max-height: auto; border: 3px solid #ddd; border-radius: 15px" alt="Preview Foto">
                    <input type="file" class="form-control mt-1" name="foto_baru" id="foto_baru">
                    <input type="hidden" class="form-control mt-1" name="foto_lama" id="foto_lama" value="<?= base_url('assets/uploads/profile/') . $foto; ?>" placeholder="Foto lama" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Edit Foto Profile -->