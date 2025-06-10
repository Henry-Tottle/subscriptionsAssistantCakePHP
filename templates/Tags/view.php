<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tag'), ['action' => 'edit', $tag->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tag'), ['action' => 'delete', $tag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tag'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tags view content">
            <h3><?= h($tag->id) ?></h3>
            <table>

                <?php if (!empty($books)): ?>
                    <h4>Books with this tag:</h4>
                    <div class="books-container">
                        <?php foreach ($books as $book): ?>
                            <div class="book-card">
                                <div class="book-image">
                                    <img src="https://jackets.dmmserver.com/media/140/<?php echo h($book->image); ?>.jpg" alt="<?php echo h($book->title); ?>" />
                                </div>
                                <div class="book-details">
                                    <h6><?php echo h($book->title); ?></h6>
                                    <p><strong>Author:</strong> <?php echo h($book->author); ?></p>
                                    <p><strong>ISBN:</strong> <?php echo h($book->isbn); ?></p>
                                    <p><strong>Published:</strong> <?php echo h($book->pubDate); ?></p>
                                    <p><strong>Picks:</strong> <?php echo h($book->picksCount); ?></p>
                                    <p><strong>Format:</strong> <?php echo h($book->format); ?></p>
                                    <?= $this->Html->link(__('View'), ['controller' => 'Books', 'action' => 'view', $book->id], ['class' => 'button view-button']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>                <?php else: ?>
                    <p>No books found with this tag.</p>
                <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Tag') ?></th>
                    <td><?= h($tag->tag) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tag->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
