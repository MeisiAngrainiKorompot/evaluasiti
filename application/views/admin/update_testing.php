

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> <?php echo $title ?> </h1>
                    </div>
                </div>
              

    <div class="card"   style="width: 60%; margin-bottom: 100px">
        
        <div class="card-body">

            <?php foreach ($testing as $a): ?>
                
            <form method="POST" action="<?php echo  base_url ('admin/data_testing/update_data_aksi')?>" enctype="multipart/form-data">

                <div class="form-group">
                    <label> Document </label>
                    <input type="hidden" name="id_data_testing" class="form-control" value="<?php echo $a->id_data_testing  ?>">
                    <input type="text" name="document" class="form-control" value="<?php echo $a->document ?>" autofocus>

                    <?php echo form_error('document', '<div class="text-small text-danger"></div>') ?>
                </div>

                <label> Aspek </label>
                    <input type="hidden" name="id_data_testing" class="form-control" value="<?php echo $a->id_data_testing  ?>">
                    <input type="text" name="aspek" class="form-control" value="<?php echo $a->aspek ?>" autofocus>

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


                <button type="submit" class="btn btn-primary mb-5">Update</button>
                

            </form>
            <?php endforeach; ?>
    </div>
 <div class="row">
                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">
                        </div>
                        
                    </div>
                </div>