<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Replies Model
 *
 * @property \App\Model\Table\CommentsTable|\Cake\ORM\Association\BelongsTo $Comments
 *
 * @method \App\Model\Entity\Reply get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reply newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Reply[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reply|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reply patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reply[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reply findOrCreate($search, callable $callback = null, $options = [])
 */
class RepliesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('replies');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Comments', [
            'foreignKey' => 'comment_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('reply_date')
            ->requirePresence('reply_date', 'create')
            ->notEmpty('reply_date');

        $validator
            ->scalar('replier_name')
            ->maxLength('replier_name', 30)
            ->requirePresence('replier_name', 'create')
            ->notEmpty('replier_name');

        $validator
            ->scalar('replier_email')
            ->maxLength('replier_email', 50)
            ->requirePresence('replier_email', 'create')
            ->notEmpty('replier_email');

        $validator
            ->scalar('content')
            ->maxLength('content', 1000)
            ->allowEmpty('content');

        $validator
            ->scalar('photo')
            ->maxLength('photo', 100)
            ->allowEmpty('photo');

        $validator
            ->scalar('file')
            ->maxLength('file', 100)
            ->allowEmpty('file');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['comment_id'], 'Comments'));

        return $rules;
    }
}
