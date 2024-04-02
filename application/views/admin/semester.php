<div class="container-fluid"> 
    <div class="d-sm-flex align-items-center justify-content-between mb-4"> 
        <h1 class="h3 mb-0 text-grey-800"><?php echo $title ?></h1>
    </div>

    <a class="btn btn-sm btn-info mb-3" href="<?php echo base_url('admin/semestermahasiswa/tambah_data')?>"><i class="fas fa-plus"></i> Tambah Data</a>
    <?php echo $this->session->flashdata('pesan') ?>

    <div class="table-responsive">
        <table id="data-tabel" class="table table-bordered mt-2" width="100%">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Semester</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($mahasiswa as $m) : ?>
                <tr>
                    <td class="text-center"><?php echo $no++ ?></td>
                    <td class="text-center"><?php echo $m->nama_admin ?></td>
                    <td class="text-center"><?php echo $m->semester ?></td>
                    <td>
                        <center>
                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('admin/semestermahasiswa/update_data/'.$m->id_maha)?>"><i class="fas fa-edit"></i></a>
                            <a onclick="return confirm('Apakah Anda yakin menghapus ini?')" class="btn btn-sm btn-danger" href="<?php echo base_url('admin/semestermahasiswa/delete_data/'.$m->id_maha)?>"><i class="fas fa-trash"></i></a>
                        </center>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
