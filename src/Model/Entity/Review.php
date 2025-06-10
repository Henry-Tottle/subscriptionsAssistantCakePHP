<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Review Entity
 *
 * @property int $id
 * @property int $book_id
 * @property int $user_id
 * @property string $review
 *
 * @property \App\Model\Entity\Book $book
 * @property \App\Model\Entity\User $user
 */
class Review extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'book_id' => true,
        'user_id' => true,
        'review' => true,
        'book' => true,
        'user' => true,
    ];
}
