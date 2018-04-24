<div class="container">
    <!-- Section contains latest posts and projects -->
    <section id="content-1-9" class="content-1-9 content-block" style="padding-bottom: 10px;">
        <!-- Section title -->
        <div class="container">
            <div class="underlined-title">
                <h1>My latest work</h1>
                <hr>
                <p class="lead">A project is considered <span class="label label-success" style="font-size: 0.65em;">Completed</span> if at least 90% of its product backlog items are done.</p>
            </div>
        </div>
        <!-- End section title -->

        <!-- Row containing recent projects -->
        <div class="row">
            <?php foreach($latestPosts as $latestPost): ; ?>
            <div class="col-md-6">
                <!-- Card containing a single project -->
                <div class="card">
                    <!-- Project title -->
                    <h3 class="card-header"><b><?= $latestPost->title; ?></b></h3>

                    <!-- Row containing general project information -->
                    <div class="row">
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <?= $this->Html->image($latestPost->photo, ['class' => 'img-responsive', 'style' => 'border: 1px groove #3498DB; border-radius: 7px;', 'alt' => 'jayblogpreview']); ?>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Status: 
                                    <?= ($latestPost->status == 1) ? '<span class="label label-info pull-right" style="font-size: 1em;">Progressing</span>' : '<span class="label label-success pull-right" style="font-size: 1em;">Completed</span>' ?>
                                </li>
                                <li class="list-group-item">Posted on: <b class="pull-right"><?= (new DateTime($latestPost->created_on))->format('d/m/Y H:i'); ?></b></li>
                                <li class="list-group-item">Updated: <b class="pull-right"><?= (new DateTime($latestPost->updated_on))->format('d/m/Y H:i'); ?></b></li>
                                <li class="list-group-item">Comments: <b class="pull-right"><?= $commentsByPost[$latestPost->id]; ?></b></li>
                                <li class="list-group-item">Likes: <b class="pull-right"><?= $likesByPost[$latestPost->id]; ?></b></li>
                                <li class="list-group-item">Type:
                                    <div class="pull-right">
                                        <?php $mainCategory = null; foreach ($categoriesByPost[$latestPost->id] as $category):
                                            if ($category->main) {
                                                $mainCategory = $category;
                                                echo '<a data-toggle="tooltip" title="'.$category->title.'" style="margin-right: 5px;"><i class="'.$category->description.' fa-2x"></i></a>';
                                            } else
                                                echo '<a data-toggle="tooltip" title="'.$category->title.'"><i class="'.$category->description.' fa-2x" style="color: gray; margin-right: 5px;" onmouseover="this.style.color=\'dimgray\'" onmouseout="this.style.color=\'gray\'"></i></a>';
                                            endforeach; ?>
                                    </div></li>
                            </ul>
                            <p class="small"><?= $latestPost->note ? $latestPost->note : 'N/A'; ?></p>
                        </div>
                    </div>
                    <!-- End row of general project info -->

                    <!-- JS code that is called when suggest link is clicked -->
                    <script type="text/javascript">
                        function passDataToSuggestFeatureForm<?= $latestPost->id; ?>() {
                            var postIdInput = document.getElementById('postIdInput');
                            postIdInput.value = '<?= $latestPost->id; ?>';

                            var postTitleInput = document.getElementById('postTitleInput');
                            postTitleInput.value = '<?= $latestPost->title; ?>';
                        }
                    </script>
                    <!-- End JS -->

                    <!-- Row containing brief project introduction -->
                    <div class="row">
                        <div class="card-block">
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                <p class="card-text"><?= $latestPost->description; ?></p>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12"><?= $this->Html->link('Open', ['action' => ($mainCategory->type == 2 ? 'othersView' : 'view'), $latestPost->id], ['class' => 'btn btn-outline btn-outline-sm outline-dark']); ?></div>
                        </div>
                    </div>
                    <!-- End row of brief project intro -->
                </div>
                <!-- End card -->
            </div>
            <?php endforeach; ?>
        </div>
        <!-- End row of recent projects -->
    </section>
    <!-- End section -->

    <!-- Section contains past posts and projects -->
    <section id="content-1-9" class="content-1-9 content-block" style="padding-bottom: 10px;">
        <!-- Section title -->
        <div class="container">
            <div class="underlined-title">
                <h1>Find out more</h1>
                <hr>
                <p class="lead" style="margin-bottom: 0;">Those projects that are older than 3 months.</p>
            </div>
        </div>
        <!-- End section title -->

        <div class="row" style="margin: 0 5px 0 5px;">
            <div class="row">
                <div class="row">
                    <div class="col-xs-6"><h4><b>My Posts</b></h4></div>
                    <div class="col-xs-6 text-right">
                        <div class="dropdown">
                            <button class="dropdown-toggle" role="button" data-toggle="dropdown">
                                See more <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-crosshairs', 'style' => 'margin-right: 10px;']).'My Interests',
                                        ['controller' => 'Posts', 'action' => 'interestPosts'], ['escape' => false]); ?></li>
                                <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-folder-open', 'style' => 'margin-right: 10px;']).'My Projects',
                                        ['controller' => 'Posts', 'action' => 'projectPosts'], ['escape' => false]); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table bg-offwhite" style="border-radius: 10px;">
                            <thead><tr><th>#</th><th>Type</th><th>Title</th><th>Status</th><th>Posted on</th></tr></thead>
                            <tbody>
                            <?php if (count($oldInterestPosts) == 0 && count($oldProjectPosts) == 0)
                                echo '<tr class="text-center"><td colspan="3" class="text-center">Awaiting update</td></tr>';
                            else { $j = 0;
                                for ($i = 0; $i < count($oldInterestPosts); $i++) { ?>
                                    <tr>
                                        <th><?= $i + 1; ?></th>
                                        <td class="small"><a data-toggle="tooltip" title="<?= $oldInterestPosts[$i]->category; ?>" style="margin-right: 5px;"><i class="<?= $oldInterestPosts[$i]->description; ?>"></i></a> <?= $oldInterestPosts[$i]->category; ?></td>
                                        <td><?= $this->Html->link($oldInterestPosts[$i]->title, ['controller' => 'Posts', 'action' => 'view', $oldInterestPosts[$i]->id]); ?></td>
                                        <td><?= $oldInterestPosts[$i]->status ? '<span class="label label-info">Progressing</span>' : '<span class="label label-success">completed</span>'; ?></td>
                                        <td><?= (new DateTime($oldInterestPosts[$i]->created_on))->format('d/m/Y H:i'); ?></td>
                                    </tr>
                                <?php $j = $i; }

                                for ($i = 0; $i < count($oldProjectPosts); $i++) {?>
                                    <tr>
                                        <th><?= $j + 2; ?></th>
                                        <td class="small"><a data-toggle="tooltip" title="<?= $oldProjectPosts[$i]->category; ?>" style="margin-right: 5px;"><i class="<?= $oldProjectPosts[$i]->description; ?>"></i></a> <?= $oldProjectPosts[$i]->category; ?></td>
                                        <td><?= $this->Html->link($oldProjectPosts[$i]->title, ['controller' => 'Posts', 'action' => 'view', $oldProjectPosts[$i]->id]); ?></td>
                                        <td><?= $oldProjectPosts[$i]->status ? '<span class="label label-info">Progressing</span>' : '<span class="label label-success">Completed</span>'; ?></td>
                                        <td><?= (new DateTime($oldProjectPosts[$i]->created_on))->format('d/m/Y H:i'); ?></td>
                                    </tr>
                                <?php $j++; }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-xs-6"><h4><b>Others</b></h4></div>
                        <div class="col-xs-6 text-right">
                            <div class="dropdown">
                              <button class="dropdown-toggle" role="button" data-toggle="dropdown">See more
                              <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'far fa-newspaper', 'style' => 'margin-right: 10px;']).'IT News',
                                    ['controller' => 'Posts', 'action' => 'newsOthers'], ['escape' => false]); ?></li>
                                <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'far fa-lightbulb', 'style' => 'margin-right: 10px;']).'Tips & Tricks',
                                    ['controller' => 'Posts', 'action' => 'tiptrickOthers'], ['escape' => false]); ?></li>
                              </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table bg-offwhite" style="border-radius: 10px;">
                            <thead><tr><th>#</th><th class="text-center">Type</th><th>Title</th></tr></thead>
                            <tbody>
                            <?php if (count($oldOtherPosts) == 0)
                                echo '<tr class="text-center"><td colspan="3" class="text-center">Awaiting update</td></tr>';
                            else for ($i = 0; $i < count($oldOtherPosts); $i++) { ?>
                                <tr>
                                    <th scope="row"><?= $i + 1; ?></th>
                                    <td class="text-center"><?= '<a data-toggle="tooltip" title="'.$oldOtherPosts[$i]->category.'" style="margin-right: 5px;"><i class="'.$oldOtherPosts[$i]->description.'"></i></a>';?></td>
                                    <td><?= $this->Html->link($oldOtherPosts[$i]->title, ['action' => 'othersView', $oldOtherPosts[$i]->id]); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-12">
                    <h4><b>Proposed</b></h4>
                    <div class="table-responsive">
                        <table class="table bg-offwhite" style="border-radius: 10px;">
                            <thead><tr><th>#</th><th class="text-center">Type</th><th>Title</th></tr></thead>
                            <tbody>
                            <?php if (count($proposedPosts) == 0)
                                echo '<tr class="text-center"><td colspan="3" class="text-center">Awaiting update</td></tr>';
                            else for ($i = 0; $i < count($proposedPosts); $i++) { ?>
                                <tr>
                                    <th scope="row"><?= $i + 1; ?></th>
                                    <td class="text-center"><?= '<a data-toggle="tooltip" title="'.$proposedPosts[$i]->category.'" style="margin-right: 5px;"><i class="'.$proposedPosts[$i]->description.'"></i></a>';?></td>
                                    <td><?= $this->Html->link($proposedPosts[$i]->title, ['action' => 'othersView', $proposedPosts[$i]->id]); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- End section -->
</div>

