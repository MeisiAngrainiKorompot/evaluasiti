
                <div class="container-fluid"> 

                    <div class="d-sm-flex align-items-center justify-content-between mb-4"> 
                    <h1 class="h3 mb-0 text-grey-800"> <?php echo $title ?> </h1>
                </div>


<div class="table-responsive">
<table  id="example" class="table table-bordered  mt-2" width="100%" >
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
    </tr>


            <?php endforeach; ?>
        
</tbody>
</table>
</div>
</div>



              

    