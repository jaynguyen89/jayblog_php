<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Distribution[]|\Cake\Collection\CollectionInterface $distributions
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Distribution'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="distributions index large-9 medium-8 columns content">
    <h3><?= __('Distributions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('post_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($distributions as $distribution): ?>
            <tr>
                <td><?= $this->Number->format($distribution->id) ?></td>
                <td><?= $distribution->has('post') ? $this->Html->link($distribution->post->title, ['controller' => 'Posts', 'action' => 'view', $distribution->post->id]) : '' ?></td>
                <td><?= $distribution->has('category') ? $this->Html->link($distribution->category->title, ['controller' => 'Categories', 'action' => 'view', $distribution->category->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $distribution->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $distribution->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $distribution->id], ['confirm' => __('Are you sure you want to delete # {0}?', $distribution->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
