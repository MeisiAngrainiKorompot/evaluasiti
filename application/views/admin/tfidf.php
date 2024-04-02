<div class="container-fluid">
    <div class="d-sm-flex align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
        <div class="ml-auto d-flex justify-content-between">
            <a href="<?php echo base_url('admin/tfidf/process_tfidf') ?>" class="btn btn-sm btn-success">
                <i class="fas fa-file-alt"></i> Process TF-IDF
            </a>
            <form method="POST" action="<?php echo base_url('admin/tfidf/create_knn_model') ?>">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Create Model</button>
            </form>
        </div>
    </div>

    <?php echo $this->session->flashdata('pesan') ?>

    <h2>Data Training</h2>
    <div class="table-responsive">
        <table id="data-tabel" class="table table-bordered mt-2" width="100%">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Document</th>
                    <th>Sentiment</th>
                    <th>TF-IDF</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($training as $b) : ?>
                <tr>
                    <td class="text-center"><?php echo $no++ ?></td>
                    <td><?php echo $b->document ?></td>
                    <td class="text-center"><?php echo $b->sentiment ?></td>
                    <td><?php echo $b->tfidf ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2>Data Testing</h2>
    <div class="table-responsive">
        <table id="data-tabel-2" class="table table-bordered mt-2" width="100%">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Document</th>
                    <th>Sentiment</th>
                    <th>TF-IDF</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($testing as $b) : ?>
                <tr>
                    <td class="text-center"><?php echo $no++ ?></td>
                    <td><?php echo $b->document ?></td>
                    <td class="text-center"><?php echo $b->sentiment ?></td>
                    <td><?php echo $b->tfidf ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
