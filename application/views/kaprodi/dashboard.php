<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <!-- Content Row -->
    <div class="row">
        <img src="<?php echo base_url('assets/gambar/meisi.png')?>" class="img-fluid">


        <!-- Data Latih Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Data Latih</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $num_training_data ?></div>
                        </div>
                        <div class="col-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Uji Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Data Uji</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $num_testing_data ?></div>
                        </div>
                        <div class="col-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Dosen Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Dosen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dosen ?></div>
                        </div>
                        <div class="col-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Mata Kuliah Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Mata Kuliah</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $matkul ?></div>
                        </div>
                        <div class="col-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Nama Dosen Card Example -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Nama Dosen yang Paling Banyak</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="dosenChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Mata Kuliah Card Example -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Mata Kuliah yang Paling Banyak</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="matkulChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- JavaScript untuk Grafik Nama Dosen -->
<script>
    var dosenData = <?php echo json_encode($dosenData); ?>;
    var dosenLabels = <?php echo json_encode($dosenLabels); ?>;

    var dosenChart = document.getElementById("dosenChart").getContext('2d');
    new Chart(dosenChart, {
        type: 'bar',
        data: {
            labels: dosenLabels,
            datasets: [{
                label: 'Jumlah',
                data: dosenData,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>

<!-- JavaScript untuk Grafik Mata Kuliah -->
<script>
    var matkulData = <?php echo json_encode($matkulData); ?>;
    var matkulLabels = <?php echo json_encode($matkulLabels); ?>;

    var matkulChart = document.getElementById("matkulChart").getContext('2d');
    new Chart(matkulChart, {
        type: 'bar',
        data: {
            labels: matkulLabels,
            datasets: [{
                label: 'Jumlah',
                data: matkulData,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
