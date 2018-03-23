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
 * @property int $status
 * @property int $task_total
 * @property int $task_done
 * @property string $note
 * @property \Cake\I18n\FrozenTime $created_on
 * @property \Cake\I18n\FrozenTime $updated_on
 * @property bool $active
 *
 * @property \App\Model\Entity\Attachment[] $attachments
 * @property \App\Model\Entity\Comment[] $comments
 * @property \App\Model\Entity\Distribution[] $distributions
 * @property \App\Model\Entity\Message[] $messages
 * @property \App\Model\Entity\Vote[] $votes
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
        'status' => true,
        'task_total' => true,
        'task_done' => true,
        'note' => true,
        'created_on' => true,
        'updated_on' => true,
        'active' => true,
        'attachments' => true,
        'comments' => true,
        'distributions' => true,
        'messages' => true,
        'votes' => true
    ];
}
