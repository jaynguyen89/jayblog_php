<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comment Entity
 *
 * @property int $id
 * @property int $post_id
 * @property \Cake\I18n\FrozenTime $comment_date
 * @property string $commenter_name
 * @property string $commenter_email
 * @property string $content
 * @property bool $status
 * @property bool $active
 *
 * @property \App\Model\Entity\Post $post
 * @property \App\Model\Entity\Reply[] $replies
 */
class Comment extends Entity
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
        'post_id' => true,
        'comment_date' => true,
        'commenter_name' => true,
        'commenter_email' => true,
        'content' => true,
        'status' => true,
        'active' => true,
        'post' => true,
        'replies' => true
    ];
}
