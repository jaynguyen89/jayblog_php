<div class="categories form large-9 medium-8 columns content">
    <h2>Admin: Jay Nguyen</h2>
    <?= $this->Form->create($category) ?>
    <fieldset>
        <legend><?= __('Edit Category') ?></legend>
        <div class="row">
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="row">
                    <div class="col-xs-1"><b>Type</b></div>
                    <div class="col-xs-11">
                        <select name="type" class="form-control">
                            <option value="0">Interests Post</option>
                            <option value="1">Projects Post</option>
                            <option value="2">Others Post</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="row">
                    <div class="col-xs-1"><b>Title</b></div>
                    <div class="col-xs-11"><?= $this->Form->control('title', ['placeholder' => 'Category Title', 'label' => false, 'class' => 'form-control']);; ?></div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 10px;">
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="row">
                    <div class="col-xs-1"><b>Icon</b></div>
                    <div class="col-xs-11">
                        <?= $this->Form->control('description', ['placeholder' => 'Category Icon', 'label' => false, 'class' => 'form-control']);; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top: 10px;">
                <div class="row">
                    <div class="col-xs-1"><b>Note</b></div>
                    <div class="col-xs-11"><?= $this->Form->control('note', ['placeholder' => 'Note', 'label' => false, 'class' => 'form-control']);; ?></div>
                </div>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline btn-outline-sm outline-dark']) ?>
    <?= $this->Form->end() ?>
</div>
