<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-grey-800"><?php echo $title ?></h1>
    </div>

    <?php echo $this->session->flashdata('pesan') ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"> Aktifkan Aplikasi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form method="POST" action="<?php echo base_url('admin/setting/change_k') ?>">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aplikasi" id="radio1" value="1" <?php echo ($setting->value == 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="radio1">
                                    Aktif
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aplikasi" id="radio2" value="0" <?php echo ($setting->value == 0) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="radio2">
                                    Non-Aktif
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
