<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reply Entity
 *
 * @property int $id
 * @property int $comment_id
 * @property \Cake\I18n\FrozenTime $reply_date
 * @property string $replier_name
 * @property string $replier_email
 * @property string $content
 * @property string $photo
 * @property string $file
 *
 * @property \App\Model\Entity\Comment $comment
 */
class Reply extends Entity
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
        'comment_id' => true,
        'reply_date' => true,
        'replier_name' => true,
        'replier_email' => true,
        'content' => true,
        'photo' => true,
        'file' => true,
        'comment' => true
    ];
}
