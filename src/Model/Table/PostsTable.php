<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Posts Model
 *
 * @property \App\Model\Table\AttachmentsTable|\Cake\ORM\Association\HasMany $Attachments
 * @property \App\Model\Table\CommentsTable|\Cake\ORM\Association\HasMany $Comments
 * @property \App\Model\Table\DistributionsTable|\Cake\ORM\Association\HasMany $Distributions
 * @property \App\Model\Table\MessagesTable|\Cake\ORM\Association\HasMany $Messages
 * @property \App\Model\Table\VotesTable|\Cake\ORM\Association\HasMany $Votes
 *
 * @method \App\Model\Entity\Post get($primaryKey, $options = [])
 * @method \App\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Post|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 */
class PostsTable extends Table
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

        $this->setTable('posts');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Attachments', [
            'foreignKey' => 'post_id'
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'post_id'
        ]);
        $this->hasMany('Distributions', [
            'foreignKey' => 'post_id'
        ]);
        $this->hasMany('Messages', [
            'foreignKey' => 'post_id'
        ]);
        $this->hasMany('Votes', [
            'foreignKey' => 'post_id'
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
            ->scalar('title')
            ->maxLength('title', 250)
            ->allowEmpty('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 500)
            ->allowEmpty('description');

        $validator
            ->scalar('content')
            ->allowEmpty('content');

        $validator
            ->scalar('photo')
            ->maxLength('photo', 100)
            ->allowEmpty('photo');

        $validator
            ->allowEmpty('status');

        $validator
            ->allowEmpty('task_total');

        $validator
            ->allowEmpty('task_done');

        $validator
            ->scalar('note')
            ->maxLength('note', 250)
            ->allowEmpty('note');

        $validator
            ->dateTime('created_on')
            ->allowEmpty('created_on');

        $validator
            ->dateTime('updated_on')
            ->allowEmpty('updated_on');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        return $validator;
    }
}
