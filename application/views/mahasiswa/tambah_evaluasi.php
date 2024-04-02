<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
    </div>
</div>

<div class="card" style="width: 60%; margin-bottom: 100px">
    <div class="card-body">
        <form method="POST" action="<?php echo base_url('mahasiswa/evaluasi/tambah_data_aksi') ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_dosen">Nama Dosen</label>
                <select name="nama_dosen" class="form-control" id="nama_dosen" required>
                    <option value="">--Pilih Dosen--</option>
                    <?php foreach ($nama_dosen as $r): ?>
                        <option value="<?php echo $r->id_dosen ?>"><?php echo $r->nama ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('nama_dosen', '<div class="text-small text-danger">', '</div>') ?>
            </div>

            <div class="form-group">
                <label for="mata_kuliah">Nama Mata Kuliah</label>
                <select name="mata_kuliah" class="form-control" id="mata_kuliah" disabled required>
                    <option value="">--Pilih Mata Kuliah--</option>
                </select>
                <?php echo form_error('mata_kuliah', '<div class="text-small text-danger">', '</div>') ?>
            </div>

            <div class="form-group">
                <label> Berikan Tanggapan </label>
                <textarea name="ulasan" class="form-control" autocomplete="off" required></textarea>
                <?php echo form_error('ulasan', '<div class="text-small text-danger"></div>') ?>
            </div>

            <button type="submit" class="btn btn-success mb-5">Simpan</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#nama_dosen').on('change', function() {
            var dosenId = $(this).val();

            $('#mata_kuliah').prop('disabled', true);
            $('#mata_kuliah').html('<option value="">--Pilih Mata Kuliah--</option>');

            if (dosenId !== '') {
                $.ajax({
                    url: '<?php echo base_url("mahasiswa/evaluasi/get_mata_kuliah_by_dosen") ?>',
                    type: 'POST',
                    data: {
                        dosen_id: dosenId
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            $('#mata_kuliah').prop('disabled', false);
                            $.each(data, function(index, value) {
                                $('#mata_kuliah').append('<option value="' + value.id_mata_kuliah + '">' + value.nama_mata_kuliah + '</option>');
                            });
                        }
                    }
                });
            }
        });
    });
</script>
