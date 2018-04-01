<div class="container">
    <h2>Admin: Jay Nguyen</h2>
    <div class="row">
        <div class="table-responsive">
            <table class="table bg-offwhite" style="border-radius: 10px;">
                <thead><tr><th>#</th><th>Type</th><th>Title</th><th>Icon</th><th>Note</th><th>Actions</th></tr></thead>
                <tbody>
                <?php foreach ($categories as $cate): ?>
                    <tr>
                        <th><?= $cate->id; ?></th>
                        <td><?= $cate->type == 0 ? 'Interests' : ($cate->type == 1 ? 'Projects' : 'Others'); ?></td>
                        <td><?= $cate->title; ?></td>
                        <td><i class="<?= $cate->description; ?>" style="color: #3498DB;"></i> <?= $cate->description; ?></td>
                        <td><?= $cate->note ? $cate->note : 'N/A'; ?></td>
                        <td>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cate->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cate->id],
                                ['class' => 'pull-right', 'confirm' => __('Delete category #{0}?', $cate->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="categories form large-9 medium-8 columns content">
    <?= $this->Form->create($category) ?>
    <fieldset>
        <legend><?= __('New Category') ?></legend>
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
