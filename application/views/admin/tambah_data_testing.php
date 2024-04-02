

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> <?php echo $title ?> </h1>
                    </div>
                </div>
              

    <div class="card"   style="width: 60%; margin-bottom: 100px">
        
        <div class="card-body">
            <form method="POST" action="<?php echo  base_url ('admin/data_testing/tambah_data_aksi')?>" enctype="multipart/form-data">

                <div class="form-group">
                    <label> Document </label>
                    <input type="text" name="document" class="form-control" autocomplete="off" autofocus>

                    <?php echo form_error('document', '<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group">
                    <label> Aspek </label>
                    <input type="text" name="aspek" class="form-control" autocomplete="off" autofocus>

                    <?php echo form_error('aspek', '<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group">
                    <label> Klasifikasi_Manual</label>
                   <select name="klasifikasi_manual" class="form-control">
                        <option value="">--Pilih Sentiment Berita--</option>
                        <option>Netral</option>
                        <option>Positif</option>
                        <option>Negatif</option>
                     
                    </select>         

                    <?php echo form_error('klasifikasi_manual', '<div class="text-small text-danger"></div>') ?>
                </div>

                 
                <button type="submit" class="btn btn-success mb-5">Simpan</button>
                

            </form>
    </div>
                       
 </div> 