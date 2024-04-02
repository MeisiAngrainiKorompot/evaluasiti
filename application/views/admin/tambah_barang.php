

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> <?php echo $title ?> </h1>
                    </div>
                </div>
              

    <div class="card"  style="width: 60%; margin-bottom: 100px">
        
        <div class="card-body">
            <form method="POST" action="<?php echo base_url ('admin/Inventaris/tambah_data_aksi')?>" enctype="multipart/form-data">

                <div class="form-group">
                    <label> Nama </label>
                    <input type="text" name="nama_barang" class="form-control" autocomplete="off" autofocus>

                    <?php echo form_error('nama_barang', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Merk Tipe</label>
                    <input type="text" name="merk_tipe" class="form-control" autocomplete="off" autofocus>

                   <?php echo form_error('merk_tipe', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Kodefikasi</label>
                    <input type="text" name="kodefikasi" class="form-control" autocomplete="off" autofocus>

                   <?php echo form_error('kodefikasi', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Tahun</label>
                    <input type="text" name="tahun" class="form-control" autocomplete="off" autofocus>

                    <?php echo form_error('tahun', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Ruangan</label>
                   <select name="ruangan" class="form-control">
                        <option value="">--Pilih Ruangan--</option>
                      <?php foreach ($ruangan as $r): ?>
                        <option value="<?php echo $r->nama_ruangan?>"><?php echo $r->nama_ruangan?></option>
                        <?php endforeach; ?>
                    </select>         

                    <?php echo form_error('ruangan', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Jumlah</label>
                    <input type="text" name="jumlah" class="form-control" autocomplete="off" autofocus>

                    <?php echo form_error('jumlah', '<div class="text-small text-danger"></div>') ?>
                </div>

                <div class="form-group">
                    <label> Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" autocomplete="off" autofocus>

                    <?php echo form_error('keterangan', '<div class="text-small text-danger"></div>') ?>
                </div>

               
                 
                <button type="submit" class="btn btn-success mb-5">Simpan</button>
                

            </form>
    </div>
                       
 </div>