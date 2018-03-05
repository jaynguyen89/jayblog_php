<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vote $vote
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Vote'), ['action' => 'edit', $vote->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vote'), ['action' => 'delete', $vote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vote->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Votes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vote'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="votes view large-9 medium-8 columns content">
    <h3><?= h($vote->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Post') ?></th>
            <td><?= $vote->has('post') ? $this->Html->link($vote->post->title, ['controller' => 'Posts', 'action' => 'view', $vote->post->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client Ip') ?></th>
            <td><?= h($vote->client_ip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($vote->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vote Date') ?></th>
            <td><?= h($vote->vote_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sign') ?></th>
            <td><?= $vote->sign ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
