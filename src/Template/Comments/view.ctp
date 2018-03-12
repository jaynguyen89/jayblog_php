<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment $comment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Comment'), ['action' => 'edit', $comment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Comment'), ['action' => 'delete', $comment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Comments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Replies'), ['controller' => 'Replies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reply'), ['controller' => 'Replies', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="comments view large-9 medium-8 columns content">
    <h3><?= h($comment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Post') ?></th>
            <td><?= $comment->has('post') ? $this->Html->link($comment->post->title, ['controller' => 'Posts', 'action' => 'view', $comment->post->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Commenter Name') ?></th>
            <td><?= h($comment->commenter_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Commenter Email') ?></th>
            <td><?= h($comment->commenter_email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($comment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comment Date') ?></th>
            <td><?= h($comment->comment_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $comment->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Content') ?></h4>
        <?= $this->Text->autoParagraph(h($comment->content)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Replies') ?></h4>
        <?php if (!empty($comment->replies)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Comment Id') ?></th>
                <th scope="col"><?= __('Reply Date') ?></th>
                <th scope="col"><?= __('Replier Name') ?></th>
                <th scope="col"><?= __('Replier Email') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($comment->replies as $replies): ?>
            <tr>
                <td><?= h($replies->id) ?></td>
                <td><?= h($replies->comment_id) ?></td>
                <td><?= h($replies->reply_date) ?></td>
                <td><?= h($replies->replier_name) ?></td>
                <td><?= h($replies->replier_email) ?></td>
                <td><?= h($replies->content) ?></td>
                <td><?= h($replies->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Replies', 'action' => 'view', $replies->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Replies', 'action' => 'edit', $replies->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Replies', 'action' => 'delete', $replies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $replies->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
