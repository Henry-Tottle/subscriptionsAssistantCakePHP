<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Book> $books
 */
?>
<div class="books index content">
    <?= $this->Html->link(__('New Book'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index'], ['class' => 'side-nav-item']) ?>

    <h3><?= __('Books') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('isbn') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('author') ?></th>
                    <th><?= $this->Paginator->sort('format') ?></th>
                    <th><?= $this->Paginator->sort('pubDate') ?></th>
                    <th><?= $this->Paginator->sort('publisher') ?></th>
                    <th><?= $this->Paginator->sort('subject') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th><?= $this->Paginator->sort('picksCount') ?></th>
                    <th><?= $this->Paginator->sort('image') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $this->Number->format($book->id) ?></td>
                    <td><?= h($book->isbn) ?></td>
                    <td><?= h($book->title) ?></td>
                    <td><?= h($book->author) ?></td>
                    <td><?= h($book->format) ?></td>
                    <td><?= h($book->pubDate) ?></td>
                    <td><?= h($book->publisher) ?></td>
                    <td><?= h($book->subject) ?></td>
                    <td><?= h($book->price) ?></td>
                    <td><?= $book->picksCount === null ? '' : $this->Number->format($book->picksCount) ?></td>
                    <td><img src="https://jackets.dmmserver.com/media/140/<?= h($book->image) ?>.jpg" /></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $book->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $book->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $book->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $book->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
