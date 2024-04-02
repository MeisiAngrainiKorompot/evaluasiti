<div class="container-fluid">
    <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-grey-800"><?php echo $title ?></h1>
        <div class="ml-auto">
            
            <a href="<?php echo base_url('admin/labeling/labeling') ?>" class="btn btn-sm btn-success mr-2">
                <i class="fas fa-tags"></i> Labeling Otomatis
            </a>
            
            <a href="<?php echo base_url('admin/evaluasi/split_data') ?>" class="btn btn-sm btn-warning mr-2">
                <i class="fas fa-exchange-alt"></i> Split Data
            </a>
        </div>
    </div>

    <?php echo $this->session->flashdata('pesan') ?>

    <div class="table-responsive">
        <table id="example" id="data-tabel" class="table table-bordered mt-2" width="100%">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Semester</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Ulasan</th>
                    <th>Sentiment</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($training as $b) : ?>
                <tr>
                    <td class="text-center"><?php echo $no++ ?></td>
                    <td class="text-center"><?php echo $b->semester++ ?></td>
                    <td class="text-center"><?php echo $b->mata_kuliah ?></td>
                    <td class="text-center"><?php echo $b->nama_dosen ?></td>
                    <td class="text-center"><?php echo $b->ulasan?></td>
                    <td class="text-center"><?php echo $b->sentiment?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Upload Data -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url('admin/evaluasi/upload_data') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file_upload">Pilih file CSV atau Excel</label>
                        <input type="file" class="form-control-file" id="file_upload" name="file_upload">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

