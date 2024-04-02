
                <div class="container-fluid"> 

                    <div class="d-sm-flex align-items-center justify-content-between mb-4"> 
                    <h1 class="h3 mb-0 text-grey-800"> <?php echo $title ?> </h1>
                </div>

         <a class="btn btn-sm btn-primary mb-3" href="<?php echo base_url('admin/Inventaris/tambah_data')?>"> <i class="fas fa-plus"></i> Tambah Data</a>
        <?php echo $this->session->flashdata('pesan') ?>

<div class="table-responsive">
<table  id="data-tabel" class="table table-bordered mt-2" width="100%" >
<thead>
    <tr class="text-center" >
        <th>No</th>
        <th>Nama Barang</th>
        <th>Merk/Type</th>
        <th>Kodefikasi</th>
        <th>Tahun</th>
        <th>Ruangan</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
        <th>Aksi</th>
        
    </tr>
</thead>
<tbody>
    
            <?php $no=1; foreach($barang as $b) : ?>
            <tr>
                <td class="text-center"> <?php  echo $no++ ?> </td>
                <td> <?php echo $b->nama_barang ?></td>
                <td class="text-center"> <?php echo $b->merk_tipe ?></td>
                <td class="text-center"> <?php echo $b->kodefikasi ?></td>
                <td class="text-center"> <?php echo $b->tahun ?></td>
                <td class="text-center"> <?php echo $b->ruangan ?></td>
                <td class="text-center"> <?php echo $b->jumlah ?></td>
                <td class="text-center"> <?php echo $b->keterangan ?></td>
           
                <td>
                    <center>
                         <a class="btn btn-sm btn-primary" href="<?php echo base_url('admin/Inventaris/update_data/'.$b->id_barang)?>"> <i class="fas fa-edit"></i></a>
                          <a onclick="return confirm ('Apakah Anda yakin menghapus ini?')" class="btn btn-sm btn-danger" href="<?php echo base_url('admin/inventaris/delete_data/'.$b->id_barang)?>"> <i class="fas fa-trash"></i></a>
                    </center>
                </td>
            </tr>


      

             <?php endforeach; ?>
        
</tbody>
</table>
</div>
</div>



              

    