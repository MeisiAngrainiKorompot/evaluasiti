

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> <?php echo $title ?> </h1>
                    </div>
                </div>
              

    <div class="card"   style="width: 60%; margin-bottom: 100px">
        
        <div class="card-body">
            <form method="POST" action="<?php echo  base_url ('admin/dosen/upload')?>" enctype="multipart/form-data">

                <div class="form-group">
                    <label> Nama </label>
                    <input type="file" name="userfile" class="form-control" autocomplete="off" autofocus>

                    <?php echo form_error('nama_admin', '<div class="text-small text-danger"></div>') ?>
                </div>

               

                 
                <button type="submit" class="btn btn-success mb-5">Simpan</button>
                

            </form>
    </div>
                       
 </div>