<div class="container-fluid"> 
    <div class="d-sm-flex align-items-center justify-content-between mb-4"> 
        <h1 class="h3 mb-0 text-grey-800"> <?php echo $title ?> </h1>
        <a href="<?php echo base_url('admin/Data_Testing/empty_data_testing') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus isi tabel?')">Empty Tables</a>
    </div>

    <?php echo $this->session->flashdata('pesan') ?>

    <div class="table-responsive">
        <table id="data-tabel" class="table table-bordered mt-2" width="100%">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Document</th>
                    <th>sentiment</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($testing as $b) : ?>
                    <tr>
                        <td class="text-center"> <?php echo $no++ ?> </td>
                        <td class="text-center"> <?php echo $b->document ?></td>
                        <td class="text-center"> <?php echo $b->sentiment ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

