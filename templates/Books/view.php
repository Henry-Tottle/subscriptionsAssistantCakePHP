<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Book'), ['action' => 'edit', $book->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Book'), ['action' => 'delete', $book->id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Books'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Book'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="books view content">
            <h3><?= h($book->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Image') ?></th>
                    <td><img src="https://jackets.dmmserver.com/media/140/<?=h($book->image)?>.jpg"/></td>
                </tr>
                <tr>
                    <th><?= __('Isbn') ?></th>
                    <td><?= h($book->isbn) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($book->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Author') ?></th>
                    <td><?= h($book->author) ?></td>
                </tr>
                <tr>
                    <th><?= __('Format') ?></th>
                    <td><?= h($book->format) ?></td>
                </tr>
                <tr>
                    <th><?= __('Publisher') ?></th>
                    <td><?= h($book->publisher) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subject') ?></th>
                    <td><?= h($book->subject) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= h($book->price) ?></td>
                </tr>

                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($book->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('PicksCount') ?></th>
                    <td><?= $book->picksCount === null ? '' : $this->Number->format($book->picksCount) ?></td>
                </tr>
                <tr>
                    <th><?= __('PubDate') ?></th>
                    <td><?= h($book->pubDate) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Tags') ?></h4>
                <?php if (!empty($book->tags)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Book Id') ?></th>
                            <th><?= __('Tag') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($book->tags as $tag) : ?>
                        <tr>
                            <td><?= h($tag->id) ?></td>
                            <td><?= h($tag->book_id) ?></td>
                            <td><?= h($tag->tag) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Tags', 'action' => 'view', $tag->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Tags', 'action' => 'edit', $tag->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Tags', 'action' => 'delete', $tag->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $tag->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
