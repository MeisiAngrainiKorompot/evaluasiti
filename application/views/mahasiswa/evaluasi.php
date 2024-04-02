
                <div class="container-fluid"> 

                    <div class="d-sm-flex align-items-center justify-content-between mb-4"> 
                    <h1 class="h3 mb-0 text-grey-800"> <?php echo $title ?> </h1>
                </div>

         <a class="btn btn-sm btn-primary mb-3" href="<?php echo base_url('mahasiswa/evaluasi/tambah_data')?>"> <i class="fas fa-plus"></i> evaluasi</a>
        <?php echo $this->session->flashdata('pesan') ?>

<div class="table-responsive">
<table  id="data-tabel" class="table table-bordered mt-2" width="100%" >
<thead>
    <tr class="text-center" >
        <th>No</th>
        <th>Semester</th>
        <th>Mata Kuliah</th>
        <th>Id Dosen</th>
        <th>Ulasan</th>
        
        
    </tr>
</thead>
<tbody>
    
            <?php $no=1; foreach($evaluasi as $b) : ?>
            <tr>
                <td class="text-center"> <?php  echo $no++ ?> </td>
                <td class="text-center"> <?php  echo $b->semester++ ?> </td>
                <td class="text-center"> <?php echo $b->mata_kuliah ?></td>
                <td class="text-center"> <?php echo $b->nama_dosen?></td>
                <td class="text-center"> <?php echo $b->ulasan?></td>
            </tr>


      

             <?php endforeach; ?>
        
</tbody>
</table>
</div>
</div>



              

    