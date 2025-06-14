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
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?PHP
                        if ($book->description) {
                            echo $book->description;
                        }
                        else
                        {
                            echo $this->Html->link(
                                __('Fetch Description'),
                                ['action' => 'fetchDescription', $book->id],
                                ['class' =>'button']
                            );
                        }
                        ?></td>
                </tr>
            </table>

            <div class="related">
                <h4><?= __('Related Reviews') ?></h4>
                <?= $this->Html->link(__('New Review'), ['controller' => 'Reviews','action' => 'add', '?' => ['book_id' => $book->id]], ['class' => 'side-nav-item']) ?>

                <?php if (!empty($book->reviews)): ?>
                    <div class="reviews">

                        <?php foreach ($book->reviews as $review): ?>
                            <div class="review">
                                <p><?= nl2br(h($review->review)) ?></p>
                                <p><strong><?= __('Written by:') ?></strong> <?= h($review->user->name ?? 'Unknown') ?></p>
                                <?= $this->Html->link(__('View'), ['controller' => 'Reviews','action' => 'view', $review->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Reviews','action' => 'edit', $review->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Reviews','action' => 'delete', $review->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $review->id),
                                    ]
                                ) ?>
                            </div>

                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p><?= __('No reviews yet.') ?></p>
                <?php endif; ?>
                <h4><?= __('Related Tags') ?></h4>
                <?= $this->Html->link(__('New Tag'), ['controller' => 'Tags','action' => 'add', '?' => ['book_id' => $book->id]], ['class' => 'side-nav-item']) ?>

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
                                        'confirm' => __('Are you sure you want to delete # {0} {1}?', $tag->id, $tag->tag),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
                <h3>Related Books</h3>
                <h5>These books share the tags with the book you are viewing:</h5>
                <?php if (!empty($relatedBooks)): ?>
                    <div class="books-container">
                        <?php foreach ($relatedBooks as $related): ?>
                            <div class="book-card">
                                <div class="book-image">
                                    <img src="https://jackets.dmmserver.com/media/140/<?= h($related->image) ?>.jpg" alt="<?= h($related->title) ?>" />
                                </div>
                                <div class="book-details">
                                    <h6><?= h($related->title) ?></h6>
                                    <p><strong>Author:</strong> <?= h($related->author) ?></p>
                                    <p><strong>ISBN:</strong> <?= h($related->isbn) ?></p>
                                    <p><strong>Published:</strong> <?= h($related->pubDate) ?></p>
                                    <p><strong>Picks:</strong> <?= h($related->picksCount) ?></p>
                                    <p><strong>Format:</strong> <?= h($related->format) ?></p>
                                    <?= $this->Html->link(__('View'), ['action' => 'view', $related->id], ['class' => 'button view-button']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No related books found.</p>
                <?php endif; ?>

            </div>

            <button onclick="window.history.back();" class="back button">Back</button>
        </div>
    </div>
</div>
