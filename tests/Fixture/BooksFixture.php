<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BooksFixture
 */
class BooksFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'isbn' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'author' => 'Lorem ipsum dolor sit amet',
                'format' => 'Lorem ipsum dolor sit amet',
                'pubDate' => '2025-05-18',
                'publisher' => 'Lorem ipsum dolor sit amet',
                'subject' => 'Lorem ipsum dolor sit amet',
                'price' => 'Lorem ipsum dolor sit amet',
                'picksCount' => 1,
                'image' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
