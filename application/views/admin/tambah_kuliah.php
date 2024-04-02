

<div class="container-fluid">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <?php echo $title ?> </h1>
</div>
</div>


<div class="card"   style="width: 60%; margin-bottom: 100px">

<div class="card-body">
<form method="POST" action="<?php echo  base_url ('admin/Mata_Kuliah/tambah_data_aksi')?>" enctype="multipart/form-data">

<div class="form-group">
<label> Mata Kuliah </label>
<input type="text" name="nama_mata_kuliah" class="form-control" autocomplete="off" autofocus>

<?php echo form_error('nama_mata_kuliah', '<div class="text-small text-danger"></div>') ?>
</div>
<div class="form-group">
<label> Semester</label>
<select name="semester" class="form-control">
    <option value="">--Pilih Semester--</option>
  <?php foreach ($semester as $r): ?>
    <option value="<?php echo $r->id_semester?>"><?php echo $r->semester?></option>
    <?php endforeach; ?>
</select>         

<?php echo form_error('semester', '<div class="text-small text-danger"></div>') ?>
</div>
<div class="form-group">
<label> Nama Dosen</label>
<select name="dosen" class="form-control">
    <option value="">--Pilih Dosen--</option>
  <?php foreach ($dosen as $b): ?>
    <option value="<?php echo $b->id_dosen?>"><?php echo $b->nama?></option>
    <?php endforeach; ?>
</select>         

<?php echo form_error('dosen', '<div class="text-small text-danger"></div>') ?>
</div>

<button type="submit" class="btn btn-success mb-5">Simpan</button>


</form>
</div>
   
</div>