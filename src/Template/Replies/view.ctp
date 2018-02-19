<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reply $reply
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Reply'), ['action' => 'edit', $reply->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reply'), ['action' => 'delete', $reply->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reply->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Replies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reply'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="replies view large-9 medium-8 columns content">
    <h3><?= h($reply->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Comment') ?></th>
            <td><?= $reply->has('comment') ? $this->Html->link($reply->comment->id, ['controller' => 'Comments', 'action' => 'view', $reply->comment->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Replier Name') ?></th>
            <td><?= h($reply->replier_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Replier Email') ?></th>
            <td><?= h($reply->replier_email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Content') ?></th>
            <td><?= h($reply->content) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo') ?></th>
            <td><?= h($reply->photo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File') ?></th>
            <td><?= h($reply->file) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($reply->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reply Date') ?></th>
            <td><?= h($reply->reply_date) ?></td>
        </tr>
    </table>
</div>
