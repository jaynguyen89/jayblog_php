<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reply[]|\Cake\Collection\CollectionInterface $replies
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Reply'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="replies index large-9 medium-8 columns content">
    <h3><?= __('Replies') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reply_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('replier_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('replier_email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('content') ?></th>
                <th scope="col"><?= $this->Paginator->sort('photo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('file') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($replies as $reply): ?>
            <tr>
                <td><?= $this->Number->format($reply->id) ?></td>
                <td><?= $reply->has('comment') ? $this->Html->link($reply->comment->id, ['controller' => 'Comments', 'action' => 'view', $reply->comment->id]) : '' ?></td>
                <td><?= h($reply->reply_date) ?></td>
                <td><?= h($reply->replier_name) ?></td>
                <td><?= h($reply->replier_email) ?></td>
                <td><?= h($reply->content) ?></td>
                <td><?= h($reply->photo) ?></td>
                <td><?= h($reply->file) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $reply->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reply->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reply->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reply->id)]) ?>
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
