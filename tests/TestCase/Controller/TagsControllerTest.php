<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\TagsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TagsController Test Case
 *
 * @uses \App\Controller\TagsController
 */
class TagsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Tags',
        'app.Books',
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
            'role' => 'admin', // or whatever roles your app uses
        ]
    ]
]);
    }

    public function testIndex(): void
    {
        $this->get('/tags');
        $this->assertResponseOk();
        $this->assertResponseContains('<ul>'); 
    }

    public function testView(): void
    {
        $this->get('/tags/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Tag');
    }

    public function testAddPostSuccess(): void
    {
        $data = ['tag' => 'new-tag', 'book_id' => 1];
        $this->post('/tags/add?book_id=1', $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/books/view/1');
    }

    public function testAddPostFailure(): void
    {
        $data = ['tag' => '']; // Invalid: empty tag
        $this->post('/tags/add', $data);
        $this->assertResponseCode(200);
        $this->assertResponseContains('The tag could not be saved');
    }

    public function testEditPostSuccess(): void
    {
        $data = ['tag' => 'edited-tag'];
        $this->post('/tags/edit/1?book_id=1', $data);
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/books/view/1');
    }

    public function testEditPostFailure(): void
    {
        $data = ['tag' => '']; // Invalid: empty tag
        $this->post('/tags/edit/1?book_id=1', $data);
        $this->assertResponseCode(200);
        $this->assertResponseContains('The tag could not be saved');
    }

    public function testDeleteSuccess(): void
    {
        $this->post('/tags/delete/1');
        $this->assertRedirectContains('/books/view');
        $this->assertSession('The tag has been deleted.', 'Flash.flash.0.message');
    }

    public function testDeleteFailure(): void
    {
        // Manually simulate deletion failure by using a non-existent id
        $this->post('/tags/delete/9999');
        $this->assertResponseCode(404);
    }

    public function testSuggest(): void
    {
        $this->get('/tags/suggest?q=test');
        $this->assertResponseOk();
        $this->assertContentType('application/json');
        $this->assertResponseContains('tags');
    }
}
