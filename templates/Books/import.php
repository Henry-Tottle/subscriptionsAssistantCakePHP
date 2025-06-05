<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>
<aside class="column">
    <div class="side-nav">
        <h4 class="heading"><?= __('Actions') ?></h4>
        <?= $this->Html->link(__('List Books'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
    </div>
</aside>
<div class="column column-80">
    <h1>Import Books from CSV</h1>
    <?= $this->Form->create(null, ['type' => 'file']) ?>
    <?= $this->Form->file('csv_file') ?>
    <?= $this->Form->button('Upload & Import') ?>
    <?= $this->Form->end() ?>
</div>

