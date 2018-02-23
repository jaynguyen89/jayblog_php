<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Distribution $distribution
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $distribution->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $distribution->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Distributions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="distributions form large-9 medium-8 columns content">
    <?= $this->Form->create($distribution) ?>
    <fieldset>
        <legend><?= __('Edit Distribution') ?></legend>
        <?php
            echo $this->Form->control('post_id', ['options' => $posts]);
            echo $this->Form->control('category_id', ['options' => $categories]);
            echo $this->Form->control('main');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
