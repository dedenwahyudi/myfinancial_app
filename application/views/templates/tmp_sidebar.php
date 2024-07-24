<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">MENU MANAGEMENT</li>
        <hr style="border: 1px dashed;">

        <li class="nav-item">
            <a class="nav-link nav-link-ajax" href="<?= base_url('C_dashboard'); ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php if ($this->session->userdata('user_level') == '1') { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#income-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri-book-2-fill"></i><span>Pemasukan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="income-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link-ajax" href="<?= base_url('C_data_pemasukan'); ?>">
                            <i class="bi bi-circle"></i><span>Data Pemasukan</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link-ajax" href="<?= base_url('C_data_pemasukan/history_data_pemasukan'); ?>">
                            <i class="bi bi-circle"></i><span>History Data Pemasukan</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#outcome-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri-book-2-line"></i><span>Pengeluaran</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="outcome-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link-ajax" href="<?= base_url('C_data_pengeluaran'); ?>">
                            <i class="bi bi-circle"></i><span>Data Pengeluaran</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link-ajax" href="<?= base_url('C_data_pengeluaran/history_data_pengeluaran'); ?>">
                            <i class=" bi bi-circle"></i><span>History Data Pengeluaran</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link-ajax" href="<?= base_url('C_data_pengeluaran/budget_pengeluaran'); ?>">
                            <i class=" bi bi-circle"></i><span>Budget Pengeluaran</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#planning-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri-service-line"></i><span>Perencanaan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="planning-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link-ajax" href="<?= base_url('C_data_planning'); ?>">
                            <i class="bi bi-circle"></i><span>Planning</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#other-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri-apps-2-line"></i><span>Lain-lain</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="other-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link-ajax" href="<?= base_url('C_data_tagihan'); ?>">
                            <i class="bi bi-circle"></i><span>Tagihan</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link-ajax" href="<?= base_url('C_data_thr'); ?>">
                            <i class="bi bi-circle"></i><span>THR</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri-file-list-3-line"></i><span>Rekap</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Pemasukan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('C_data_pengeluaran/download_pengeluaran'); ?>">
                            <i class="bi bi-circle"></i><span>Pengeluaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>History Transaksi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Planning</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <hr style="border: 1px dashed;">

        <li class="nav-item">
            <?php if ($this->session->userdata('username') == 'dednwhyd') { ?>
                <a class="nav-link collapsed" onclick="confirmTruncate()" href="#">
                    <i class="ri-delete-bin-5-line"></i>
                    <span>Truncate Data</span>
                </a>
            <?php } ?>
            <a class="nav-link collapsed" href="<?= base_url('C_auth/logout'); ?>">
                <i class="bi bi-box-arrow-in-left"></i>
                <span>Logout</span>
            </a>
        </li><!-- End Login Page Nav -->
    </ul>

</aside><!-- End Sidebar-->