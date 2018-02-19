<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Message'), ['action' => 'edit', $message->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Message'), ['action' => 'delete', $message->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="messages view large-9 medium-8 columns content">
    <h3><?= h($message->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Post') ?></th>
            <td><?= $message->has('post') ? $this->Html->link($message->post->title, ['controller' => 'Posts', 'action' => 'view', $message->post->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sender Name') ?></th>
            <td><?= h($message->sender_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sender Email') ?></th>
            <td><?= h($message->sender_email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sender Phone') ?></th>
            <td><?= h($message->sender_phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($message->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($message->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Recieved On') ?></th>
            <td><?= h($message->recieved_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Content') ?></h4>
        <?= $this->Text->autoParagraph(h($message->content)); ?>
    </div>
</div>
