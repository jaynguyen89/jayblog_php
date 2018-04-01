<?php if ($form == 0) { ?>
    <div class="container">
        <div class="row" style="min-height: 622px;">
            <h2>Admin: Jay Nguyen</h2>
            <?= $this->Form->create($post) ?>
            <fieldset>
                <legend><?= __('Edit Post Contents') ?></legend>
                <div class="row">
                    <div class="col-xs-1"><b>Title</b></div>
                    <div class="col-xs-11"><?= $this->Form->control('title',
                            ['placeholder' => 'Post Title', 'label' => false, 'value' => $post->title, 'type' => 'text', 'class' => 'form-control']); ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-1"><b>Desc</b></div>
                    <div class="col-xs-11"><?= $this->Form->textarea('description',
                            ['placeholder' => 'Post Description', 'label' => false, 'value' => $post->description, 'class' => 'form-control', 'style' => 'margin-top: 10px;', 'rows' => '2', 'resize' => 'none']); ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-1"><b>Note</b></div>
                    <div class="col-xs-11"><?= $this->Form->control('note',
                            ['placeholder' => 'Optional Notes', 'label' => false, 'value' => $post->note, 'class' => 'form-control', 'style' => 'margin-top: 10px;']); ?></div>
                </div>
                <div class="row" style="margin-top: 15px; margin-bottom: 10px;">
                    <textarea id="editor1" name="content" rows="10" cols="90"></textarea>
                </div>
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'style' => 'margin-top: 10px;']) ?>
            </fieldset>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } else { ?>
    <div class="container">
        <div class="row" style="min-height: 622px;">
            <h2>Admin: Jay Nguyen</h2>
            <?= $this->Form->create($post) ?>
            <fieldset>
                <legend><?= __('Edit General Information') ?></legend>
                <div class="row">
                    <div class="col-xs-2"><b>Post</b></div>
                    <div class="col-xs-10"><b><?= $post->title; ?></b></div>
                </div>
                <div class="row">
                    <div class="col-xs-2"><b>Task Total</b></div>
                    <div class="col-xs-10"><?= $this->Form->control('task_total',
                            ['placeholder' => 'Total Tasks', 'label' => false, 'value' => $post->task_total, 'type' => 'number', 'class' => 'form-control', 'style' => 'margin-top: 10px;']); ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-2"><b>Task Done</b></div>
                    <div class="col-xs-10"><?= $this->Form->control('task_done',
                            ['placeholder' => 'Done Tasks', 'label' => false, 'value' => $post->task_done, 'type' => 'number', 'class' => 'form-control', 'style' => 'margin-top: 10px;']); ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-2"><b>Front Photo</b></div>
                    <div class="col-xs-10"><?= $this->Form->control('photo',
                            ['placeholder' => 'Photo Name', 'label' => false, 'value' => $post->photo, 'class' => 'form-control', 'style' => 'margin-top: 10px;']); ?></div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-xs-2"><b>Status</b></div>
                    <div class="col-sm-3 col-xs-12"><input type="radio" name="status" value="0" <?= $post->status == 0 ? 'checked' : ''; ?> /> Completed</div>
                    <div class="col-sm-3 col-xs-12"><input type="radio" name="status" value="1" <?= $post->status == 1 ? 'checked' : ''; ?> /> Progressing</div>
                    <div class="col-sm-3 col-xs-12"><input type="radio" name="status" value="2" <?= $post->status == 2 ? 'checked' : ''; ?> /> Proposed</div>
                </div>
                <div class="row">
                    <p><b>Categories</b></p>
                    <?php foreach ($categories as $category): ?>
                        <div class="col-sm-4 col-xs-6" style="margin-top: 10px;">
                            <input type="checkbox" name="category[]" value="<?= $category->id; ?>" <?= (in_array($category->id, $postCateIds)) ? 'checked' : ''; ?>>
                            <i class="<?= $category->description; ?>" style="color: #3498DB;"></i> <?= $category->title; ?>
                            <input type="radio" name="main" value="<?= $category->id; ?>" <?= $mainCate[$category->id] ? 'checked' : ''; ?>> main
                        </div>
                    <?php endforeach; ?>
                </div>
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'style' => 'margin-top: 15px;']) ?>
            </fieldset>
            <?= $this->Form->end(); ?>
        </div>
    </div>
<?php } ?>
