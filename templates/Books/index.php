<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Book> $books
 */
?>
<style>
    p {
        padding: 0;
        margin: 0;
    }
    .books-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 20px;
        padding: 20px;
    }

    .book-card {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 10px;
        width: 22%;
        min-width: 250px;
        max-width: 300px;
        height: 500px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }

    .book-card:hover {
        transform: scale(1.03);
    }

    .book-image img {
        width: 150px;
        height: 200px;
        padding: 10px;
    }

    .book-image {
        display: flex;
        justify-content:center;
    }

    .book-details {
        padding: 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }

    .book-details h6 {
        font-size: 1.1em;
        margin: 0 0 10px;
        text-align: center;
    }



</style>
<div class="row">

<aside class="column">
    <div class="sidebar">
        <h4 class="heading"><?= __('Actions')?></h4>
        <?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index'], ['class' => 'side-nav-item']) ?>

    </div>
</aside>

<div class="books index content">
    <?= $this->Html->link(__('New Book'), ['action' => 'add'], ['class' => 'button float-right']) ?>

    <h3><?= __('Books') ?></h3>
    <div>
        <?php
        $direction = $this->request->getQuery('direction') ?? 'desc'; // default to 'desc'
        $sort = $this->request->getQuery('sort') ?? 'id'; // optional: default sort
        ?>
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <label for="sort">Sort:</label>
        <select name="sort" id="sort" onchange="this.form.submit()">
            <option value="id"<?= $this->request->getQuery('sort') === 'id' ? 'selected' : '' ?>>Default</option>
            <option value="pubDate" <?= $this->request->getQuery('sort') === 'pubDate' ? 'selected' : '' ?>>Publication Date</option>
            <option value="subject" <?= $this->request->getQuery('sort') === 'subject' ? 'selected' : '' ?>>Subject</option>
            <option value="picksCount" <?= $this->request->getQuery('sort') === 'picksCount' ? 'selected' : '' ?>>Picks Count</option>
        </select>
        <label for="direction">Direction:</label>
        <select name="direction" id="direction" onchange="this.form.submit()">
            <option value="desc"<?= $this->request->getQuery('direction') === 'desc' ? ' selected' : '' ?>>Descending</option>
            <option value="asc"<?= $this->request->getQuery('direction') === 'asc' ? ' selected' : '' ?>>Ascending</option>
        </select>
        <label for="format">Format:</label>
        <select name="format" id="format" onchange="this.form.submit()">
            <option value="" <?= $this->request->getQuery('format') === null ? 'selected' : '' ?>>Both</option>
            <option value="Paperback / softback"<?= $this->request->getQuery('format') === 'Paperback / softback' ? 'selected' : '' ?>>Paperback</option>
            <option value="Hardback"<?= $this->request->getQuery('format') === 'Hardback' ? 'selected' : '' ?>>Hardback</option>
        </select>
        <?= $this->Form->end() ?>

    </div>
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
                    <?= $this->Html->link(__('View'), ['action' => 'view', $book->id], ['class' => 'button view-button']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <!--    <div class="table-responsive">-->
<!--        <table>-->
<!--            <thead>-->
<!--                <tr>-->
<!--                    <th>--><?php //= $this->Paginator->sort('id') ?><!--</th>-->
<!--                    <th>--><?php //= $this->Paginator->sort('isbn') ?><!--</th>-->
<!--                    <th>--><?php //= $this->Paginator->sort('title') ?><!--</th>-->
<!--                    <th>--><?php //= $this->Paginator->sort('author') ?><!--</th>-->
<!--                    <th>--><?php //= $this->Paginator->sort('format') ?><!--</th>-->
<!--                    <th>--><?php //= $this->Paginator->sort('pubDate') ?><!--</th>-->
<!--                    <th>--><?php //= $this->Paginator->sort('publisher') ?><!--</th>-->
<!--                    <th>--><?php //= $this->Paginator->sort('subject') ?><!--</th>-->
<!--                    <th>--><?php //= $this->Paginator->sort('price') ?><!--</th>-->
<!--                    <th>--><?php //= $this->Paginator->sort('picksCount') ?><!--</th>-->
<!--                    <th>--><?php //= $this->Paginator->sort('image') ?><!--</th>-->
<!--                    <th class="actions">--><?php //= __('Actions') ?><!--</th>-->
<!--                </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--                --><?php //foreach ($books as $book): ?>
<!--                <tr>-->
<!--                    <td>--><?php //= $this->Number->format($book->id) ?><!--</td>-->
<!--                    <td>--><?php //= h($book->isbn) ?><!--</td>-->
<!--                    <td>--><?php //= h($book->title) ?><!--</td>-->
<!--                    <td>--><?php //= h($book->author) ?><!--</td>-->
<!--                    <td>--><?php //= h($book->format) ?><!--</td>-->
<!--                    <td>--><?php //= h($book->pubDate) ?><!--</td>-->
<!--                    <td>--><?php //= h($book->publisher) ?><!--</td>-->
<!--                    <td>--><?php //= h($book->subject) ?><!--</td>-->
<!--                    <td>--><?php //= h($book->price) ?><!--</td>-->
<!--                    <td>--><?php //= $book->picksCount === null ? '' : $this->Number->format($book->picksCount) ?><!--</td>-->
<!--                    <td><img src="https://jackets.dmmserver.com/media/140/--><?php //= h($book->image) ?><!--.jpg" /></td>-->
<!--                    <td class="actions">-->
<!--                        --><?php //= $this->Html->link(__('View'), ['action' => 'view', $book->id]) ?>
<!--                        --><?php //= $this->Html->link(__('Edit'), ['action' => 'edit', $book->id]) ?>
<!--                        --><?php //= $this->Form->postLink(
//                            __('Delete'),
//                            ['action' => 'delete', $book->id],
//                            [
//                                'method' => 'delete',
//                                'confirm' => __('Are you sure you want to delete # {0}?', $book->id),
//                            ]
//                        ) ?>
<!--                    </td>-->
<!--                </tr>-->
<!--                --><?php //endforeach; ?>
<!--            </tbody>-->
<!--        </table>-->
<!--    </div>-->
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
</div>

