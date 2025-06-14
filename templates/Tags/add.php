<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 * @var \Cake\Collection\CollectionInterface|string[] $books
 */
?>
<script defer>
    const tagInput = document.querySelector('#tag');
    const suggestionList = document.querySelector('#tag-suggestions');
    let debounceTimeout;

    tagInput.addEventListener('input', () => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            const query = tagInput.value.trim();
            if (query.length > 1) {
                fetch(`/tags/suggest.json?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionList.innerHTML = '';
                        data.tags.forEach(tag => {
                            const option = document.createElement('option');
                            option.value = tag.tag;
                            suggestionList.appendChild(option);
                        });
                    });
            }
        }, 300);
    });
</script>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tags form content">
            <?= $this->Form->create($tag) ?>
            <fieldset>
                <legend><?= __('Add Tag') ?></legend>
                <?php
                    echo $this->Form->control('book_id', ['options' => $books,
                        'label' => 'Book',
                        'empty' => 'Choose a book',
                        'class' => 'select2'],
                    );
                    echo $this->Form->control('tag',
                    [
                        'type' => 'text',
                        'label' => 'Tag',
                        'autocomplete' => 'off',
                        'list' => 'tag-suggestions'
                    ]);
                    echo '<datalist id="tag-suggestions"></datalist>';
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

