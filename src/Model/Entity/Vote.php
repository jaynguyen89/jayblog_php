<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vote Entity
 *
 * @property int $id
 * @property int $post_id
 * @property \Cake\I18n\FrozenTime $vote_date
 * @property string $client_ip
 * @property bool $sign
 * @property bool $active
 *
 * @property \App\Model\Entity\Post $post
 */
class Vote extends Entity
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
        'vote_date' => true,
        'client_ip' => true,
        'sign' => true,
        'active' => true,
        'post' => true
    ];
}
