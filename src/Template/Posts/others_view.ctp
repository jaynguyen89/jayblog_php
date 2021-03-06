<?php $session = $this->request->session();
$nameFieldAtt = ['class' => 'form-control', 'label' => false, 'placeholder' => 'Name*', 'type' => 'text', 'id' => 'commenterName', 'oninput' => 'validateCommentForm()'];
$emailFieldAtt = ['class' => 'form-control', 'label' => false, 'placeholder' => 'Email*', 'type' => 'text', 'id' => 'commenterEmail', 'oninput' => 'validateCommentForm()'];
$commentSubmit = ['id' => 'commentButton', 'class' => 'btn btn-outline btn-outline-md outline-dark', 'disabled' => true, 'style' => 'margin-top: 0;'];

$user = $this->request->session()->read('Auth.User');
?>

<div class="container">
    <!-- Breadcrumb navigation pane
    <ul class="breadcrumb">
        <li><?= $this->Html->link('Home', '/'); ?></li>
        <li>Posts</li>
        <li><?= $this->Html->link('View', ['controller' => 'Posts', 'action' => 'view', $post->id]); ?></li>
    </ul>
    End breadcrumb -->

    <section id="content-1-9" class="content-1-9 content-block" style="padding-bottom: 10px;">
        <!-- Section title -->
        <div class="container">
            <div class="underlined-title">
                <h1><?= $user ? '#'.$post->id.': ' : ''; ?><?= $post->title; ?></h1>
                <hr>
                <p class="lead"><?= $post->description; ?></p>
            </div>
        </div>
        <!-- End section title -->

        <div class="row">
            <!-- Left column displaying general project information -->
            <div class="col-md-4 col-sm-8 col-xs-12">
                <!-- General project info -->
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Posted on: <b class="pull-right"><?= (new DateTime($post->created_on))->format('d/m/Y H:i'); ?></b></li>
                    <li class="list-group-item">Type:
                        <div class="pull-right"><a data-toggle="tooltip" title="<?= $category->title; ?>" style="margin-right: 5px;"><i class="<?= $category->description; ?> fa-2x"></i></a></div>
                    </li>
                    <li class="list-group-item">Up vote: <b><?= $session->read('Post.up_vote'); ?></b>
                        <?= $this->Form->postLink(
                            $this->Html->tag('i', '', ['class' => 'fas fa-thumbs-up fa-2x pull-right']),
                            ['controller' => 'Votes', 'action' => 'add', '?' => ['pid' => $post->id, 'sign' => 1]],
                            ['role' => 'button', 'escape' => false, 'confirm' => __('Since no login was required, your IP Address may be recorded. This approach is to prevent visitors voting multiple times on 1 post.\n\nNo personal information will be collected. Your IP Address will be securely encrypted.\n\nContinue to vote up for {0}?', $post->title)]); ?></li>
                    <li class="list-group-item">Down vote: <b><?= $session->read('Post.down_vote'); ?></b>
                        <?= $this->Form->postLink(
                            $this->Html->tag('i', '', ['class' => 'fas fa-thumbs-down fa-2x pull-right']),
                            ['controller' => 'Votes', 'action' => 'add', '?' => ['pid' => $post->id, 'sign' => 0]],
                            ['role' => 'button', 'escape' => false, 'confirm' => __('Since no login was required, your IP Address may be recorded. This approach is to prevent visitors voting multiple times on 1 post.\n\nNo personal information will be collected. Your IP Address will be securely encrypted.\n\nContinue to vote down for {0}?', $post->title)]); ?></li>
                </ul>
                <!-- End project info -->
            </div>
            <!-- End left column -->
            
            <!-- Middle column displaying suggestion and note -->
            <div class="col-md-4 col-sm-4 col-xs-12">
                <p class="small">Please click <a role="button" data-toggle="modal" data-target="#suggestFeatureModal">here</a> to suggest something on this post. Thanks!</p>
                <h5><i class="fas fa-pencil-alt" style="color: #3498DB;"></i> Notes</h5>
                <p class="small"><?= $post->note ? $post->note : 'N/A'; ?></p>
            </div>
            <!-- End middle column -->
            
            <!-- Right column displaying project's attachments -->
            <div class="col-md-4 col-sm-12 col-xs-12">
                <h4><i class="fas fa-paperclip" style="color: #3498DB;"></i> File Attachments</h4>
                <!-- The attachments -->
                <div class="row">
                    <?php if ($attachments) {
                    $fileIcons = ['fas fa-file-image', 'fas fa-file-word', 'fas fa-file-excel', 'fas fa-file-powerpoint', 'fas fa-file-archive',
                        'fas fa-file-code', 'fas fa-file-pdf', 'fas fa-file-video', 'fas fa-file-audio', 'fas fa-file-alt'];

                    foreach ($attachments as $attachment): ?>
                    <?php if (strpos($attachment->file_name, 'ttps://www')) { ?>
                        <div class="col-md-4 col-sm-6 col-xs-2 center-block" style="margin-top: 10px;">
                            <a target="_blank" href="<?= $attachment->file_name; ?>" title="<?= $attachment->description; ?>">
                                <i class="<?= $fileIcons[$attachment->note - 1]; ?> fa-3x"></i>
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-4 col-sm-6 col-xs-2 center-block" style="margin-top: 10px;">
                            <a target="_blank" href="/jayblog/files/<?= $post->id.'/'.$attachment->file_name; ?>" title="<?= $attachment->description; ?>">
                                <i class="<?= $fileIcons[$attachment->note - 1]; ?> fa-3x"></i>
                            </a>
                        </div>
                    <?php } endforeach;
                    } else
                        echo '<p>No attachments found for this post.</p>'; ?>
                </div>
                <!-- attachments -->
            </div>
            <!-- End right column -->
            
            <!-- Row containing admin managing buttons -->
            <?php if ($user) { ?>
            <div class="row">
                <div class="col-xs-6">
                    <?= $this->Html->link('Edit Board', ['controller' => 'Posts', 'action' => 'edit', '?' => ['pid' => $post->id, 'form' => '1']],
                        ['class' => 'btn btn-outline btn-outline-sm outline-dark']); ?>
                </div>
                <div class="col-xs-6">
                    <?= $this->Form->postLink('Reset Votes', ['controller' => 'Votes', 'action' => 'edit', $post->id],
                        ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('All votes will be reset for {0}. Continue?', $post->title)]); ?>
                </div>
            </div>
            <?php } ?>
            <!-- End admin row -->
        </div>

        <!-- Section containing the main post content -->
        <div class="row" style="margin-top: 15px;">
            <!-- Post content -->
            <div class="col-xs-12">
                <h4><i class="fas fa-clipboard" style="color: #3498DB;"></i> Post Content</h4>
                <p class="medium"><?= $post->content; ?></p>
            </div>
            <!-- content -->
        </div>
        <!-- End section -->

        <?php if (!$user) { ?>
        <!-- Section containing next reading suggestions -->
        <div class="row">
            <hr>
            <h4><i class="fas fa-list-ul" style="color: #3498DB;"></i> Other posts</h4>
            <?php if (!$suggestedPosts) { ?>
            <p class="lead text-center">More posts will be updated soon. Please come back tomorrow to see more!</p>
            <?php } else { ?>
            <div class="row">
                <div class="table-responsive">
                    <!-- Table of suggestions -->
                    <table class="table bg-offwhite" style="border-radius: 10px;">
                        <thead><tr><th>#</th><th>Type</th><th>Title</th><th>Status</th><th>Posted on</th></tr></thead>
                        <tbody>
                            <?php for ($i = 0; $i < count($suggestedPosts); $i++) { ?>
                                <tr>
                                    <th><?= $i + 1; ?></th>
                                    <td class="small"><a data-toggle="tooltip" title="<?= $suggestedPosts[$i]['ctitle']; ?>" style="margin-right: 5px;"><i class="<?= $suggestedPosts[$i]['description']; ?>"></i></a> <?= $suggestedPosts[$i]['ctitle']; ?></td>
                                    <td><?= $this->Html->link($suggestedPosts[$i]['title'], ['controller' => 'Posts', 'action' => 'view', $suggestedPosts[$i]['id']]); ?></td>
                                    <td><?= $suggestedPosts[$i]['status'] ? '<span class="label label-info">Progressing</span>' : '<span class="label label-success">Completed</span>'; ?></td>
                                    <td><?= (new DateTime($suggestedPosts[$i]['created_on']))->format('d/m/Y H:i'); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- End table -->
                </div>
            </div>
            <?php } ?>
        </div>
        <!-- End suggestion -->

        <!-- Section containing the comment form -->
        <div class="row" id="commentForm">
            <hr>
            <h4 style="margin-bottom: 0;"><i class="fas fa-paper-plane" style="color: #3498DB;"></i> Leave a Comment</h4>
            <p class="small"  style="margin-top: 0;">To respect your privacy, your submitted information will not be published.</p>
            <div class="row">
                <?php $isCommentable = true; if ($isCommentable) { ?>
                <div class="box" style="margin: 0 10px 0 10px">
                    <!-- /.box-header -->
                    <form method="post" action="/jayblog/comments/add">
                        <input type="hidden" name="post_id" value="<?= $post->id; ?>" />
                        <div class="box-body pad">
                            <!-- The comment form: input name, email, content area -->
                            <div class="row">
                                <p id="commentError" class="guardsman text-center"></p>
                                <div class="col-sm-6 col-xs-12"><div class="form-group"><?= $this->Form->control('commenter_name', $nameFieldAtt); ?></div></div>
                                <div class="col-sm-6 col-xs-12"><div class="form-group"><?= $this->Form->control('commenter_email', $emailFieldAtt); ?></div></div>
                            </div>
                            <div class="row" style="margin: 0 5px 0 5px;">
                                <textarea id="editor1" name="content" rows="10" cols="90"></textarea>
                                <p id="countCommentChars" class="small pull-right" style="margin-top: 0; margin-bottom: 0; color: #515157;">5000 Chars Left</p>
                            </div>
                            <!-- End input area -->

                            <!-- Comment preview -->
                            <div id="previewDiv" class="row" style="margin: 0 10px 0 10px; display: none;">
                                <h4>Preview your comment</h4>
                                <div id="preview" class="row" style="margin: 0 10px 15px 10px; background-color: #F8F8F8; border: 1px solid #E7E7E7; border-radius: 10px; padding: 0 15px 0 15px; max-height: 250px; overflow-y: scroll;"></div>
                            </div>
                            <div class="editContent""><?= $this->Form->button('Submit', $commentSubmit); ?></div>
                        </div>
                    </form>
                </div>
            <?php } else { ?>
                <h3>Comment is not available on posts that are older than 6 months.</h3>
            <?php } ?>
            </div>
        </div>
        <!-- End comment form -->
        <?php } else { ?>
        <div class="row">
            <hr>
            <div class="col-sm-3 col-xs-6" style="margin-top: 10px;">
                <?= $this->Html->link('Edit Post', ['controller' => 'Posts', 'action' => 'edit', '?' => ['pid' => $post->id, 'form' => '0']],
                    ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'style' => 'margin: auto;']); ?>
            </div>
            <div class="col-sm-3 col-xs-6" style="margin-top: 10px;">
                <?= $this->Html->link('Edit Files', ['controller' => 'Attachments', 'action' => 'adminEdit', '?' => ['pid' => $post->id, 'form' => '0']],
                    ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'style' => 'margin: auto;']); ?>
            </div>
            <div class="col-sm-3 col-xs-6" style="margin-top: 10px;">
                <?= $this->Html->link('Edit Gallery', ['controller' => 'Attachments', 'action' => 'adminEdit', '?' => ['pid' => $post->id, 'form' => '1']],
                    ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'style' => 'margin: auto;']); ?>
            </div>
            <div class="col-sm-3 col-xs-6" style="margin-top: 10px;">
                <?= ($post->active) ? $this->Form->postLink('Suspend', ['controller' => 'Posts', 'action' => 'delete', $post->id],
                    ['class' => 'btn btn-outline btn-outline-sm outline-light', 'style' => 'margin: auto;', 'confirm' => __('Suspend post #{0}: {1}. Continue?', $post->id, $post->title)]) :
                    $this->Form->postLink('Revive', ['controller' => 'Posts', 'action' => 'revive', $post->id],
                    ['class' => 'btn btn-outline btn-outline-sm outline-dim', 'style' => 'margin: auto;', 'confirm' => __('Revive post #{0}: {1}. Continue?', $post->id, $post->title)]); ?>
            </div>
            <hr>
        </div>
        <?php } ?>

        <!-- Section containing all comments and replies on the post -->
        <div class="row">
            <hr>
            <h4>Comments <i class="fas fa-caret-right" style="color: #3498DB;"></i> <?= count($comments); ?></h4>
            <?php $defaultAvatars = ['identicon', 'monsterid', 'wavatar', 'retro', 'robohash']; $n = 0;
            foreach ($comments as $comment): ?>
                <div class="row" style="<?php if ($n != count($comments) - 1) { ?>border-bottom: 1px solid #AAA;<?php } ?> padding-bottom: 10px; margin-left: 5px; margin-bottom: 15px;">
                    <!-- The comment -->
                    <div class="row">
                        <!-- First column displaying commentor avatar & name, comment date and reply button -->
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <?= $this->Gravatar->avatar($comment->commenter_email, ['size' => '75px', 'default' => $defaultAvatars[array_rand($defaultAvatars)], 'class' => 'img-circle pull-left']); ?>
                            <p style="margin-top: 0; margin-bottom: 5px;"><b><?= ucwords(strtolower($comment->commenter_name)); ?></b></p>
                            <p style="margin-top: 5px;"><b><?= (new DateTime($comment->comment_date))->format('d/m/Y H:i'); ?></b></p>
                            <?php if ($isCommentable && !$user) { ?>
                                <a role="button" name="showFormTag" onclick="showReplyForm(<?= $n; ?>);passDataToReplyForm(<?= $comment->id; ?>);">Reply</a>
                            <?php } else { ?>
                                <?php if (!$comment->status)
                                    echo $this->Form->postLink('Approve', ['controller' => 'Comments', 'action' => 'edit', '?' => ['cid' => $comment->id, 'pid' => '0']],
                                                         ['class' => 'text-success', 'confirm' => __('Approve comment #{0}. Continue?', $comment->id)]); ?>
                                <?= $this->Form->postLink('Suspend', ['controller' => 'Comments', 'action' => 'edit', '?' => ['cid' => $comment->id, 'pid' => '1']],
                                                         ['class' => 'text-danger', 'confirm' => __('Suspending comment #{0} will suspend its related replies. Continue?', $comment->id)]); ?>
                            <?php } ?>
                        </div>
                        <!-- End column -->

                        <!-- Second column containing the comment content -->
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"><?= $comment->status ? '' : '<span class="label label-warning">Pending</span>'; ?><div class="row" style="margin: 0 10px 15px 10px; background-color: #F8F8F8; border: 1px solid #3498DB; border-radius: 10px; padding: 0 15px 0 15px; max-height: 250px; overflow-y: scroll;"><?= $comment->content; ?></div></div>
                    </div>
                    <!-- End comment -->

                    <!-- This area contains the reply form which is printed via Javascript template -->
                    <?php if ($isCommentable && !$user) { ?>
                        <div class="row replyFormDivs" style="display: none;"></div>
                    <?php } ?>

                    <!-- The replies that are associated to a comment -->
                    <?php foreach ($repliesByComment[$comment->id] as $reply):
                        if ($reply) { ?>
                        <div class="row" style="margin: 15px 25px 10px 50px;">
                            <!-- First row displaying replier avatar & name, reply date -->
                            <div class="row" style="margin-bottom: 0;">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="row">
                                        <?= $this->Gravatar->avatar($reply->replier_email, ['size' => '35px', 'default' => $defaultAvatars[array_rand($defaultAvatars)], 'class' => 'img-circle pull-left']); ?>
                                        <h6><b><?= ucwords(strtolower($reply->replier_name)); ?></b></h6>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6"><p class="pull-right"><b><?= (new DateTime($reply->reply_date))->format('d/m/Y H:i'); ?> <?= $reply->status ? '' : '<span class="label label-warning">Pending</span>'; ?></b></p></div>
                            </div>
                            <!-- End first column -->

                            <!-- The replying content -->
                            <div class="row " style="background-color: #F8F8F8; border: 1px solid #E7E7E7; border-radius: 10px; padding: 10px;"><?= $reply->content; ?></div>
                            <?php if ($user) { ?>
                                <div class="row">
                                    <?php if (!$reply->status)
                                    echo $this->Form->postLink('Approve', ['controller' => 'Replies', 'action' => 'edit', '?' => ['rid' => $reply->id, 'pid' => '0']],
                                                             ['class' => 'text-success', 'confirm' => __('Approve reply {0}. Continue?', $reply->id)]); ?>
                                    <?= $this->Form->postLink('Suspend', ['controller' => 'Replies', 'action' => 'edit', '?' => ['rid' => $reply->id, 'pid' => '1']],
                                                             ['class' => 'text-danger', 'confirm' => __('Suspend reply {0}. Continue?', $reply->id)]); ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } endforeach; ?>
                    <!-- End replies -->
                </div>
            <?php $n++; endforeach; ?>
            <hr>
        </div>
        <!-- End section -->
    </section>
</div>

<?php if (!$user) { ?>
    <!-- This section contains the modal popup displaying a form that allows feature suggestion -->
    <div class="modal fade" id="suggestFeatureModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Popup header -->
                <div class="modal-header" align="center">
                    <?= $this->Html->image('jaydev.PNG', ['height' => '50px;', 'id' => 'img_logo']); ?>
                </div>

                <!-- Begin popup form -->
                <div id="div-forms">
                    <form id="login-form" method="post" action="/messages/suggestProject">
                        <div class="modal-body">
                            <div id="div-login-msg"><h6><i class="fas fa-bullhorn" style="color: #3498DB;"></i> Please enter some optional information and your suggestion.</h6></div>
                            <div class="row">
                                <div class="text-center"><p id="featureFormError" class="small guardsman"></p></div>
                                <input type="hidden" name="form_id" value="1" />
                                <input name="post_id" id="<?= $post->id; ?>" type="hidden"/>
                                <div class="col-xs-12"><h4><?= $post->title; ?></h4></div>
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;"><input name="sender_name" id="featureSuggesterName" class="form-control" type="text" placeholder="Name" oninput="checkSuggestFeatureForm()" /></div>
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;"><input name="sender_email" id="featureSuggesterEmail" class="form-control" type="text" placeholder="Email" oninput="checkSuggestFeatureForm()" /></div>
                                <div class="col-xs-12" style="margin-top: 5px;"><textarea name="content" id="featureIdea" class="form-control" rows="3" placeholder="Your feature idea ..." oninput="countSuggestCharacters()"></textarea></div>
                                <div class="text-center"><p id="featureSuggestCount" class="small">1000 Chars Left</p></div>
                            </div>
                        </div>
                        <div class="modal-footer"><button id="featureSubmit" type="submit" class="btn btn-outline btn-outline-sm outline-dark center-block" disabled style="margin: 0;">Send</button></div>
                    </form>
                </div>
                <!-- End popup form -->
            </div>
        </div>
    </div>
    <!-- End modal popup -->
<?php } ?>
