<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-grey-800"><?php echo $title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="post" action="<?php echo base_url('admin/semestermahasiswa/update_data_aksi') ?>">
                <input type="hidden" name="id_maha" value="<?php echo $mahasiswa->id_maha ?>">
                <div class="form-group">
                    <label>Mahasiswa</label>
                    <select name="id_admin" class="form-control">
                        <option value="">Pilih Mahasiswa</option>
                        <?php foreach ($admin as $a) : ?>
                            <option value="<?php echo $a->id_admin ?>" <?php echo ($mahasiswa->id_admin == $a->id_admin) ? 'selected' : '' ?>><?php echo $a->nama_admin ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo form_error('id_admin', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label>Semester</label>
                    <select name="id_semester" class="form-control">
                        <option value="">Pilih Semester</option>
                        <?php foreach ($semester as $s) : ?>
                            <option value="<?php echo $s->id_semester ?>" <?php echo ($mahasiswa->id_semester == $s->id_semester) ? 'selected' : '' ?>><?php echo $s->semester ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo form_error('id_semester', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?php echo base_url('admin/semestermahasiswa') ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
