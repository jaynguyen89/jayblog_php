<?php $session = $this->request->session(); ?>

<div class="container">
    <section id="content-1-9" class="content-1-9 content-block" style="padding-bottom: 10px;">
        <!-- Section title -->
        <div class="container">
            <div class="underlined-title">
                <h1><?= $post->title; ?></h1><span class="label label-success">Completed</span>
                <hr>
                <p class="lead"><?= $post->description; ?></p>
            </div>
        </div>
        <!-- End section title -->

        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Photo carousel indicator dots -->
                    <ol class="carousel-indicators">
                        <?php for ($i = 0; $i < count($photos); $i++)
                            echo $i ? '<li data-target="#myCarousel" data-slide-to="'.$i.'"></li>' :
                                      '<li data-target="#myCarousel" data-slide-to="'.$i.'" class="active"></li>'; ?>
                    </ol>
                    <!-- End carousel -->

                    <!-- Carousel photos container -->
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < count($photos); $i++) { ?>
                        <div class="item <?= $i ? '' : 'active'; ?>">
                            <?= $this->Html->image($photos[$i]->file_name, ['alt' => $post->title, 'style' => 'border: 1px groove #3498DB; border-radius: 7px;']); ?>
                            <div class="carousel-caption">
                                <h3 style="font-weight: bold; color: #3498DB;"><?= $photos[$i]->description; ?></h3>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- -->

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Posted on: <b class="pull-right"><?= (new DateTime($post->created_on))->format('d/m/Y H:i'); ?></b></li>
                            <li class="list-group-item">Updated: <b class="pull-right"><?= (new DateTime($post->updated_on))->format('d/m/Y H:i'); ?></b></li>
                            <li class="list-group-item">Task total: <b class="pull-right"><?= $post->task_total; ?></b></li>
                            <li class="list-group-item">Task done: <b class="pull-right"><?= $post->task_done; ?></b></li>
                            <li class="list-group-item">Type:
                                <div class="pull-right">
                                    <?php foreach ($categories as $category):
                                        if ($category['main'])
                                            echo '<a data-toggle="tooltip" title="'.$category->title.'" style="margin-right: 5px;"><i class="'.$category->description.' fa-2x"></i></a>';
                                        else
                                            echo '<a data-toggle="tooltip" title="'.$category->title.'"><i class="'.$category->description.' fa-2x" style="color: gray; margin-right: 5px;" onmouseover="this.style.color=\'dimgray\'" onmouseout="this.style.color=\'gray\'"></i></a>';
                                    endforeach; ?>
                                </div></li>
                            <li class="list-group-item">Up vote: <b><?= $session->read('Post.up_vote'); ?></b>
                                <?= $this->Form->postLink(
                                    $this->Html->tag('i', '', ['class' => 'fas fa-thumbs-up fa-2x pull-right']),
                                    ['controller' => 'votes', 'action' => 'setVotes', '?' => ['pid' => $post->id, 'sign' => 1]],
                                    ['role' => 'button', 'escape' => false, 'confirm' => __('Since no login was required, your IP Address may be recorded. This approach is to prevent visitors voting multiple times on 1 post.\n\nNo personal information will be collected. Your IP Address will be securely encrypted.\n\nContinue to vote up for {0}?', $post->title)]); ?></li>
                            <li class="list-group-item">Down vote: <b><?= $session->read('Post.down_vote'); ?></b>
                                <?= $this->Form->postLink(
                                    $this->Html->tag('i', '', ['class' => 'fas fa-thumbs-down fa-2x pull-right']),
                                    ['controller' => 'votes', 'action' => 'setVotes', '?' => ['pid' => $post->id, 'sign' => 0]],
                                    ['role' => 'button', 'escape' => false, 'confirm' => __('Since no login was required, your IP Address may be recorded. This approach is to prevent visitors voting multiple times on 1 post.\n\nNo personal information will be collected. Your IP Address will be securely encrypted.\n\nContinue to vote down for {0}?', $post->title)]); ?></li>
                        </ul>
                    </div>
                    <div class="col-xs-12">
                        <h5><i class="fas fa-pencil-alt" style="color: #3498DB;"></i> Notes</h5>
                        <p class="small"><?= $post->note ? $this->Text->autoParagraph(h($post->note)) : 'N/A'; ?></p>
                    </div>
                </div>

            </div>
        </div>

        <div class="row" style="margin-top: 15px;">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <h4><i class="fas fa-clipboard" style="color: #3498DB;"></i> Project Description</h4>
                <p class="medium"><?= $this->Text->autoParagraph(h($post->content)); ?></p>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <h4><i class="fas fa-paperclip" style="color: #3498DB;"></i> File Attachments</h4>
                <div class="row">
                    <?php $fileIcons = ['fas fa-file-image', 'fas fa-file-word', 'fas fa-file-excel', 'fas fa-file-powerpoint', 'fas fa-file-archive',
                        'fas fa-file-code', 'fas fa-file-pdf', 'fas fa-file-video', 'fas fa-file-audio', 'fas fa-file-alt'];

                    foreach ($attachments as $attachment): ?>
                    <div class="col-md-4 col-sm-6 col-xs-2 center-block" style="margin-top: 10px;">
                        <a target="_blank" href="<?= $attachment->file_name; ?>" title="<?= $attachment->description; ?>">
                            <i class="<?= $fileIcons[$attachment->note - 1]; ?> fa-3x"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <hr>
            <h4><i class="fas fa-list-ul" style="color: #3498DB;"></i> Other posts</h4>
            <?php if (!$suggestedPosts) { ?>
            <p class="lead text-center">More posts will be updated soon. Please come back tomorrow to see more!</p>
            <?php } else { ?>
            <div class="row">
                <div class="table-responsive">
                    <table class="table bg-offwhite" style="border-radius: 10px;">
                        <thead><tr><th>#</th><th>Type</th><th>Title</th><th>Status</th><th>Posted on</th></tr></thead>
                        <tbody>
                            <tr><?php for ($i = 0; $i < count($suggestedPosts); $i++) { ?>
                                <th><?= $i + 1; ?></th>
                                <td class="small"><a data-toggle="tooltip" title="<?= $suggestedPosts[$i]['ctitle']; ?>" style="margin-right: 5px;"><i class="<?= $suggestedPosts[$i]['description']; ?>"></i></a> <?= $suggestedPosts[$i]['ctitle']; ?></td>
                                <td><?= $suggestedPosts[$i]['title']; ?></td>
                                <td><?= $suggestedPosts[$i]['status'] ? '<span class="label label-success">Completed</span>' : '<span class="label label-info">Progressing</span>'; ?></td>
                                <td><?= (new DateTime($suggestedPosts[$i]['created_on']))->format('d/m/Y H:i'); ?></td>
                            <?php } ?></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="row">
            <hr>
            <h4  style="margin-bottom: 0;"><i class="fas fa-paper-plane" style="color: #3498DB;"></i> Leave a Reply</h4>
            <p class="small"  style="margin-top: 0;">To respect your privacy, your submitted information will not be published.</p>
            <div class="row">

            </div>
        </div>

        <div class="row">
            <hr>
            <h4>Comments <i class="fas fa-caret-right" style="color: #3498DB;"></i> 5 Replies</h4>
            <div class="row">

            </div>
        </div>
    </section>
</div>
