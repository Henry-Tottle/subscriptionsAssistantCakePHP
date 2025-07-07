<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\BooksController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Authentication\IdentityInterface;
use Authentication\Identity;

/**
 * App\Controller\BooksController Test Case
 *
 * @uses \App\Controller\BooksController
 */
class BooksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public function setUp(): void
{
    parent::setUp();

    // Simulate logged in user by setting the session key expected by Authentication plugin
    $this->session([
        'Auth' => [
            'User' => [
                'id' => 1,
                'email' => 'test@example.com',
                'role' => 'user',
                // add any other user properties your app uses
            ],
        ],
    ]);
}

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Books',
        'app.Tags',
    ];

    

    public function testIndexReturnsBooks()
{
    $this->get('/books');
    $this->assertResponseOk();
    $this->assertResponseContains('Books'); // Adjust based on actual view content or fixture data
}

public function testIndexWithSearchFilter()
{
    $this->get('/books?search=Example');
    $this->assertResponseOk();
    $this->assertResponseContains('Example'); // Assuming "Example" matches a book title or author in fixtures
}

public function testIndexRedirectsWhenFormatEmpty()
{
    $this->get('/books?format=');
    $this->assertResponseCode(302);
    $this->assertRedirect(); // Should redirect to same URL without format param
}

public function testViewReturnsBookAndRelated()
{
    $this->get('/books/view/1');
    $this->assertResponseOk();
    $this->assertResponseContains('Title'); // Fixture book title or expected output
    $this->assertResponseContains('Tags');  // Related tags in the view
}

public function testAddPostSuccess()
{
    $this->enableCsrfToken();
    $this->enableSecurityToken();

    $data = [
        'title' => 'New Test Book',
        'author' => 'Test Author',
        'isbn' => '1234567890123',
        // add required fields as needed
    ];

    $this->post('/books/add', $data);
    $this->assertResponseSuccess();
    $this->assertRedirect(['controller' => 'Books', 'action' => 'index']);

    $books = $this->getTableLocator()->get('Books');
    $book = $books->find()->where(['title' => 'New Test Book'])->first();
    $this->assertNotEmpty($book);
}

// public function testAddPostFailure(): void
public function testAddPostFailure() 
{
    $this->enableCsrfToken();
    $this->enableSecurityToken();

    // Simulate a logged-in user
    $this->session([
        'Auth' => [
            'id' => 1,
            'email' => 'test@example.com',
        ],
    ]);

    // Invalid data: missing required title field
    $data = [
        'title' => null, // Invalid — required field left empty
        'author' => 'Test Author',
        'isbn' => '1234567890',
    ];

    $this->post('/books/add', $data);

    // No redirect expected — validation should fail and return to form
    $this->assertResponseCode(200);
    $this->assertResponseContains('The book could not be saved');
    
    // Optional: assert that the book was NOT saved
    $books = $this->getTableLocator()->get('Books');
    $book = $books->find()->where(['author' => 'Test Author', 'isbn' => '1234567890'])->first();
    $this->assertEmpty($book);
}



public function testDeleteSuccess()
{
    $this->enableCsrfToken();
    $this->enableSecurityToken();

    $books = $this->getTableLocator()->get('Books');
    $book = $books->find()->first();

    $this->post("/books/delete/{$book->id}");
    $this->assertResponseSuccess();
    $this->assertRedirect(['controller' => 'Books', 'action' => 'index']);

    $deleted = $books->exists(['id' => $book->id]);
    $this->assertFalse($deleted);
}


}