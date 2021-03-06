<?php $user = $this->request->session()->read('Auth.User'); ?>

<div class="container">
    <!-- Section contains all projects and posts on programming languages -->
    <section id="content-1-9" class="content-1-9 content-block" style="padding-bottom: 10px;">
        <!-- Section title -->
        <div class="container">
            <div class="underlined-title">
                <h1><?= count($posts).(count($posts) < 2 ? ' Post' : ' Posts'); ?> found for <?= $data['form_id'] ? $data['month'].'-'.$yearField[$data['year']] : '"'.$data['keyword'].'"'; ?></h1>
                <hr>
            </div>
        </div>
        <!-- End section title -->

        <div class="row">
            <?php if (!$posts) { ?>
                <h3>Oops! No result matches your search. Please try again!</h3>
            <?php } else { foreach ($posts as $post): ?>
                <div class="col-md-6 col-sm-6 col-xs-12" style="margin-bottom: 45px;">
                    <div class="header" style="margin-bottom: 5px;">
                        <b style="font-size: 1.4em;"><?= $user ? '#'.$post['id'].': ' : ''; ?><?= $post['ptitle']; ?></b>
                        <span class="label <?= $post['status'] == 1 ? 'label-success' : ($post['status'] == 2 ? 'label-warning' : 'label-info'); ?> pull-right">
                            <?= $post['status'] == 1 ? 'Completed' : ($post['status'] == 2 ? 'Proposed' : 'Progressing'); ?>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-3"><?= $this->Html->image($post['photo'], ['class' => 'img-responsive', 'style' => 'border: 1px groove #3498DB; border-radius: 7px;']); ?></div>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <ul class="list-group list-group-flush" style="margin-bottom: 0;">
                                <li class="list-group-item">Posted on: <b class="pull-right"><?= (new DateTime($post['created_on']))->format('d/m/Y H:i'); ?></b></li>
                                <li class="list-group-item">Type:
                                    <div class="pull-right">
                                        <?php $viewType = 0; foreach ($categoriesByPost[$post['id']] as $category):
                                            if ($category['main']) {
                                                $viewType = ($category['type'] == 2 ? 1 : 0);
                                                echo '<a data-toggle="tooltip" title="'.$category['ctitle'].'" style="margin-right: 5px;"><i class="'.$category['cdesc'].' fa-2x"></i></a>';
                                            } else
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
                            <?= $this->Html->link('Open', ['action' => ($viewType ? 'othersView' : 'view'), $post['id']], ['class' => 'btn btn-outline btn-outline-sm outline-dark']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; } ?>
        </div>
    </section>
</div>
