<?php $reviveBtnAttr = ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'style' => 'margin-top: 0;', 'type' => 'submit'];
$removeBtnAttr = ['class' => 'btn btn-outline btn-outline-sm outline-light', 'style' => 'margin-top: 0;', 'type' => 'submit']; ?>

<div class="container">
    <div class="row" style="min-height: 622px;">
        <h2>Suspended Assets</h2>
        <!-- Page mini-navigation: Tab-bar displaying tabs that toggle its corresponding view -->
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#suspendedPosts">Suspended Posts</a></li>
            <li><a data-toggle="tab" href="#suspendedFiles">Suspended Files</a></li>
            <li><a data-toggle="tab" href="#suspendedThreads">Suspended Threads</a></li>
            <li><a data-toggle="tab" href="#suspendedSuggestions">Suspended Suggestions</a></li>
            <li><a data-toggle="tab" href="#suspendedMessages">Suspended Messages</a></li>
        </ul>
        <!-- End Tab-bar -->

        <!-- The contents for all the tabs -->
        <div class="tab-content">
            <!-- New Comments & Replies -->
            <div id="suspendedPosts" class="tab-pane fade in active">

            </div>
            <!-- End New Comments & Replies -->

            <!-- New Suggestions -->
            <div id="suspendedFiles" class="tab-pane fade">
                <?php foreach ($postsContainSuspendedFiles as $post): ?>
                    <div class="row bg-offwhite">
                        <div class="row bg-info" style="padding: 0 15px 0 10px; margin-bottom: 10px;">
                            <p class="pull-left"><b>Post #<?= $post->id; ?>: <?= $post->title; ?></b></p>
                            <p class="pull-right"><b><?= (new DateTime($post->created_on))->format('d/m/Y H:i'); ?></b></p>
                        </div>
                        <form method="post" action="/jayblog/attachments/edit">
                            <div class="col-sm-10 col-xs-12 pull-left">
                                <?php $fileIcons = ['fas fa-file-image', 'fas fa-file-word', 'fas fa-file-excel', 'fas fa-file-powerpoint', 'fas fa-file-archive',
                            'fas fa-file-code', 'fas fa-file-pdf', 'fas fa-file-video', 'fas fa-file-audio', 'fas fa-file-alt'];

                                foreach ($suspendedFilesByPosts[$post->id] as $suspendedFile): ?>
                                    <div class="col-xs-2 text-center" style="margin-bottom: 10px;">
                                        <a target="_blank" href="<?= $suspendedFile->file_name; ?>" title="<?= $suspendedFile->description; ?>">
                                            <i class="<?= $fileIcons[$suspendedFile->note - 1]; ?> fa-2x"></i>
                                        </a>
                                        <p style="margin-top: 0; margin-bottom: 10px;"><?= $suspendedFile->description; ?></p>
                                        <input type="checkbox" name="file_id[]" value="<?= $suspendedFile->id; ?>" />
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="col-sm-2 col-xs-12 pull-right">
                                <?= $this->Form->button(__('Revive'), $reviveBtnAttr); ?>
                                <?= $this->Form->button(__('Remove'), $removeBtnAttr); ?>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- End New Suggestions -->

            <!-- New Contact Messages -->
            <div id="suspendedThreads" class="tab-pane fade">
                <?php $defaultAvatars = ['identicon', 'monsterid', 'wavatar', 'retro', 'robohash'];
                foreach ($targetedPosts as $targetedPost): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 25px;">
                        <div class="row bg-info" style="padding: 0 15px 0px 10px;">
                            <h4 class="pull-left">Post #<?= $targetedPost->id; ?>: <?= $targetedPost->title; ?></h4>
                            <h4 class="pull-right"><?= (new DateTime($targetedPost->created_on))->format('d/m/Y H:i'); ?></h4>
                        </div>
                        <?php if (isset($commentsByPosts[$targetedPost->id])) {
                            foreach ($commentsByPosts[$targetedPost->id] as $commentsByPost): ?>
                            <div class="row" style="margin-top: 5px; padding: 0 10px 0 10px;">
                                <div class="row bg-offwhite" style="border-radius: 10px;">
                                    <div class="col-md-2 col-sm-3 col-xs-3">
                                        <?= $this->Gravatar->avatar(strtolower($commentsByPost->commenter_email),
                                            ['size' => '35px', 'default' => $defaultAvatars[array_rand($defaultAvatars)], 'class' => 'img-circle']); ?>
                                        <span class="label label-<?= $commentsByPost->active ? 'info' : 'warning'; ?>">
                                            <?= $commentsByPost->active ? 'Published' : 'Suspended'; ?>
                                        </span>
                                        <p style="margin-bottom: 0;"><b><?= ucwords(strtolower($commentsByPost->commenter_name)); ?></b></p>
                                        <p style="margin-top: 0;"><b><?= (new DateTime($commentsByPost->comment_date))->format('d/m/Y H:i'); ?></b></p>
                                    </div>
                                    <div class="col-md-10 col-sm-9 col-xs-9"><p><?= $commentsByPost->content; ?></p></div>
                                    <?php if (!$commentsByPost->active) { ?>
                                        <div class="row" style="margin-left: 20px;">
                                            <?= $this->Form->postLink('Revive',
                                                ['controller' => 'Comments', 'action' => 'reviewComment', $commentsByPost->id],
                                                ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Revive comment #{0}?', $commentsByPost->id)]); ?>
                                            <?= $this->Form->postLink('Remove',
                                                ['controller' => 'Comments', 'action' => 'delete', $commentsByPost->id],
                                                ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Remove comment #{0}?', $commentsByPost->id)]); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if (isset($repliesByComments[$commentsByPost->id])) {
                                    foreach ($repliesByComments[$commentsByPost->id] as $repliesByComment): ?>
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-4 col-xs-4">
                                                    <?= $this->Gravatar->avatar(strtolower($repliesByComment['replier_email']),
                                                        ['size' => '25px', 'default' => $defaultAvatars[array_rand($defaultAvatars)], 'class' => 'img-circle']); ?>
                                                    <span class="label label-<?= $repliesByComment['active'] ? 'info' : 'warning'; ?>">
                                                        <?= $repliesByComment['active'] ? 'Published' : 'Suspended'; ?>
                                                    </span>
                                                    <p style="margin-bottom: 0;"><b><?= ucwords(strtolower($repliesByComment['replier_name'])); ?></b></p>
                                                    <p style="margin-top: 0;"><b><?= (new DateTime($repliesByComment['reply_date']))->format('d/m/Y H:i'); ?></b></p>
                                                </div>
                                                <div class="col-md-9 col-sm-8 col-xs-8"><p><?= $repliesByComment['content']; ?></p></div>
                                            </div>
                                            <?php if (!$repliesByComment['active']) { ?>
                                                <div class="row" style="margin-left: 10px;">
                                                    <?= $this->Form->postLink('Revive',
                                                        ['controller' => 'Replies', 'action' => 'reviewReply', $repliesByComment['id']],
                                                        ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Reviving reply #{0} will also revive its associated comment #{1}. Revive reply #{2} and comment #{3}?', $repliesByComment['id'], $commentsByPost['id'], $repliesByComment['id'], $commentsByPost['id'])]); ?>
                                                    <?= $this->Form->postLink('Remove',
                                                        ['controller' => 'Replies', 'action' => 'delete', $repliesByComment['id']],
                                                        ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Remove reply #{0}?', $repliesByComment['id'])]); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php endforeach; } ?>
                            </div>
                        <?php endforeach; } ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- End New Contact Messages -->

            <!-- New Contact Messages -->
            <div id="suspendedSuggestions" class="tab-pane fade">
                <h2>Suspended Feature Suggestions</h2>
                <?php foreach ($postsContainSuspendedSuggestions as $post): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                        <div class="row bg-info" style="padding: 0 15px 0px 10px;">
                            <h4 class="pull-left">Post #<?= $post->id; ?>: <?= $post->title; ?></h4>
                            <h4 class="pull-right"><?= (new DateTime($post->created_on))->format('d/m/Y H:i'); ?></h4>
                            <span class="label label-info">Feature</span>
                        </div>
                        <?php foreach ($suspendedFeatureSuggestions[$post->id] as $suspendedFeatureSuggestion): ?>
                            <div class="row" style="margin-top: 5px; padding: 0 10px 0 10px;">
                                <div class="row bg-offwhite" style="border-radius: 10px;">
                                    <div class="col-md-3 col-sm-3 col-xs-4">
                                        <p style="margin-bottom: 0;"><b><?= $suspendedFeatureSuggestion->sender_name ? ucwords(strtolower($suspendedFeatureSuggestion->sender_name)) : 'N/A'; ?></b></p>
                                        <p style="margin-top: 0;"><b><?= $suspendedFeatureSuggestion->sender_email ? strtolower($suspendedFeatureSuggestion->sender_email) : 'N/A'; ?></b></p>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-8"><p><?= $suspendedFeatureSuggestion->content; ?></p></div>
                                    <div class="row" style="margin-left: 20px;">
                                        <?= $this->Form->postLink('Revive',
                                            ['controller' => 'Messages', 'action' => 'reviewMessage', $suspendedFeatureSuggestion->id],
                                            ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Revive suggestion #{0}?', $suspendedFeatureSuggestion->id)]); ?>
                                        <?= $this->Form->postLink('Remove',
                                            ['controller' => 'Messages', 'action' => 'delete', $suspendedFeatureSuggestion->id],
                                            ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Remove suggestion #{0}?', $suspendedFeatureSuggestion->id)]); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <h2>Suspended Project Suggestions</h2>
                <?php foreach ($suspendedPostSuggestions as $suspendedPostSuggestion): ?>
                <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                    <div class="bg-offwhite" style="border-radius: 10px;">
                        <div class="col-md-2 col-sm-3 col-xs-4">
                            <p style="margin-bottom: 0;"><b><?= $suspendedPostSuggestion->sender_name ? ucwords(strtolower($suspendedPostSuggestion->sender_name)) : 'N/A'; ?></b></p>
                            <p style="margin-top: 0;"><b><?= $suspendedPostSuggestion->sender_email ? strtolower($suspendedPostSuggestion->sender_email) : 'N/A'; ?></b></p>
                            <span class="label label-info">Post</span>
                        </div>
                        <div class="col-md-10 col-sm-9 col-xs-8"><p><?= $suspendedPostSuggestion->content; ?></p></div>
                        <div class="row" style="margin-left: 20px;">
                            <?= $this->Form->postLink('Revive',
                                ['controller' => 'Messages', 'action' => 'reviewMessage', $suspendedPostSuggestion->id],
                                ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Revive suggestion #{0}?', $suspendedPostSuggestion->id)]); ?>
                            <?= $this->Form->postLink('Remove',
                                ['controller' => 'Messages', 'action' => 'delete', $suspendedPostSuggestion->id],
                                ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Remove suggestion #{0}?', $suspendedPostSuggestion->id)]); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <!-- End New Contact Messages -->

            <!-- New Contact Messages -->
            <div id="suspendedMessages" class="tab-pane fade">
                <?php foreach ($suspendedContactors as $suspendedContactor): ?>
                <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                    <div class="bg-offwhite" style="border-radius: 10px;">
                        <div class="col-md-3 col-sm-3 col-xs-4">
                            <p style="margin-bottom: 0;"><b><?= ucwords(strtolower($suspendedContactor->sender_name)); ?></b></p>
                            <p style="margin-top: 0;"><b><?= strtolower($suspendedContactor->sender_email); ?></b></p>
                            <p style="margin-top: 0;"><b><?= $suspendedContactor->phone ? $suspendedContactor->phone : 'N/A'; ?></b></p>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-8"><p><?= $suspendedContactor->content; ?></p></div>
                        <div class="row" style="margin-left: 20px;">
                            <?= $this->Form->postLink('Revive',
                                ['controller' => 'Messages', 'action' => 'reviewMessage', $suspendedContactor->id],
                                ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Revive suggestion #{0}?', $suspendedContactor->id)]); ?>
                            <?= $this->Form->postLink('Remove',
                                ['controller' => 'Messages', 'action' => 'delete', $suspendedContactor->id],
                                ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Remove suggestion #{0}?', $suspendedContactor->id)]); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <!-- End New Contact Messages -->
        </div>
        <!-- End contents -->
    </div>
</div>
