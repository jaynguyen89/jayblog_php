<div class="posts form large-9 medium-8 columns content">
    <h2>Admin: Jay Nguyen</h2>
    <?= $this->Form->create($post) ?>
    <fieldset>
        <legend><?= __('New Post') ?></legend>
        <div class="row">
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="col-xs-1"><b>Title</b></div>
                <div class="col-xs-11"><?= $this->Form->control('title', ['placeholder' => 'Post Title', 'class' => 'form-control', 'label' => false]); ?></div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="col-xs-1"><b>Photo</b></div>
                <div class="col-xs-11"><?= $this->Form->control('photo', ['placeholder' => 'Photo Name', 'class' => 'form-control', 'label' => false]); ?></div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="col-xs-1"><b>Tasks</b></div>
                <div class="col-xs-11"><?= $this->Form->control('task_total', ['placeholder' => 'Task Total', 'class' => 'form-control', 'label' => false]); ?></div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="col-xs-1"><b>Done</b></div>
                <div class="col-xs-11"><?= $this->Form->control('task_done', ['placeholder' => 'Task Done', 'class' => 'form-control', 'label' => false]); ?></div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="col-xs-1"><b>Status</b></div>
                <div class="col-xs-11">
                    <select class="form-control" name="status">
                        <option value="0">Completed</option>
                        <option value="1">Progressing</option>
                        <option value="2">Proposed</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="col-xs-1"><b>Note</b></div>
                <div class="col-xs-11"><?= $this->Form->control('note', ['placeholder' => 'Notes', 'class' => 'form-control', 'label' => false]); ?></div>
            </div>
            <div class="col-xs-12" style="margin-top: 10px;">
                <div class="col-xs-1" ><b>Desc</b></div>
                <div class="col-xs-11""><?= $this->Form->control('description', ['placeholder' => 'Description', 'class' => 'form-control', 'label' => false]); ?></div>
            </div>
            <div class="col-xs-12" style="margin-top: 10px;">
                <textarea id="editor1" name="content" rows="10" cols="90"></textarea>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="col-xs-2"><b>Created</b></div>
                <div class="col-xs-10"><?= $this->Form->control('created_on', ['empty' => true, 'class' => 'form-control', 'label' => false]); ?></div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="col-xs-2"><b>Updated</b></div>
                <div class="col-xs-10"><?= $this->Form->control('updated_on', ['empty' => true, 'class' => 'form-control', 'label' => false]); ?></div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;"><input name="context" type="radio" value="1" checked /> System sets date & time.</div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;"><input name="context" type="radio" value="0" /> Admin sets date & time.</div>
        </div>
    </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline btn-outline-sm outline-dark']); ?>
    <?= $this->Form->end(); ?>
</div>
