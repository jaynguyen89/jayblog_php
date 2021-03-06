<?php $user = $this->request->session()->read('Auth.User'); ?>

<div class="container">
    <!-- Breadcrumb navigation pane
    <ul class="breadcrumb">
        <li><?= $this->Html->link('Home', '/'); ?></li>
        <li>Posts</li>
        <li><?= $this->Html->link('Android Applications', ['controller' => 'Posts', 'action' => 'androidProject']); ?></li>
    </ul>
    End breadcrumb -->

    <!-- Section contains all projects and posts on programming languages -->
    <section id="content-1-9" class="content-1-9 content-block" style="padding-bottom: 10px;">
        <!-- Section title -->
        <div class="container">
            <div class="underlined-title">
                <h1>Posts: My Projects</h1>
                <hr>
                <p class="lead">Section contains Jay's researches and practices on various kinds of Projects.</p>
            </div>
        </div>
        <!-- End section title -->

        <div class="row">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 45px;">
                    <div class="header" style="margin-bottom: 5px;">
                        <b style="font-size: 1.4em;"><?= $user ? '#'.$post['id'].': ' : ''; ?><?= $post['ptitle']; ?></b>
                        <span class="label <?= $post['status'] == 0 ? 'label-success' : ($post['status'] == 2 ? 'label-warning' : 'label-info'); ?> pull-right">
                            <?= $post['status'] == 0 ? 'Completed' : ($post['status'] == 2 ? 'Proposed' : 'Progressing'); ?>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-3"><?= $this->Html->image($post['photo'], ['class' => 'img-responsive', 'style' => 'border: 1px groove #3498DB; border-radius: 7px;']); ?></div>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <ul class="list-group list-group-flush" style="margin-bottom: 0;">
                                <li class="list-group-item">Posted on: <b class="pull-right"><?= (new DateTime($post['created_on']))->format('d/m/Y H:i'); ?></b></li>
                                <li class="list-group-item">Type:
                                    <div class="pull-right">
                                        <?php foreach ($categoriesByPost[$post['id']] as $category):
                                            if ($category['main'])
                                                echo '<a data-toggle="tooltip" title="'.$category['ctitle'].'" style="margin-right: 5px;"><i class="'.$category['cdesc'].' fa-2x"></i></a>';
                                            else
                                                echo '<a data-toggle="tooltip" title="'.$category['ctitle'].'"><i class="'.$category['cdesc'].' fa-2x" style="color: gray; margin-right: 5px;" onmouseover="this.style.color=\'dimgray\'" onmouseout="this.style.color=\'gray\'"></i></a>';
                                        endforeach; ?>
                                    </div>
                                </li>
                            </ul>
                            <p class="small"><?= $post['note'] ? $post['note'] : 'N/A'; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 col-xs-9"><?= $post['pdesc']; ?></div>
                        <div class="col-sm-3 col-xs-3">
                            <?= $this->Html->link('Open', ['action' => 'view', $post['id']], ['class' => 'btn btn-outline btn-outline-sm outline-dark']); ?>
                        </div>
                    </div>
                </div>

                <!-- JS code that is called when suggest link is clicked -->
                <script type="text/javascript">
                    function passDataToSuggestFeatureForm<?= $post['id']; ?>() {
                        var postIdInput = document.getElementById('postIdInput');
                        postIdInput.value = '<?= $post['id']; ?>';

                        var postTitleInput = document.getElementById('postTitleInput');
                        postTitleInput.value = '<?= $post['ptitle']; ?>';
                    }
                </script>
                <!-- End JS -->
            <?php endforeach; ?>
        </div>
    </section>
</div>
