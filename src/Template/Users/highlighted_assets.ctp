<div class="container">
    <div class="row" style="min-height: 622px;">
        <h2>Highlighted Assets</h2>
        <!-- Page mini-navigation: Tab-bar displaying tabs that toggle its corresponding view -->
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#suggestions">Highlighted Suggestions</a></li>
            <li><a data-toggle="tab" href="#messages">Highlighted Messages</a></li>
            <li><a data-toggle="tab" href="#highlighter">Highlighter</a></li>
        </ul>
        <!-- End Tab-bar -->

        <!-- The contents for all the tabs -->
        <div class="tab-content">
            <!-- New Suggestions -->
            <div id="highlighter" class="tab-pane fade">
                <h2>Feature Suggestions</h2>
                <?php foreach ($suggestedPosts as $post): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                        <div class="row bg-info" style="padding: 0 15px 0px 10px;">
                            <h4 class="pull-left">Post #<?= $post->id; ?>: <?= $post->title; ?></h4>
                            <h4 class="pull-right"><?= (new DateTime($post->created_on))->format('d/m/Y H:i'); ?></h4>
                            <span class="label label-info">Feature</span>
                        </div>
                        <?php foreach ($featureSuggestionsByPost[$post->id] as $featureSuggestion): ?>
                            <div class="row" style="margin-top: 5px; padding: 0 10px 0 10px;">
                                <div class="row bg-offwhite" style="border-radius: 10px;">
                                    <div class="col-md-3 col-sm-3 col-xs-4">
                                        <p style="margin-bottom: 0;"><b><?= $featureSuggestion->sender_name ? ucwords(strtolower($featureSuggestion->sender_name)) : 'N/A'; ?></b></p>
                                        <p style="margin-top: 0;"><b><?= $featureSuggestion->sender_email ? strtolower($featureSuggestion->sender_email) : 'N/A'; ?></b></p>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-8"><p><?= $featureSuggestion->content; ?></p></div>
                                    <div class="row" style="margin-left: 20px;">
                                        <?= $this->Form->postLink('Highlight',
                                            ['controller' => 'Messages', 'action' => 'highlighter', '?' => ['sid' => $featureSuggestion->id, 'form' => '0']],
                                            ['class' => 'btn btn-outline btn-outline-sm outline-dim', 'confirm' => __('Highlight suggestion #{0}?', $featureSuggestion->id)]); ?>
                                        <?= $this->Form->postLink('Un-open',
                                            ['controller' => 'Messages', 'action' => 'highlighter', '?' => ['sid' => $featureSuggestion->id, 'form' => '1']],
                                            ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Mark suggestion #{0} as unread?', $featureSuggestion->id)]); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <h2>Project Suggestions</h2>
                <?php foreach ($openedPostSuggestions as $suggestion): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                        <div class="bg-offwhite" style="border-radius: 10px;">
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <p style="margin-bottom: 0;"><b><?= $suggestion->sender_name ? ucwords(strtolower($suggestion->sender_name)) : 'N/A'; ?></b></p>
                                <p style="margin-top: 0;"><b><?= $suggestion->sender_email ? strtolower($suggestion->sender_email) : 'N/A'; ?></b></p>
                                <span class="label label-info">Post</span>
                            </div>
                            <div class="col-md-10 col-sm-9 col-xs-8"><p><?= $suggestion->content; ?></p></div>
                            <div class="row" style="margin-left: 20px;">
                                <?= $this->Form->postLink('Highlight',
                                    ['controller' => 'Messages', 'action' => 'highlighter', '?' => ['sid' => $suggestion->id, 'form' => '0']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-dim', 'confirm' => __('Highlight suggestion #{0}?', $suggestion->id)]); ?>
                                <?= $this->Form->postLink('Un-open',
                                    ['controller' => 'Messages', 'action' => 'highlighter', '?' => ['sid' => $suggestion->id, 'form' => '1']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Mark suggestion #{0} as unread?', $suggestion->id)]); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <h2>Contact Messages</h2>
                <?php foreach ($openedContactors as $openedContactor): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                        <div class="bg-offwhite" style="border-radius: 10px;">
                            <div class="col-md-3 col-sm-3 col-xs-4">
                                <p style="margin-bottom: 0;"><b><?= ucwords(strtolower($openedContactor->sender_name)); ?></b></p>
                                <p style="margin-top: 0;"><b><?= strtolower($openedContactor->sender_email); ?></b></p>
                                <p style="margin-top: 0;"><b><?= $openedContactor->phone ? $openedContactor->phone : 'N/A'; ?></b></p>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-8"><p><?= $openedContactor->content; ?></p></div>
                            <div class="row" style="margin-left: 20px;">
                                <?= $this->Form->postLink('Highlight',
                                    ['controller' => 'Messages', 'action' => 'highlighter', '?' => ['sid' => $openedContactor->id, 'form' => '0']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-dim', 'confirm' => __('Highlight suggestion #{0}?', $openedContactor->id)]); ?>
                                <?= $this->Form->postLink('Un-open',
                                    ['controller' => 'Messages', 'action' => 'highlighter', '?' => ['sid' => $openedContactor->id, 'form' => '1']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Mark suggestion #{0} as unread?', $openedContactor->id)]); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- End New Suggestions -->

            <!-- New Comments & Replies -->
            <div id="suggestions" class="tab-pane fade in active">
                <h2>Feature Suggestions</h2>
                <?php foreach ($postsContainHighlightedSuggestions as $post): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                        <div class="row bg-info" style="padding: 0 15px 0px 10px;">
                            <h4 class="pull-left">Post #<?= $post->id; ?>: <?= $post->title; ?></h4>
                            <h4 class="pull-right"><?= (new DateTime($post->created_on))->format('d/m/Y H:i'); ?></h4>
                            <span class="label label-info">Feature</span>
                        </div>
                        <?php foreach ($highlightedFeatureSuggestionsByPost[$post->id] as $featureSuggestion): ?>
                            <div class="row" style="margin-top: 5px; padding: 0 10px 0 10px;">
                                <div class="row bg-offwhite" style="border-radius: 10px;">
                                    <div class="col-md-3 col-sm-3 col-xs-4">
                                        <p style="margin-bottom: 0;"><b><?= $featureSuggestion->sender_name ? ucwords(strtolower($featureSuggestion->sender_name)) : 'N/A'; ?></b></p>
                                        <p style="margin-top: 0;"><b><?= $featureSuggestion->sender_email ? strtolower($featureSuggestion->sender_email) : 'N/A'; ?></b></p>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-8"><p><?= $featureSuggestion->content; ?></p></div>
                                    <div class="row" style="margin-left: 20px;">
                                        <?= $this->Form->postLink('Lowlight',
                                            ['controller' => 'Messages', 'action' => 'lowlighter', '?' => ['sid' => $featureSuggestion->id, 'form' => '0']],
                                            ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Lowlight suggestion #{0}?', $featureSuggestion->id)]); ?>
                                        <?= $this->Form->postLink('Suspend',
                                            ['controller' => 'Messages', 'action' => 'lowlighter', '?' => ['sid' => $featureSuggestion->id, 'form' => '1']],
                                            ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Lowlight and suspend suggestion #{0}?', $featureSuggestion->id)]); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <h2>Project Suggestions</h2>
                <?php foreach ($highlightedPostSuggestions as $suggestion): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                        <div class="bg-offwhite" style="border-radius: 10px;">
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <p style="margin-bottom: 0;"><b><?= $suggestion->sender_name ? ucwords(strtolower($suggestion->sender_name)) : 'N/A'; ?></b></p>
                                <p style="margin-top: 0;"><b><?= $suggestion->sender_email ? strtolower($suggestion->sender_email) : 'N/A'; ?></b></p>
                                <span class="label label-info">Post</span>
                            </div>
                            <div class="col-md-10 col-sm-9 col-xs-8"><p><?= $suggestion->content; ?></p></div>
                            <div class="row" style="margin-left: 20px;">
                                <?= $this->Form->postLink('Lowlight',
                                    ['controller' => 'Messages', 'action' => 'lowlighter', '?' => ['sid' => $suggestion->id, 'form' => '0']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Lowlight suggestion #{0}?', $suggestion->id)]); ?>
                                <?= $this->Form->postLink('Suspend',
                                    ['controller' => 'Messages', 'action' => 'lowlighter', '?' => ['sid' => $suggestion->id, 'form' => '1']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Lowlight and suspend suggestion #{0}?', $suggestion->id)]); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- End New Comments & Replies -->

            <!-- New Suggestions -->
            <div id="messages" class="tab-pane fade">
                <?php foreach ($highlightedContactors as $highlightedContactor): ?>
                    <div class="row" style="border-bottom: 1px solid #3498DB; padding-left: 10px; margin-bottom: 15px;">
                        <div class="bg-offwhite" style="border-radius: 10px;">
                            <div class="col-md-3 col-sm-3 col-xs-4">
                                <p style="margin-bottom: 0;"><b><?= ucwords(strtolower($highlightedContactor->sender_name)); ?></b></p>
                                <p style="margin-top: 0;"><b><?= strtolower($highlightedContactor->sender_email); ?></b></p>
                                <p style="margin-top: 0;"><b><?= $highlightedContactor->phone ? $highlightedContactor->phone : 'N/A'; ?></b></p>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-8"><p><?= $highlightedContactor->content; ?></p></div>
                            <div class="row" style="margin-left: 20px;">
                                <?= $this->Form->postLink('Lowlight',
                                    ['controller' => 'Messages', 'action' => 'lowlighter', '?' => ['sid' => $highlightedContactor->id, 'form' => '0']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'confirm' => __('Lowlight suggestion #{0}?', $highlightedContactor->id)]); ?>
                                <?= $this->Form->postLink('Suspend',
                                    ['controller' => 'Messages', 'action' => 'lowlighter', '?' => ['sid' => $highlightedContactor->id, 'form' => '1']],
                                    ['class' => 'btn btn-outline btn-outline-sm outline-light', 'confirm' => __('Lowlight and suspend suggestion #{0}?', $highlightedContactor->id)]); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- End New Suggestions -->
        </div>
        <!-- End contents -->
    </div>
</div>
