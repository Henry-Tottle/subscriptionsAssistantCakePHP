<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 * @var \Cake\Collection\CollectionInterface|string[] $books
 */
?>


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
                        'list' => 'tag-suggestions',
                        'id' => 'tag-input'
                    ]);
                ?>
                <datalist id="tag-suggestions"></datalist>

            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<?php $this->start('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tagInput = document.querySelector('#tag-input');
        const suggestionList = document.querySelector('#tag-suggestions');
        let debounceTimeout;

        if (tagInput && suggestionList) {
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
                            })
                            .catch(err => console.error('Fetch error:', err));
                    }
                }, 300);
            });
        }
    });

    if (typeof jQuery !== 'undefined') {
        jQuery(function($) {
            $('.select2').select2();
        });
    } else {
        console.error('jQuery is not loaded.');
    }
</script>
<?php $this->end(); ?>

