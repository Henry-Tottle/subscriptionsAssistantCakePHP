<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\Log\Log;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 */
class BooksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $queryParams = $this->request->getQueryParams();

        $query = $this->Books->find('all', [
            'contain' => ['Tags'],
        ]);

        if (!empty($queryParams['search']))
        {
            $search = '%' . $queryParams['search'] . '%';
            $query->where([
                'OR' => [
                    'Books.title LIKE' => $search,
                    'Books.author LIKE' => $search,
                    'Books.isbn' => $queryParams['search'],
                ]
            ]);
        }

        if (!empty($queryParams['subject'])) {
            $query->where(['Books.subject LIKE' => '%' . $queryParams['subject'] . '%']);
        }

        if (!empty($queryParams['format'])) {
            $query->where(['Books.format' => $queryParams['format']]);
        }
        $format = $this->request->getQuery('format');

        if ($format === '') {
            $query = $this->request->getQueryParams();
            unset($query['format']);
            $url = $this->request->getUri()->getPath() . '?' . http_build_query($query);
            return $this->response->withHeader('Location', $url)->withStatus(302);
        }


        $this->paginate = [
            'limit' => 100,
            'sortableFields' => ['id', 'pubDate', 'title', 'subject', 'picksCount'],
        ];

        $books = $this->paginate($query);

        $this->set(compact('books'));
        $this->viewBuilder()->setOption('serialize', ['books']);
    }


    /**
     * View method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $book = $this->Books->get($id, contain: ['Tags']);
        $this->set(compact('book'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $book = $this->Books->newEmptyEntity();
        if ($this->request->is('post')) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $this->set(compact('book'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $book = $this->Books->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $this->set(compact('book'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $book = $this->Books->get($id);
        if ($this->Books->delete($book)) {
            $this->Flash->success(__('The book has been deleted.'));
        } else {
            $this->Flash->error(__('The book could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function fetchDescription($id)
    {
        $book = $this->Books->get($id);

        if (!empty($book->description))
        {
            $this->Flash->info('Description already exists.');
            return $this->redirect(['action' => 'view', $book->id]);
        }

        $http = new Client();
        $isbn = $book->isbn;

        $response = $http->get('https://www.googleapis.com/books/v1/volumes', [
            'q' => 'isbn:' . $isbn,
        ]);

        if ($response->isOK()) {
            $data = $response->getJson();
            if (!empty($data['items'][0]['volumeInfo']['description'])) {
                $book->description = $data['items'][0]['volumeInfo']['description'];
                $this->Books->save($book);
                $this->Flash->success('Description added from Google Books.');
            } else {
                $this->Flash->error('No description found for this ISBN.');
            }
        }
        else
        {
            $this->Flash->error('Google Books API returned an error.');
        }
        return $this->redirect(['action' => 'view', $id]);
    }

    public function import()
    {
        $headerMap = [
            'isbn' => 'isbn',
            'title' => 'title',
            'author' => 'author',
            'format' => 'format',
            'publish_date' => 'pubDate',
            'publisher' => 'publisher',
            'subject' => 'subject',
            'price' => 'price',
            'picks_count' => 'picksCount',
        ];

        if ($this->request->is('post')) {
            $file = $this->request->getData('csv_file');

            $validTypes = ['text/csv', 'application/vnd.ms-excel', 'application/octet-stream'];

            Log::debug('Uploaded file metadata: ' . print_r($file, true));
            Log::debug('Uploaded file type: ' . $file->getClientMediaType());

            if ($file && in_array($file->getClientMediaType(), $validTypes)) {
                $handle = fopen($file->getStream()->getMetadata('uri'), 'r');

                if ($handle === false) {
                    $this->Flash->error('Unable to read the uploaded file.');
                    return;
                }

                $header = fgetcsv($handle);
                Log::debug('CSV Headers: ' . print_r($header, true));

                while (($data = fgetcsv($handle)) !== false) {
                    $rawRow = array_combine($header, $data);
                    if ($rawRow === false) {
                        Log::debug('Skipping malformed row: ' . print_r($data, true));
                        continue;
                    }

                    $mappedRow = [];
                    foreach ($headerMap as $csvKey => $dbField) {
                        if (isset($rawRow[$csvKey])) {
                            $mappedRow[$dbField] = $rawRow[$csvKey];
                        }
                    }

                    if (empty($mappedRow['isbn'])) {
                        Log::debug('Skipping row with empty ISBN: ' . print_r($mappedRow, true));
                        continue;
                    }

                    // Construct image field
                    $isbn = $mappedRow['isbn'];
                    $mappedRow['image'] = substr($isbn, 0, 8) . '/' . $isbn;

                    Log::debug('Mapped Row: ' . print_r($mappedRow, true));

                    // Update or create book record
                    $book = $this->Books->find()->where(['isbn' => $mappedRow['isbn']])->first();
                    if ($book) {
                        $book = $this->Books->patchEntity($book, $mappedRow);
                    } else {
                        $book = $this->Books->newEntity($mappedRow);
                    }

                    if (!$this->Books->save($book)) {
                        Log::debug('Failed to save book: ' . print_r($book->getErrors(), true));
                    }
                }

                fclose($handle);
                $this->Flash->success('Books imported.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('File is not a valid CSV file.');
        }
    }

}
