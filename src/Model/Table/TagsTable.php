<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tags Model
 *
 * @property \App\Model\Table\BooksTable&\Cake\ORM\Association\BelongsTo $Books
 *
 * @method \App\Model\Entity\Tag newEmptyEntity()
 * @method \App\Model\Entity\Tag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Tag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Tag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Tag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Tag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Tag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Tag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tag> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TagsTable extends Table
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

        $this->setTable('tags');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Books', [
            'foreignKey' => 'book_id',
            'joinType' => 'INNER',
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
            ->integer('book_id')
            ->notEmptyString('book_id');

        $validator
            ->scalar('tag')
            ->maxLength('tag', 255)
            ->allowEmptyString('tag');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['book_id'], 'Books'), ['errorField' => 'book_id']);

        return $rules;
    }
}
