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

                        <img src="<?= $foto; ?>" alt="Profile" class="rounded-circle">
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
                            <h3><i class="ri-pencil-fill"></i> Change Password</h3>
                        </ul>
                        <div class="tab-content pt-2">
                            <?= $this->session->flashdata('message'); ?>
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <form action="<?= base_url('C_user_profile/edit_password'); ?>" method="post" class="row g-3">
                                    <!-- ID User -->
                                    <div class="col-md-12">
                                        <input type="hidden" class="form-control" name="id_user" id="id_user" placeholder="-" value="<?= $id_user; ?>" readonly>
                                    </div>
                                    <!-- Current Password -->
                                    <div class="col-md-12">
                                        <label for="old_password" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" name="old_password" id="old_password" autocomplete="off" required>
                                    </div>
                                    <!-- New Password 1 -->
                                    <div class="col-md-12">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="new_password" id="new_password" autocomplete="off" required>
                                    </div>
                                    <!-- New Password 2 -->
                                    <div class="col-md-12">
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" autocomplete="off" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary mt-3">Edit Password</button>
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