<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WebSIG Kabupaten Serang</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('sb-admin') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('sb-admin') ?>/css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('Home') ?>">
                <img src="<?= base_url('images/kab-serang.png'); ?>" alt="Dinas Perhubungan Logo"
                    style="width: 40px; height: 40px; margin-right: 10px;">
                <div class="sidebar-brand-text mx-3">Dinas Perhubungan </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Home') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <?php if (session()->get('isLoggedIn')): ?>
                <?php if (in_array(session('role'), ['admin'])): ?>
                    <hr class="sidebar-divider">

                    <!-- Divider -->
                    <div class="sidebar-heading">
                        Log Aktivitas
                    </div>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLogActivity"
                            aria-expanded="true" aria-controls="collapseLogActivity">

                            <span>Log Aktivitas</span>
                        </a>
                        <div id="collapseLogActivity" class="collapse" aria-labelledby="headingData"
                            data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item text-wrap" href="<?= base_url('DataLogActivity/index') ?>">Data
                                    Log Aktivitas</a>
                            </div>
                        </div>
                    </li>

                    

                   
                <?php endif; ?>

                <?php if (in_array(session('role'), ['admin', 'rekayasa'])): ?>
                    <hr class="sidebar-divider">

                    <!-- Divider -->
                    <div class="sidebar-heading">
                        Rekayasa
                    </div>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePemeliharaan"
                            aria-expanded="true" aria-controls="collapsePemeliharaan">

                            <span>Pemeliharaan</span>
                        </a>
                        <div id="collapsePemeliharaan" class="collapse" aria-labelledby="headingData"
                            data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item text-wrap" href="<?= base_url('DataPemeliharaan/index') ?>">Data
                                    Pemeliharaan Jalan</a>

                                <a class="collapse-item text-wrap"
                                    href="<?= base_url('DataPemeliharaan/inputPemeliharaan') ?>">Tambah Data Pemeliharaan
                                    Jalan</a>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (in_array(session('role'), ['admin', 'management'])): ?>
                    <hr class="sidebar-divider">

                    <!-- Divider -->
                    <div class="sidebar-heading">
                        Pengadaan
                    </div>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengadaan"
                            aria-expanded="true" aria-controls="collapsePengadaan">

                            <span>Pengadaan</span>
                        </a>
                        <div id="collapsePengadaan" class="collapse" aria-labelledby="headingData"
                            data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item text-wrap" href="<?= base_url('DataPengadaan/index') ?>">Data
                                    Pengadaan</a>

                                <a class="collapse-item text-wrap" href="<?= base_url('DataPengadaan/inputPengadaan') ?>">Tambah
                                    Data Pengadaan
                                </a>
                            </div>
                        </div>
                    </li>

                    <hr class="sidebar-divider">

                    <!-- Divider -->
                    <div class="sidebar-heading">
                        Master Data
                    </div>

                    <!-- Nav Item - Master Data -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMasterData"
                            aria-expanded="true" aria-controls="collapseMasterData">
                            <!-- <i class="fas fa-fw fa-database"></i> -->
                            <span>Master Data</span>
                        </a>
                        <div id="collapseMasterData" class="collapse" aria-labelledby="headingMasterData"
                            data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item text-wrap" href="<?= base_url('DataJenisPerlengkapan') ?>">
                                    Jenis Perlengkapan
                                </a>
                            </div>
                        </div>
                    </li>

                    <hr class="sidebar-divider">

                    <div class="sidebar-heading">
                        Laporan Masyarakat
                    </div>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePelaporan"
                            aria-expanded="true" aria-controls="collapsePelaporan">

                            <span>Laporan Kerusakan</span>
                        </a>
                        <div id="collapsePelaporan" class="collapse" aria-labelledby="headingData"
                            data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item text-wrap" href="<?= base_url('DataPelaporan/index') ?>">
                                    Data Pelaporan</a>
                            </div>
                        </div>
                    </li>

                    <hr class="sidebar-divider">

                    <!-- Divider -->
                    <div class="sidebar-heading">
                        Rencana Anggaran Biaya
                    </div>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse"
                            data-target="#collapseRencanaAnggaranBiaya" aria-expanded="true"
                            aria-controls="collapseRencanaAnggaranBiaya">

                            <span>Rencana Anggaran Biaya</span>
                        </a>
                        <div id="collapseRencanaAnggaranBiaya" class="collapse" aria-labelledby="headingData"
                            data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item text-wrap" href="<?= base_url('DataRencanaAnggaranBiaya/index') ?>">Data
                                    Rencana Anggaran Biaya</a>

                                <a class="collapse-item text-wrap"
                                    href="<?= base_url('DataRencanaAnggaranBiaya/inputRencanaAnggaranBiaya') ?>">Tambah
                                    Data Rencana Anggaran Biaya
                                </a>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>


                <hr class="sidebar-divider">

                <!-- Divider -->
                <div class="sidebar-heading">
                    Kelola Data Perlengkapan Jalan
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseData"
                        aria-expanded="true" aria-controls="collapseData">

                        <span>Perlengkapan Jalan</span>
                    </a>
                    <div id="collapseData" class="collapse" aria-labelledby="headingData" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item text-wrap" href="<?= base_url('DataPerlengkapan/index') ?>">Data
                                Perlengkapan Jalan</a>

                            <a class="collapse-item text-wrap"
                                href="<?= base_url('DataPerlengkapan/inputPerlengkapan') ?>">Tambah Data Perlengkapan
                                Jalan</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>


            <hr class="sidebar-divider">


            <!-- Heading -->
            <div class="sidebar-heading">
                Perlengkapan Jalan
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseApill"
                    aria-expanded="true" aria-controls="collapseApill">

                    <span>APILL</span>
                </a>
                <div id="collapseApill" class="collapse" aria-labelledby="headingApill" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('Home/apill_eksisting_user') ?>">Eksisting</a>
                        <a class="collapse-item" href="<?= base_url('Home/apill_perbaikan_user') ?>">Perbaikan</a>
                        <a class="collapse-item" href="<?= base_url('Home/apill_perencanaan_user') ?>">Rencana</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePju"
                    aria-expanded="true" aria-controls="collapsePju">

                    <span>PJU</span>
                </a>
                <div id="collapsePju" class="collapse" aria-labelledby="headingPju" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('Home/pju_eksisting_user') ?>">Eksisting</a>
                        <a class="collapse-item" href="<?= base_url('Home/pju_perbaikan_user') ?>">Perbaikan</a>
                        <a class="collapse-item" href="<?= base_url('Home/pju_perencanaan_user') ?>">Rencana</a>

                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMarka"
                    aria-expanded="true" aria-controls="collapseMarka">

                    <span>Marka Jalan</span>
                </a>
                <div id="collapseMarka" class="collapse" aria-labelledby="headingMarka" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('Home/marka_eksisting_user') ?>">Eksisting</a>
                        <a class="collapse-item" href="<?= base_url('Home/marka_perbaikan_user') ?>">Perbaikan</a>
                        <a class="collapse-item" href="<?= base_url('Home/marka_perencanaan_user') ?>">Rencana</a>

                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRambu"
                    aria-expanded="true" aria-controls="collapseRambu">

                    <span>Rambu Jalan</span>
                </a>
                <div id="collapseRambu" class="collapse" aria-labelledby="headingRambu" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('Home/rambu_eksisting_user') ?>">Eksisting</a>
                        <a class="collapse-item" href="<?= base_url('Home/rambu_perbaikan_user') ?>">Perbaikan</a>
                        <a class="collapse-item" href="<?= base_url('Home/rambu_perencanaan_user') ?>">Rencana</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengaman"
                    aria-expanded="true" aria-controls="collapsePengaman">

                    <span>Pengaman jalan</span>
                </a>
                <div id="collapsePengaman" class="collapse" aria-labelledby="headingPengaman"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('Home/pengaman_eksisting_user') ?>">Eksisting</a>
                        <a class="collapse-item" href="<?= base_url('Home/pengaman_perbaikan_user') ?>">Perbaikan</a>
                        <a class="collapse-item" href="<?= base_url('Home/pengaman_perencanaan_user') ?>">Rencana</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengendali"
                    aria-expanded="true" aria-controls="collapsePengendali">

                    <span>Pengendali Pemakai Jalan</span>
                </a>
                <div id="collapsePengendali" class="collapse" aria-labelledby="headingPengendali"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('Home/pengendali_eksisting_user') ?>">Eksisting</a>
                        <a class="collapse-item" href="<?= base_url('Home/pengendali_perbaikan_user') ?>">Perbaikan</a>
                        <a class="collapse-item" href="<?= base_url('Home/pengendali_perencanaan_user') ?>">Rencana</a>
                    </div>
                </div>
            </li>           

           

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="topbar-text">SISTEM INFORMASI GEOGRAFIS PERLENGKAPAN JALAN KABUPATEN SERANG</div>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <div class="nav_account btn_demo3">
                        <a href="tel:(0254) 280529"
                            class="btn btn_sm_primary border-0 sweep_letter sweep_top bg-blue-dishub c-white rounded-pill">
                            <div class="inside_item">
                                <span data-hover="Call us 👋">(0254) 280529</span>
                            </div>
                        </a>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="nav_account btn_demo3">
                            <?php if (session()->get('isLoggedIn')): ?>
                                <li class="nav-item nav_account dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span
                                            class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo session('role') ?></span>
                                        <img class="img-profile rounded-circle"
                                            src="<?= base_url('images/profile.svg'); ?>">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                        aria-labelledby="userDropdown">
                                        <a href="<?= base_url('Auth/logout') ?>" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Logout
                                        </a>
                                    </div>
                                </li>
                            <?php else: ?>
                                <a href="<?= site_url('DataPelaporan/inputPelaporan') ?>" class="btn btn-danger  border-0 sweep_letter sweep_top bg-blue-dishub c-white rounded-pill">
                                    + Laporkan/Pengaduan
                                </a>

                                <a href="<?= base_url('Home/loginForm') ?>"
                                    class="btn btn-primary border-0 sweep_letter sweep_top bg-blue-dishub c-white rounded-pill">
                                    <div class="inside_item">
                                        <span data-hover="Call us 👋">Login</span>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>




                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->

                    <?php if ($page) {
                        echo view($page);
                    } ?>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="col-12 text-center padding-t-4">
                    <div class="copyright">
                        <span>
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());

                            </script>
                            - Dinas Perhubungan - Kabupaten Serang. All rights
                            reserved.
                        </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('sb-admin') ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('sb-admin') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('sb-admin') ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('sb-admin') ?>/js/sb-admin-2.min.js"></script>

    </script>
</body>

</html>