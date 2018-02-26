<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reply $reply
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Replies'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="replies form large-9 medium-8 columns content">
    <?= $this->Form->create($reply) ?>
    <fieldset>
        <legend><?= __('Add Reply') ?></legend>
        <?php
            echo $this->Form->control('comment_id', ['options' => $comments]);
            echo $this->Form->control('reply_date', ['empty' => true]);
            echo $this->Form->control('replier_name');
            echo $this->Form->control('replier_email');
            echo $this->Form->control('content');
            echo $this->Form->control('photo');
            echo $this->Form->control('file');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
