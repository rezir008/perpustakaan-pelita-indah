<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <?php if($this->session->userdata('username')){?>
                <li class="nav-item">
                    <a class="collapsed sidebar-brand d-flex align-items-center justify-content-center" href="#" data-toggle="collapse" data-target="#collapseUser"
                        aria-expanded="true" aria-controls="collapseUser">
                            <div class="sidebar-brand-icon"> <i class="fas fa-user"></i> </div>
                            <div class="sidebar-brand-text mx-1"><small> Admin</small> <br> <?php echo $this->session->userdata('username') ?></div>
                    </a>
                    <div id="collapseUser" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item text-wrap " href="<?php echo base_url('auth/edit') ?>">Edit Akun User</a>
                            <a class="collapse-item text-wrap " href="<?php echo base_url('auth/logout') ?>">Logout</a>
                            
                        </div>
                    </div>
                </li>
            <?php }else{ ?>
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('auth/login') ?>">
                    <div class="sidebar-brand-icon ">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">Login</div>
                </a>
            <?php } ?>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('dashboard_admin'); ?>">
                    <i class="fas fa-fw fa-book-open"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Laporan Peminjaman</span>
                </a>
                <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item text-wrap " href="<?php echo base_url('dashboard_admin')?>">Semua Peminjaman</a>
                        <hr>
                        <a class="collapse-item text-wrap " href="<?php echo base_url('dashboard_admin/laporan/'.'1')?>">Peminjaman Harian</a>
                        <a class="collapse-item text-wrap " href="<?php echo base_url('dashboard_admin/laporan/'.'2')?>">Peminjaman Mingguan</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">


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
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <div class="Navbar-text ">
                            <div class="row ">
                                <div class="col">
                                    <h1><i class="fas fa-book-open"></i></h1>
                                </div>
                                <div class="col">
                                    <div class="row">Perpustakaan</div>
                                    <div class="row text-uppercase text-nowrap"><strong>Pelita Ilmu</strong></div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </nav>
                <!-- End of Topbar -->