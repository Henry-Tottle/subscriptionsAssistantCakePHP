<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ReviewsFixture
 */
class ReviewsFixture extends TestFixture
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
                'book_id' => 1,
                'user_id' => 1,
                'review' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
