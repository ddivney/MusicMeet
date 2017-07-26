<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Relationships'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="relationships form large-9 medium-8 columns content">
    <?= $this->Form->create($relationship) ?>
    <fieldset>
        <legend><?= __('Add Relationship') ?></legend>
        <?php
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
