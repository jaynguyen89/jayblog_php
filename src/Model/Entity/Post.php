<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $photo
 * @property int $up_vote
 * @property int $down_vote
 * @property int $status
 * @property string $note
 * @property \Cake\I18n\FrozenTime $created_on
 * @property \Cake\I18n\FrozenTime $updated_on
 *
 * @property \App\Model\Entity\Comment[] $comments
 * @property \App\Model\Entity\Distribution[] $distributions
 * @property \App\Model\Entity\File[] $files
 * @property \App\Model\Entity\Message[] $messages
 */
class Post extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'description' => true,
        'content' => true,
        'photo' => true,
        'up_vote' => true,
        'down_vote' => true,
        'status' => true,
        'note' => true,
        'created_on' => true,
        'updated_on' => true,
        'comments' => true,
        'distributions' => true,
        'files' => true,
        'messages' => true
    ];
}
