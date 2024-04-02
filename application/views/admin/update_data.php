

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> <?php echo $title ?> </h1>
                    </div>
                </div>
              

    <div class="card"   style="width: 60%; margin-bottom: 100px">
        
        <div class="card-body">

            <?php foreach ($admin as $a): ?>
                
            <form method="POST" action="<?php echo  base_url ('admin/profil/update_data_aksi')?>" enctype="multipart/form-data">

                <div class="form-group">
                    <label> Nama </label>
                    <input type="hidden" name="id_admin" class="form-control" value="<?php echo $a->id_admin  ?>">
                    <input type="text" name="nama_admin" class="form-control" value="<?php echo $a->nama_admin ?>" autofocus>

                    <?php echo form_error('nama_admin', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $a->username ?>">

                    <?php echo form_error('username', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Password</label>
                    <input type="text" name="password" class="form-control" value="<?php echo $a->password ?>">

                    <?php echo form_error('password', '<div class="text-small text-danger"></div>') ?>
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