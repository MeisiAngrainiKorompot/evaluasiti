

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> <?php echo $title ?> </h1>
                    </div>
                </div>
              

    <div class="card"   style="width: 60%; margin-bottom: 100px">
        
        <div class="card-body">

            <?php foreach ($barang as $b): ?>

            <form method="POST" action="<?php echo  base_url ('admin/Inventaris/update_data_aksi')?>" enctype="multipart/form-data">

                <div class="form-group">
                    <label> Nama Barang </label>
                    <input type="hidden" name="id_barang" class="form-control" value="<?php echo $b->id_barang  ?>">
                    <input type="text" name="nama_barang" class="form-control" value="<?php echo $b->nama_barang ?>" autofocus>

                    <?php echo form_error('nama_barang', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Merk Tipe</label>
                    <input type="text" name="merk_tipe" class="form-control" value="<?php echo $b->merk_tipe ?>">

                    <?php echo form_error('merk_tipe', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Kodefikasi</label>
                    <input type="text" name="kodefikasi" class="form-control" value="<?php echo $b->kodefikasi ?>">

                    <?php echo form_error('kodefikasi', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Tahun</label>
                    <input type="text" name="tahun" class="form-control" value="<?php echo $b->tahun ?>">

                    <?php echo form_error('tahun', '<div class="text-small text-danger"></div>') ?>
                </div>
  
                <div class="form-group">
                    <label> Ruangan</label>
                    <input type="text" name="ruangan" class="form-control" value="<?php echo $b->ruangan?>">

                    <?php echo form_error('ruangan', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Jumlah</label>
                    <input type="text" name="jumlah" class="form-control" value="<?php echo $b->jumlah ?>">

                    <?php echo form_error('jumlah', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" value="<?php echo $b->keterangan?>">

                    <?php echo form_error('keterangan', '<div class="text-small text-danger"></div>') ?>
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