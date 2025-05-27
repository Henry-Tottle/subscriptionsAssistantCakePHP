<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Books Model
 *
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\HasMany $Tags
 *
 * @method \App\Model\Entity\Book newEmptyEntity()
 * @method \App\Model\Entity\Book newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Book> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Book get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Book findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Book patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Book> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Book|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Book saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Book>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Book>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Book>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Book> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Book>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Book>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Book>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Book> deleteManyOrFail(iterable $entities, array $options = [])
 */
class BooksTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('books');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Tags', [
            'foreignKey' => 'book_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('isbn')
            ->maxLength('isbn', 255)
            ->allowEmptyString('isbn');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('author')
            ->maxLength('author', 255)
            ->allowEmptyString('author');

        $validator
            ->scalar('format')
            ->maxLength('format', 255)
            ->allowEmptyString('format');

        $validator
            ->date('pubDate')
            ->allowEmptyDate('pubDate');

        $validator
            ->scalar('publisher')
            ->maxLength('publisher', 255)
            ->allowEmptyString('publisher');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->allowEmptyString('subject');

        $validator
            ->scalar('price')
            ->maxLength('price', 255)
            ->allowEmptyString('price');

        $validator
            ->integer('picksCount')
            ->allowEmptyString('picksCount');

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->allowEmptyFile('image');

        return $validator;
    }
}
