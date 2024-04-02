
<div class="container-fluid"> 

<div class="d-sm-flex align-items-center justify-content-between mb-4"> 
<h1 class="h3 mb-0 text-grey-800"> <?php echo $title ?> </h1>
</div>

<a class="btn btn-sm btn-success mb-3" href="<?php echo base_url('admin/Mata_Kuliah/tambah_data')?>"> <i class="fas fa-plus"></i> Tambah Data</a>
<!-- <a class="btn btn-sm btn-success mb-3" href="<?php echo base_url('admin/Mata_Kuliah/tambah')?>"> <i class="fas fa-book"></i> Pilih File</a> -->
<a class="btn btn-sm btn-info mb-3" href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#uploadModal">
    <i class="fas fa-file-upload"></i> Upload Data
</a>
<a href="<?php echo base_url('admin/Mata_Kuliah/Kosongkan_tabel') ?>" class="btn btn-sm btn-danger mb-3">
                <i class="fas fa-trash-alt"></i> Kosongkan Tabel
            </a>
<?php echo $this->session->flashdata('pesan') ?>

<div class="table-responsive">
<table  id="data-tabel" class="table table-bordered mt-2" width="100%" >
<thead>
<tr class="text-center" >
<th>No</th>
<th>Nama Mata Kuliah</th>
<th>Semester</th>
<th>Dosen</th>
<th>Aksi</th>

</tr>
</thead>
<tbody>

<?php $no=1; foreach($kuliah as $b) : ?>
<tr>
<td class="text-center"> <?php  echo $no++ ?> </td>
<td class="text-center"> <?php echo $b->nama_mata_kuliah ?></td>
<td class="text-center"> <?php echo $b->semester ?></td>
<?php if ($b->dosen != null): ?>
    <td class="text-center"> <?php echo $b->dosen ?></td>
<?php else: ?>
     <td class="text-center"> <?php echo $b->nama ?></td>
<?php endif ?>


<td>
<center>
           <a onclick="return confirm ('Apakah Anda yakin menghapus ini?')" class="btn btn-sm btn-danger" href="<?php echo base_url('admin/Mata_Kuliah/delete_data/'.$b->id_mata_kuliah)?>"> <i class="fas fa-trash"></i></a>
</center>
</td>
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
            <form action="<?php echo base_url('admin/Mata_Kuliah/upload_data') ?>" method="post" enctype="multipart/form-data">
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





