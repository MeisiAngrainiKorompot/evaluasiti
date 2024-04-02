<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <img src="<?php echo base_url ('./assets/img/logo.png')?>" width = "65px">
            <div> TEKNIK INFORMATIKA</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item ">
                <a class="nav-link" href="<?php echo base_url('admin/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a>
            </li>


            <!-- Nav Item - Pages Collapse Menu -->
            
                    <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Master Data</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/Mata_Kuliah') ?>">Mata Kuliah</a>
                    </div>
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/dosen') ?>">Nama Dosen</a>
                   
                    </div>
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/mahasiswa') ?>">Data Mahasiswa</a>
                    </div>
                    <!-- <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/semestermahasiswa') ?>">Semester Mahasiswa</a>
                    </div> -->
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/profil') ?>">Profil</a>
                    </div>      
                         
                
            </li>

                <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-database"></i><span>Proses Data</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/evaluasi') ?>">Data Evaluasi</a>
                    </div>

                    <?php if (empty($eval->result())) { ?>
                    <?php } else { ?>
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/evaluasi/cleaning') ?>">Cleaning & Casefolding</a>
                    </div>
                    <?php } ?>
                    <?php if (empty($clean->result())) { ?>
                    <?php } else { ?>
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/evaluasi/stopwords') ?>">Stopwords Removal</a>
                    </div>
                    <?php } ?>
                    <?php if (empty($stop->result())) { ?>
                    <?php } else { ?>
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/evaluasi/stemmings') ?>">Stemming</a>
                    </div>

                    <?php } ?>
                    <?php if (empty($stem->result())) { ?>
                    <?php } else { ?>
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/labeling') ?>">Labeling</a>
                    </div>
                    <?php } ?>
                    <?php if (empty($label->result())) { ?>
                    <?php } else { ?>
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/tfidf') ?>">TF-IDF</a>
                    </div>
                    <?php } ?>
                    <?php if (empty($tfidf->result())) { ?>
                    <?php } else { ?>
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/tfidf/vocab') ?>">Freq Data Vocab</a>
                    </div>
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/Data_Training') ?>">Data Training</a>
                    </div>
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?php echo base_url('admin/Data_Testing') ?>">Data Testing</a>
                    </div>
                    <?php } ?>



                </div>
            </li>

            
            
            <?php if (empty($train->result())) { ?>
            <?php } else { ?>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin/klasifikasi') ?>">
                   <i class="fas fa-fw fa-id-badge"></i>
                    <span>Hasil Evaluasi</span></a>
            </li>
            <?php } ?>

            
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin/setting') ?>">
                  <i class="fas fa-fw fa-cog"></i>
                    <span>Pengaturan</span></a>
            </li>
          
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('Login') ?>">
                  <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Keluar</span></a>
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

                    <!-- Topbar Search -->
                   

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                       

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Selamat Datang Admin</span>
                            
                            </a>
                           
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
