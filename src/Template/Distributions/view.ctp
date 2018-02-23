<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Distribution $distribution
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Distribution'), ['action' => 'edit', $distribution->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Distribution'), ['action' => 'delete', $distribution->id], ['confirm' => __('Are you sure you want to delete # {0}?', $distribution->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Distributions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Distribution'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="distributions view large-9 medium-8 columns content">
    <h3><?= h($distribution->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Post') ?></th>
            <td><?= $distribution->has('post') ? $this->Html->link($distribution->post->title, ['controller' => 'Posts', 'action' => 'view', $distribution->post->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $distribution->has('category') ? $this->Html->link($distribution->category->title, ['controller' => 'Categories', 'action' => 'view', $distribution->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($distribution->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Main') ?></th>
            <td><?= $distribution->main ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
