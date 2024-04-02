<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Vocabulary</h6>
        </div>
        <div class="card-body">
            <?php echo $this->session->flashdata('pesan') ?>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Word Cloud</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="wordCloudCanvas" height="600" width="1100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <?php if (!empty($vocab) && !empty($wordFrequencies)): ?>
                        <p><h3>Total Vocabulary: <?php echo count($vocab) ?></h3></p>
                        <h5>Vocabulary and Word Frequencies:</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered"  id="data-tabel"  width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Word</th>
                                        <th>Frequency</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($wordFrequencies as $word => $frequency): ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $word ?></td>
                                            <td><?php echo isset($wordFrequencies[$word]) ? $wordFrequencies[$word] : 0 ?></td>
                                        </tr>
                                    <?php $i++; endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="<?php echo base_url('assets/wordcloud/src/wordcloud2.js'); ?>"></script>
    <script>
        window.onload = () => {
            var vocab = <?php echo json_encode($vocab); ?>;
            var wordFrequencies = <?php echo json_encode($wordFrequencies); ?>;

            var words = vocab.map((word, index) => {
                return { text: word, size: wordFrequencies[word] };
            });

            WordCloud(document.getElementById('wordCloudCanvas'), {
                list: words.map((d) => [d.text, d.size]),
                drawOutOfBound: false,
                shrinkToFit: true,
            });
        };
    </script>
