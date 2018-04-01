<?php $adminIdSearchAttr = ['id' => 'postId', 'placeholder' => 'Post ID', 'label' => false, 'type' => 'number', 'class' => 'form-control', 'oninput' => 'adminSearchCheck()'];
$adminKeySearchAttr = ['id' => 'keyword', 'placeholder' => 'Keyword', 'label' => false, 'type' => 'text', 'class' => 'form-control', 'oninput' => 'adminSearchCheck()'];
$adminSubmitAttr = ['id' => 'adminSubmit', 'style' => 'margin-left: 15px;', 'class' => 'btn btn-outline btn-outline-sm outline-dark', 'disabled' => true]; ?>

<div class="container">
    <div class="row" style="min-height: 622px;">
        <h2>Admin: Jay Nguyen</h2>

        <!-- Admin Search Form -->
        <div class="row">
            <form method="post" action="/jayblog/users/search">
                <div class="row">
                    <div class="col-xs-12 text-center"><p class="guardsman" id="adminSearchError"></p></div>
                    <div class="col-sm-6 col-xs-12"><?= $this->Form->control('postId', $adminIdSearchAttr); ?></div>
                    <div class="col-sm-6 col-xs-12"><?= $this->Form->control('keyword', $adminKeySearchAttr); ?></div>
                </div>
                <div class="row"><?= $this->Form->button(__('Search'), $adminSubmitAttr); ?></div>
            </form>
            <hr>
        </div>
        <!-- End Admin Search Form -->

        <script type="text/javascript">
            function adminSearchCheck() {
                var postId = document.getElementById('postId').value;
                var keyword = document.getElementById('keyword').value;
                var error = document.getElementById('adminSearchError');
                var submitBtn = document.getElementById('adminSubmit');

                if (postId.length !== 0 && keyword.length !== 0) {
                    error.innerHTML = 'Only 1 of the 2 searches is allow at a time.';
                    submitBtn.disabled = true;
                }
                else if (postId.length !== 0 && keyword.length === 0) {
                    if (parseInt(postId) !== 0 && parseInt(postId) !== 1) {
                        error.innerHTML = '';
                        submitBtn.disabled = false;
                    }
                    else {
                        error.innerHTML = 'No posts found for the following ids: #0 and #1';
                        submitBtn.disabled = true;
                    }
                }
                else if (postId.length === 0 && keyword.length !== 0) {
                    error.innerHTML = '';
                    submitBtn.disabled = false;
                }
                else {
                    error.innerHTML = '';
                    submitBtn.disabled = true;
                }
            }
        </script>

        <!-- Page mini-navigation: Tab-bar displaying tabs that toggle its corresponding view -->
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#reviews">
                    New Comments & Replies <?= ($commentsByPosts || $repliesByComments) ? '<i class="fas fa-bell guardsman blink"></i>' : ''; ?>
                </a></li>
            <li><a data-toggle="tab" href="#suggestions">
                    New Suggestions <?= ($postSuggestions || $featureSuggestions) ? '<i class="fas fa-bell guardsman blink"></i>' : ''; ?></a></li>
            <li><a data-toggle="tab" href="#messagess">
                    New Contact Messages <?= $newContactors ? '<i class="fas fa-bell guardsman blink"></i>' : ''; ?></a></li>
        </ul>
        <!-- End Tab-bar -->

        <!-- The contents for all the tabs -->
        <div class="tab-content">
            <!-- New Comments & Replies -->
            <div id="reviews" class="tab-pane fade in active">
                <?php $defaultAvatars = ['identicon', 'monsterid', 'wavatar', 'retro', 'robohash'];
                foreach ($reactedPosts as $reactedPost): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 25px;">
                        <div class="row bg-info" style="padding: 0 15px 0px 10px;">
                            <h4 class="pull-left">Post #<?= $reactedPost->id; ?>: <?= $reactedPost->title; ?></h4>
                            <h4 class="pull-right"><?= (new DateTime($reactedPost->created_on))->format('d/m/Y H:i'); ?></h4>
                        </div>
                        <?php if (isset($commentsByPosts[$reactedPost->id])) {
                            foreach ($commentsByPosts[$reactedPost->id] as $commentsByPost): ?>
                            <div class="row" style="margin-top: 5px; padding: 0 10px 0 10px;">
                                <div class="row bg-offwhite" style="border-radius: 10px;">
                                    <div class="col-md-2 col-sm-3 col-xs-3">
                                        <?= $this->Gravatar->avatar(strtolower($commentsByPost->commenter_email),
                                            ['size' => '35px', 'default' => $defaultAvatars[array_rand($defaultAvatars)], 'class' => 'img-circle']); ?>
                                        <span class="label label-<?= $commentsByPost->status ? 'success' : 'warning'; ?>">
                                            <?= $commentsByPost->status ? 'Published' : 'Pending'; ?>
                                        </span>
                                        <p style="margin-bottom: 0;"><b><?= ucwords(strtolower($commentsByPost->commenter_name)); ?></b></p>
                                        <p style="margin-top: 0;"><b><?= (new DateTime($commentsByPost->comment_date))->format('d/m/Y H:i'); ?></b></p>
                                    </div>
                                    <div class="col-md-10 col-sm-9 col-xs-9"><p><?= $commentsByPost->content; ?></p></div>
                                    <?php if (!$commentsByPost->status) { ?>
                                        <div class="row" style="margin-left: 20px;">
                                            <?= $this->Form->postLink('Approve',
                                                ['controller' => 'Comments', 'action' => 'edit', '?' => ['cid' => $commentsByPost->id, 'pid' => '0']],
                                                ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Approve comment #{0}?', $commentsByPost->id)]); ?>
                                            <?= $this->Form->postLink('Suspend',
                                                ['controller' => 'Comments', 'action' => 'edit', '?' => ['cid' => $commentsByPost->id, 'pid' => '1']],
                                                ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Suspend comment #{0}?', $commentsByPost->id)]); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if (isset($repliesByComments[$commentsByPost->id])) {
                                    foreach ($repliesByComments[$commentsByPost->id] as $repliesByComment): ?>
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-4 col-xs-4">
                                                    <?= $this->Gravatar->avatar(strtolower($repliesByComment->replier_email),
                                                        ['size' => '25px', 'default' => $defaultAvatars[array_rand($defaultAvatars)], 'class' => 'img-circle']); ?>
                                                    <span class="label label-<?= $repliesByComment->status ? 'success' : 'warning'; ?>">
                                                        <?= $repliesByComment->status ? 'Published' : 'Pending'; ?>
                                                    </span>
                                                    <p style="margin-bottom: 0;"><b><?= ucwords(strtolower($repliesByComment->replier_name)); ?></b></p>
                                                    <p style="margin-top: 0;"><b><?= (new DateTime($repliesByComment->reply_date))->format('d/m/Y H:i'); ?></b></p>
                                                </div>
                                                <div class="col-md-9 col-sm-8 col-xs-8"><p><?= $repliesByComment->content; ?></p></div>
                                            </div>
                                            <?php if (!$repliesByComment->status) { ?>
                                                <div class="row" style="margin-left: 10px;">
                                                    <?= $this->Form->postLink('Approve',
                                                        ['controller' => 'Replies', 'action' => 'edit', '?' => ['rid' => $repliesByComment->id, 'pid' => '0']],
                                                        ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Approve reply #{0}?', $repliesByComment->id)]); ?>
                                                    <?= $this->Form->postLink('Suspend',
                                                        ['controller' => 'Replies', 'action' => 'edit', '?' => ['rid' => $repliesByComment->id, 'pid' => '1']],
                                                        ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Suspend reply #{0}?', $repliesByComment->id)]); ?>
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
            <!-- End New Comments & Replies -->

            <!-- New Suggestions -->
            <div id="suggestions" class="tab-pane fade">
                <h2>Feature Suggestions</h2>
                <?php foreach ($suggestedPosts as $suggestedPost): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                        <!-- Post associated with suggestion -->
                        <div class="row bg-info" style="padding: 0 15px 0px 10px;">
                            <h4 class="pull-left">Post #<?= $suggestedPost->id; ?>: <?= $suggestedPost->title; ?></h4>
                            <h4 class="pull-right"><?= (new DateTime($suggestedPost->created_on))->format('d/m/Y H:i'); ?></h4>
                            <span class="label label-info">Feature</span>
                        </div>
                        <!-- End post -->

                        <?php foreach ($featureSuggestions[$suggestedPost->id] as $featureSuggestion): ?>
                            <!-- Suggestion for the post -->
                            <div class="row" style="margin-top: 5px; padding: 0 10px 0 10px;">
                                <div class="row bg-offwhite" style="border-radius: 10px;">
                                    <!-- Suggester Info -->
                                    <div class="col-md-3 col-sm-3 col-xs-4">
                                        <p style="margin-bottom: 0;"><b><?= $featureSuggestion->sender_name ? ucwords(strtolower($featureSuggestion->sender_name)) : 'N/A'; ?></b></p>
                                        <p style="margin-top: 0;"><b><?= $featureSuggestion->sender_email ? strtolower($featureSuggestion->sender_email) : 'N/A'; ?></b></p>
                                    </div>
                                    <!-- End suggester info -->

                                    <div class="col-md-9 col-sm-9 col-xs-8"><p><?= $featureSuggestion->content; ?></p></div>

                                    <!-- Action buttons -->
                                    <div class="row" style="margin-left: 20px;">
                                        <?= $this->Form->postLink('Okay',
                                            ['controller' => 'Messages', 'action' => 'edit', '?' => ['mid' => $featureSuggestion->id, 'pid' => '0']],
                                            ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Mark suggestion #{0} as read?', $featureSuggestion->id)]); ?>
                                        <?= $this->Form->postLink('Highlight',
                                            ['controller' => 'Messages', 'action' => 'edit', '?' => ['mid' => $featureSuggestion->id, 'pid' => '2']],
                                            ['class' => 'btn btn-outline btn-outline-sm outline-dim', 'confirm' => __('Highlight suggestion #{0}?', $featureSuggestion->id)]); ?>
                                        <?= $this->Form->postLink('Suspend',
                                            ['controller' => 'Messages', 'action' => 'edit', '?' => ['mid' => $featureSuggestion->id, 'pid' => '1']],
                                            ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Suspend suggestion #{0}?', $featureSuggestion->id)]); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- End suggestion -->
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <h2>Project Suggestions</h2>
                <?php foreach ($postSuggestions as $postSuggestion): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                        <div class="bg-offwhite" style="border-radius: 10px;">
                            <!-- Suggester Info -->
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <p style="margin-bottom: 0;"><b><?= $postSuggestion->sender_name ? ucwords(strtolower($postSuggestion->sender_name)) : 'N/A'; ?></b></p>
                                <p style="margin-top: 0;"><b><?= $postSuggestion->sender_email ? strtolower($postSuggestion->sender_email) : 'N/A'; ?></b></p>
                                <span class="label label-info">Post</span>
                            </div>
                            <!-- End Suggester Info -->

                            <div class="col-md-10 col-sm-9 col-xs-8"><p><?= $postSuggestion->content; ?></p></div>

                            <!-- Action buttons -->
                            <div class="row" style="margin-left: 20px;">
                                <?= $this->Form->postLink('Okay',
                                    ['controller' => 'Messages', 'action' => 'edit', '?' => ['mid' => $postSuggestion->id, 'pid' => '0']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Mark suggestion #{0} as read?', $postSuggestion->id)]); ?>
                                <?= $this->Form->postLink('Highlight',
                                    ['controller' => 'Messages', 'action' => 'edit', '?' => ['mid' => $postSuggestion->id, 'pid' => '2']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-dim', 'confirm' => __('Highlight suggestion #{0}?', $postSuggestion->id)]); ?>
                                <?= $this->Form->postLink('Suspend',
                                    ['controller' => 'Messages', 'action' => 'edit', '?' => ['mid' => $postSuggestion->id, 'pid' => '1']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Suspend suggestion #{0}?', $postSuggestion->id)]); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- End New Suggestions -->

            <!-- New Contact Messages -->
            <div id="messagess" class="tab-pane fade">
                <?php foreach ($newContactors as $newContactor): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                        <div class="bg-offwhite" style="border-radius: 10px;">
                            <!-- Suggester Info -->
                            <div class="col-md-3 col-sm-3 col-xs-4">
                                <p style="margin-bottom: 0;"><b><?= ucwords(strtolower($newContactor->sender_name)); ?></b></p>
                                <p style="margin-top: 0;"><b><?= strtolower($newContactor->sender_email); ?></b></p>
                                <p style="margin-top: 0;"><b><?= $newContactor->phone ? $newContactor->phone : 'N/A'; ?></b></p>
                            </div>
                            <!-- End Suggester Info -->

                            <div class="col-md-9 col-sm-9 col-xs-8"><p><?= $newContactor->content; ?></p></div>

                            <!-- Action buttons -->
                            <div class="row" style="margin-left: 20px;">
                                <?= $this->Form->postLink('Okay',
                                    ['controller' => 'Messages', 'action' => 'edit', '?' => ['mid' => $newContactor->id, 'pid' => '0']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Mark suggestion #{0} as read?', $newContactor->id)]); ?>
                                <?= $this->Form->postLink('Highlight',
                                    ['controller' => 'Messages', 'action' => 'edit', '?' => ['mid' => $newContactor->id, 'pid' => '2']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-dim', 'confirm' => __('Highlight suggestion #{0}?', $newContactor->id)]); ?>
                                <?= $this->Form->postLink('Suspend',
                                    ['controller' => 'Messages', 'action' => 'edit', '?' => ['mid' => $newContactor->id, 'pid' => '1']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Suspend suggestion #{0}?', $newContactor->id)]); ?>
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
