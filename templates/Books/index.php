<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Book> $books
 */
?>

<div class="row">

<aside class="column">
    <div class="sidebar">
        <h4 class="heading"><?= __('Actions')?></h4>
        <?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
        <?= $this->Html->link(__('logout'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'side-nav-item']) ?>
    </div>
</aside>

<div class="books index content">
    <div>
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <?= $this->Form->control('search', [
            'label' => false,
            'placeholder' => 'Search by title, author or ISBN',
            'value' => $this->request->getQuery('search')
]) ?>
        <?= $this->Form->submit('Search') ?>
        <?= $this->Form->end() ?>
    </div>
    <?= $this->Html->link(__('New Book'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?= $this->Html->link('Import Books CSV', ['action' => 'import'], ['class' => 'button float-right']) ?>


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
        <label  for="subject">Category:</label>


        <select name="subject" id="subject" onchange="this.form.submit()">
            <?php foreach ($subjects as $subject): ?>
                <?php $selected = ($this->request->getQuery('subject') === $subject) ? 'selected' : ''; ?>
                <option value="<?= h($subject) ?>" <?= $selected ?>><?= h($subject) ?></option>
            <?php endforeach; ?>
        </select>

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
                    <p><strong>Published:</strong> <?php echo h($book->pubDate->i18nFormat('dd/MM/yy')); ?></p>
                    <p><strong>Picks:</strong> <?php echo h($book->picksCount); ?></p>
                    <p><strong>Format:</strong> <?php echo h($book->format); ?></p>
                    <?= $this->Html->link(__('View'), ['action' => 'view', $book->id], ['class' => 'button view-button']) ?>
                </div>
            </div>
        <?php endforeach; ?>
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
</div>


