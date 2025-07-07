<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ReviewsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ReviewsController Test Case
 *
 * @uses \App\Controller\ReviewsController
 */
class ReviewsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Reviews',
        'app.Books',
        'app.Users',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'testuser',
                    'role' => 'admin',
                ]
            ]
        ]);
    }

    public function testIndex(): void
    {
        $this->get('/reviews');
        $this->assertResponseOk();
        $this->assertResponseContains('<table'); // Assuming it renders a list
    }

    public function testView(): void
    {
        $this->get('/reviews/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Review'); // Replace with real content if needed
    }

    public function testAddSuccess(): void
    {
        $data = [
            'comment' => 'Excellent read.',
            'book_id' => 1,
            'user_id' => 1
        ];
        $this->post('/reviews/add?book_id=1', $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/books/view/1');
        $this->assertSession('The review has been saved.', 'Flash.flash.0.message');
    }

    public function testAddFailure(): void
    {
        $data = [
            'comment' => '',
        ];
        $this->post('/reviews/add', $data);
        $this->assertResponseCode(200);
        $this->assertResponseContains('The review could not be saved');
    }

    public function testEditSuccess(): void
    {
        $data = [
            'comment' => 'Updated review comment',
        ];
        $this->post('/reviews/edit/1', $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/books/view/1');
    }

    public function testEditFailure(): void
    {
        $data = [
            'comment' => '',
        ];
        $this->post('/reviews/edit/1', $data);
        $this->assertResponseCode(200);
        $this->assertResponseContains('The review could not be saved');
    }

    public function testDeleteSuccess(): void
    {
        $this->post('/reviews/delete/1');
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/books/view');
        $this->assertSession('The review has been deleted.', 'Flash.flash.0.message');
    }

    public function testDeleteFailure(): void
    {
        // Simulate failure: non-existent record
        $this->post('/reviews/delete/9999');
        $this->assertResponseCode(404);
    }
}
