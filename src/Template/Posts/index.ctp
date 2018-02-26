<div class="container">
    <!-- Section contains latest posts and projects -->
    <section id="content-1-9" class="content-1-9 content-block" style="padding-bottom: 10px;">
        <!-- Section title -->
        <div class="container">
            <div class="underlined-title">
                <h1>My latest work</h1>
                <hr>
                <p class="lead">Find here for the projects and researches that Jay was working on in the last 3 months.<br/>
                    A project is considered <span class="label label-success">Completed</span> if at least 90% of its product backlog items are completed.</p>
            </div>
        </div>
        <!-- End section title -->

        <!-- Row containing recent projects -->
        <div class="row" style="margin: 5px;">
            <?php foreach($latestPosts as $latestPost): ; ?>
            <div class="col-md-6">
                <!-- Card containing a single project -->
                <div class="card">
                    <!-- Project title -->
                    <h3 class="card-header"><b><?= $latestPost->title; ?></b><?= ($latestPost->status == 1) ? '<span class="label label-info pull-right">Progressing</span>' : '<span class="label label-success pull-right">Completed</span>' ?></h3>

                    <!-- Row containing general project information -->
                    <div class="row">
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <?= $this->Html->image($latestPost->photo, ['class' => 'img-responsive', 'style' => 'border: 1px groove #3498DB; border-radius: 7px;', 'alt' => 'jayblogpreview']); ?>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Posted on: <b class="pull-right"><?= (new DateTime($latestPost->created_on))->format('d/m/Y H:i'); ?></b></li>
                                <li class="list-group-item">Updated: <b class="pull-right"><?= (new DateTime($latestPost->updated_on))->format('d/m/Y H:i'); ?></b></li>
                                <li class="list-group-item">Comments: <b class="pull-right"><?= $commentsByPost[$latestPost->id]; ?></b></li>
                                <li class="list-group-item">Likes: <b class="pull-right"><?= $likesByPost[$latestPost->id]; ?></b></li>
                                <li class="list-group-item">Type:
                                    <div class="pull-right">
                                        <?php foreach ($categoriesByPost as $category):
                                            if ($category[1])
                                                echo '<a data-toggle="tooltip" title="'.$category[0]->title.'" style="margin-right: 5px;"><i class="'.$category[0]->description.' fa-2x"></i></a>';
                                            else
                                                echo '<a data-toggle="tooltip" title="'.$category[0]->title.'"><i class="'.$category[0]->description.' fa-2x" style="color: gray; margin-right: 5px;" onmouseover="this.style.color=\'dimgray\'" onmouseout="this.style.color=\'gray\'"></i></a>';
                                            endforeach; ?>
                                    </div></li>
                            </ul>
                            <p class="small">Please click <a role="button" onclick="passDataToForm()" data-toggle="modal" data-target="#login-modal">here</a> to suggest a feature or report a bug. Thanks!</p>
                        </div>
                    </div>
                    <!-- End row of general project info -->

                    <!-- JS code that is called when suggest link is clicked -->
                    <script type="text/javascript">
                        function passDataToForm() {
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
                            <div class="col-md-2 col-sm-2 col-xs-12"><?= $this->Html->link('Open', ['action' => 'view', $latestPost->id], ['class' => 'btn btn-outline btn-outline-sm outline-dark']); ?></div>
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

    <!-- This section contains the modal popup displaying a form that allows feature suggestion -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Popup header -->
                <div class="modal-header" align="center">
                    <?= $this->Html->image('jaydev.PNG', ['height' => '50px;', 'id' => 'img_logo']); ?>
                </div>

                <!-- Begin popup form -->
                <div id="div-forms">
                    <form id="login-form" method="post" action="/jayblog/messages/suggestProject">
                        <div class="modal-body">
                            <div id="div-login-msg"><h6><i class="fas fa-bullhorn" style="color: #3498DB;"></i> Please enter some optional information and your suggestion.</h6></div>
                            <div class="row">
                                <div class="text-center"><p id="featureFormError" class="small guardsman"></p></div>
                                <input type="hidden" name="form_id" value="1"/>
                                <input name="post_id" id="postIdInput" type="hidden"/>
                                <div class="col-xs-12"><input id="postTitleInput" name="post_title" class="form-control" type="text" readonly></div>
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

    <!-- Section contains past posts and projects -->
    <section id="content-1-9" class="content-1-9 content-block" style="padding-bottom: 10px;">
        <!-- Section title -->
        <div class="container">
            <div class="underlined-title">
                <h1>Find out more</h1>
                <hr>
                <p class="lead">Quickly have a look at some latest posts and projects that are older than 3 months.</p>
            </div>
        </div>
        <!-- End section title -->

        <div class="row" style="margin: 5px;">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-xs-6"><h4><b>My Interests</b></h4></div>
                        <div class="col-xs-6 text-right"><a href="#">See more</a></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table bg-offwhite" style="border-radius: 10px;">
                            <thead><tr><th>#</th><th>Type</th><th>Title</th></tr></thead>
                            <tbody>
                            <?php if (count($oldInterestPosts) == 0)
                                echo '<tr class="text-center"><td colspan="3" class="text-center">Awaiting update</td></tr>';
                            else for ($i = 0; $i < count($oldInterestPosts); $i++) { ?>
                                <tr>
                                    <th scope="row"><?= $i + 1; ?></th>
                                    <td><?= '<a data-toggle="tooltip" title="'.$oldInterestPosts[$i]->category.'" style="margin-right: 5px;"><i class="'.$oldInterestPosts[$i]->description.'"></i></a>';?></td>
                                    <td><?= $this->Html->link($oldInterestPosts[$i]->title, ['action' => 'view', $oldInterestPosts[$i]->id]); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-xs-6"><h4><b>Personal Projects</b></h4></div>
                        <div class="col-xs-6 text-right"><a href="#">See more</a></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table bg-offwhite" style="border-radius: 10px;">
                            <thead><tr><th>#</th><th>Type</th><th>title</th></tr></thead>
                            <tbody>
                            <?php if (count($oldProjectPosts) == 0)
                                echo '<tr class="text-center"><td colspan="3" class="text-center">Awaiting update</td></tr>';
                            else for ($i = 0; $i < count($oldProjectPosts); $i++) { ?>
                                <tr>
                                    <th scope="row"><?= $i + 1; ?></th>
                                    <td><?= '<a data-toggle="tooltip" title="'.$oldProjectPosts[$i]->category.'" style="margin-right: 5px;"><i class="'.$oldProjectPosts[$i]->description.'"></i></a>';?></td>
                                    <td><?= $this->Html->link($oldProjectPosts[$i]->title, ['action' => 'view', $oldProjectPosts[$i]->id]); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-xs-6"><h4><b>Other Studies</b></h4></div>
                        <div class="col-xs-6 text-right"><a href="#">See more</a></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table bg-offwhite" style="border-radius: 10px;">
                            <thead><tr><th>#</th><th>Type</th><th>Title</th></tr></thead>
                            <tbody>
                            <?php if (count($oldOtherPosts) == 0)
                                echo '<tr class="text-center"><td colspan="3" class="text-center">Awaiting update</td></tr>';
                            else for ($i = 0; $i < count($oldOtherPosts); $i++) { ?>
                                <tr>
                                    <th scope="row"><?= $i + 1; ?></th>
                                    <td><?= '<a data-toggle="tooltip" title="'.$oldOtherPosts[$i]->category.'" style="margin-right: 5px;"><i class="'.$oldOtherPosts[$i]->description.'"></i></a>';?></td>
                                    <td><?= $this->Html->link($oldOtherPosts[$i]->title, ['action' => 'view', $oldOtherPosts[$i]->id]); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-12">
                    <h4><b>Proposed Readings</b></h4>
                    <div class="table-responsive">
                        <table class="table bg-offwhite" style="border-radius: 10px;">
                            <thead><tr><th>#</th><th>Type</th><th>Title</th></tr></thead>
                            <tbody>
                            <?php if (count($proposedPosts) == 0)
                                echo '<tr class="text-center"><td colspan="3" class="text-center">Awaiting update</td></tr>';
                            else for ($i = 0; $i < count($proposedPosts); $i++) { ?>
                                <tr>
                                    <th scope="row"><?= $i + 1; ?></th>
                                    <td><?= '<a data-toggle="tooltip" title="'.$proposedPosts[$i]->category.'" style="margin-right: 5px;"><i class="'.$proposedPosts[$i]->description.'"></i></a>';?></td>
                                    <td><?= $this->Html->link($proposedPosts[$i]->title, ['action' => 'view', $proposedPosts[$i]->id]); ?></td>
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

