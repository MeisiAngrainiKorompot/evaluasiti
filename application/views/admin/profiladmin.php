
                <div class="container-fluid"> 

                    <div class="d-sm-flex align-items-center justify-content-between mb-4"> 
                    <h1 class="h3 mb-0 text-black-800"> <?php echo $title ?> </h1>
                </div>


         <a class="btn btn-sm btn-primary mb-3" href="<?php echo base_url('admin/profil/tambah_admin')?>"> <i class="fas fa-plus"></i> Tambah Data</a>
        <?php echo $this->session->flashdata('pesan') ?>

<table  class="table table-bordered table-striped  mt-2" width="100%" >
<thead>
    <table  id="data-tabel" class="table table-bordered mt-2" width="100%" >
<thead>
    <tr class="text-center">
        <th>No</th>
        <th>Nama Admin</th>
        <th>Username</th>
        <th>Password</th>
        <th>Hak Akses</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    
            <?php $no=1; foreach($admin as $a) : ?>
    <tr>
        <td class="text-center"> <?php  echo $no++ ?> </td>
        <td> <?php echo $a->nama_admin ?></td>
        <td> <?php echo $a->username ?></td>
        <td> <?php echo $a->password ?></td>
        <td> <?php echo $a->hak_akses ?></td>
        <td>
             <center>
                <a class="btn btn-sm btn-primary" href="<?php echo base_url('admin/profil/update_data/'.$a->id_admin)?>"> <i class="fas fa-edit"></i></a>
                <a onclick="return confirm ('Apakah Anda yakin menghapus ini?')" class="btn btn-sm btn-danger" href="<?php echo base_url('admin/profil/delete_data/'.$a->id_admin)?>"> <i class="fas fa-trash"></i></a>
            </center>
        </td>
    </tr>


            <?php endforeach; ?>
        
</tbody>
</table>
</div>



              

    