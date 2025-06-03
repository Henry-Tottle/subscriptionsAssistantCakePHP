<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface|\App\Model\Entity\Tag[] $tags
 */
?>
<?php echo $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index'], ['class' => 'side-nav-item'])
?>
<div class="tags index content">
    <h3><?= __('Tags') ?></h3>

    <ul>
        <?php foreach ($tags as $tag): ?>
            <li>
                <?= $this->Html->link(h($tag->tag ?? 'Unnamed tag'), ['action' => 'view', $tag->id]) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(
                __('Page {{page}} of {{pages}}, showing {{current}} tag(s) out of {{count}} total')
            ) ?></p>
    </div>
</div>
