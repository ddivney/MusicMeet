<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Relationship Entity
 *
 * @property int $user_id1
 * @property int $user_id2
 * @property int $status
 */
class Relationship extends Entity
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
        '*' => true,
        'user_id1' => false,
        'user_id2' => false
    ];
}
