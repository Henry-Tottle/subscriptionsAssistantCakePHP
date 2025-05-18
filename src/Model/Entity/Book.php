<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Book Entity
 *
 * @property int $id
 * @property string|null $isbn
 * @property string|null $title
 * @property string|null $author
 * @property string|null $format
 * @property \Cake\I18n\Date|null $pubDate
 * @property string|null $publisher
 * @property string|null $subject
 * @property string|null $price
 * @property int|null $picksCount
 * @property string|null $image
 *
 * @property \App\Model\Entity\Tag[] $tags
 */
class Book extends Entity
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
        'isbn' => true,
        'title' => true,
        'author' => true,
        'format' => true,
        'pubDate' => true,
        'publisher' => true,
        'subject' => true,
        'price' => true,
        'picksCount' => true,
        'image' => true,
        'tags' => true,
    ];
}
