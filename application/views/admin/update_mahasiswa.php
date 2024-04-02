

<div class="container-fluid">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <?php echo $title ?> </h1>
</div>
</div>


<div class="card"   style="width: 60%; margin-bottom: 100px">

<div class="card-body">  <?php foreach ($admin as $a): ?>
<form method="POST" action="<?php echo  base_url ('admin/mahasiswa/update_data_aksi')?>" enctype="multipart/form-data">

<div class="form-group">
<label> Nama Mahasiswa </label> 
<input type="hidden" name="id_admin" class="form-control" value="<?php echo $a->id_admin  ?>">
<input type="text" name="nama_admin" class="form-control" autocomplete="off" value="<?php echo $a->nama_admin  ?>">

<?php echo form_error('nama_admin', '<div class="text-small text-danger"></div>') ?>
</div>
<div class="form-group">
<label> Username </label>
<input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $a->username  ?>">

<?php echo form_error('username', '<div class="text-small text-danger"></div>') ?>
</div>
<div class="form-group">
<label> Password</label>
<input type="password" name="password" class="form-control" autocomplete="off" value="<?php echo $a->password  ?>">

<?php echo form_error('password', '<div class="text-small text-danger"></div>') ?>
</div>
<div class="form-group">
<label>Semester</label>
<select name="id_semester" class="form-control">
    <option value="">Pilih Semester</option>
    <?php foreach ($semester as $s) : ?>
        <option value="<?php echo $s->id_semester ?>"><?php echo $s->semester ?></option>
    <?php endforeach; ?>
</select>
<?php echo form_error('id_semester', '<small class="text-danger">', '</small>'); ?>
</div>



<button type="submit" class="btn btn-success mb-5">Simpan</button>


</form> <?php endforeach; ?>
</div>
   
</div>