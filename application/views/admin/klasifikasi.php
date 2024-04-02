<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
    </div>

    
    
    <?php echo $this->session->flashdata('pesan') ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Jumlah Evaluasi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <canvas id="chart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaturan K</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form method="POST" action="<?php echo base_url('admin/klasifikasi/change_k') ?>">
                        <div class="form-group">
                            <label for="kValue">Nilai K</label>
                            <input type="number" class="form-control" id="kValue" name="kValue" value="5" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ubah K</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Classification Report</h6>
                </div>
                <div class="card-body">
                    <pre>Precision <?php echo $precision ?></pre>
                    <pre>Recall <?php echo $recall ?></pre>
                    <pre>F1 Score <?php echo $f1_score ?></pre>
                    <pre>Accuracy <?php echo $accuracy ?></pre>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Confusion Matrix</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Predict Positif</th>
                                <th>Predict Netral</th>
                                <th>Predict Negatif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($confusion_matrix[0] as $actual_label => $row) { ?>
                                <tr>
                                    <th>Actual <?php echo $actual_label ?></th>
                                    <?php foreach ($row as $predicted_label => $value) { ?>
                                        <td><?php echo $value ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Fold</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>K - </th>
                                <th>Accuracy</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fold as $item) { ?>
                                <tr>
                                    <td><?php echo $item['fold'] ?></td>
                                    <td><?php echo $item['accuracy'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik K -</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <canvas id="line-chart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

 
        </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk grafik
    var data = {
        labels: ['Negatif', 'Netral', 'Positif'],
        datasets: [{
            label: 'Jumlah Evaluasi',
            data: [
                <?php echo $jumlah_evaluasi['Negatif'] ?>,
                <?php echo $jumlah_evaluasi['Netral'] ?>,
                <?php echo $jumlah_evaluasi['Positif'] ?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Opsi untuk grafik
    var options = {
        responsive: true,
        maintainAspectRatio: false
    };

    // Membuat grafik
    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: options
    });
</script>
<script>
    // Data untuk grafik line chart pada fold
    var lineChartData = {
        labels: [
            <?php foreach ($fold as $item) { ?>
                "<?php echo $item['fold'] ?>",
            <?php } ?>
        ],
        datasets: [{
            label: 'Akurasi',
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            fill: false,
            data: [
                <?php foreach ($fold as $item) { ?>
                    <?php echo $item['accuracy'] ?>,
                <?php } ?>
            ]
        }]
    };

    // Opsi untuk grafik line chart pada fold
    var lineChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                display: true,
                title: {
                    display: true,
                    text: 'Fold'
                }
            },
            y: {
                display: true,
                title: {
                    display: true,
                    text: 'Akurasi'
                },
                suggestedMin: 0,
                suggestedMax: 1
            }
        }
    };

    // Membuat grafik line chart pada fold
    var lineChartCtx = document.getElementById('line-chart').getContext('2d');
    var lineChart = new Chart(lineChartCtx, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
    });

</script>   
