

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> <?php echo $title ?> </h1>
                    </div>
                </div>
              

    <div class="card"   style="width: 60%; margin-bottom: 100px">
        
        <div class="card-body">

            <?php foreach ($dosen as $a): ?>
                
            <form method="POST" action="<?php echo  base_url ('admin/dosen/update_data_aksi')?>" enctype="multipart/form-data">

                <div class="form-group">
                    <label> Nama </label>
                    <input type="hidden" name="id_dosen" class="form-control" value="<?php echo $a->id_dosen  ?>">
                    <input type="text" name="nama" class="form-control" value="<?php echo $a->nama ?>" autofocus>

                    <?php echo form_error('nama', '<div class="text-small text-danger"></div>') ?>
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