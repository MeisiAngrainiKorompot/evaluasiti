

<div class="container-fluid">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <?php echo $title ?> </h1>
</div>
</div>


<div class="card"   style="width: 60%; margin-bottom: 100px">

<div class="card-body">

<?php foreach ($kuliah as $a): ?>

<form method="POST" action="<?php echo  base_url ('admin/mata_kuliah/update_data_aksi')?>" enctype="multipart/form-data">

<div class="form-group">
<label> Mata Kuliah </label>
<input type="hidden" name="id_mata_kuliah" class="form-control" value="<?php echo $a->id_mata_kuliah ?>">
<input type="text" name="nama_mata_kuliah" class="form-control" value="<?php echo $a->nama_mata_kuliah ?>" autofocus>

<?php echo form_error('nama_mata_kuliah', '<div class="text-small text-danger"></div>') ?>
</div>
<div class="form-group">
<label for="semester">Semester</label>
<select name="semester" class="form-control">
    <option value="">--Pilih Semester--</option>
    <?php foreach ($semester as $r): ?>
        <?php if ($r->id_semester == $selected_semester): ?>
            <option value="<?php echo $r->id_semester ?>" selected><?php echo $r->semester ?></option>
        <?php else: ?>
            <option value="<?php echo $r->id_semester ?>"><?php echo $r->semester ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>
<?php echo form_error('semester', '<div class="text-small text-danger">', '</div>') ?>
</div>
<div class="form-group">
<label> Dosen</label>
<select name="dosen" class="form-control">
    <option value="">--Pilih Dosen--</option>
    <?php foreach ($dosen as $d): ?>
        <?php if ($r->id_dosen == $selected_dosen): ?>
            <option value="<?php echo $d->id_dosen?>" selected><?php echo $d->nama?></option>
        <?php else: ?>
            <option value="<?php echo $d->id_dosen?>"><?php echo $d->nama?></option>
        <?php endif; ?>
    <?php endforeach; ?>
  
    
</select>         

<?php echo form_error('dosen', '<div class="text-small text-danger"></div>') ?>
</div>

         

<button type="submit" class="btn btn-primary mb-5">Update</button>


</form>
<?php endforeach; ?>
</div>
<div class="row">
    <!-- Content Column -->
    <div class="col-lg-6 mb-4">
    </div>
    <div class="col-lg-6 mb-4">
    </div>
</div>
</div>