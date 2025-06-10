<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 */
class ReviewsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Reviews->find()
            ->contain(['Books', 'Users']);
        $reviews = $this->paginate($query);

        $this->set(compact('reviews'));
    }

    /**
     * View method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $review = $this->Reviews->get($id, contain: ['Books', 'Users']);
        $this->set(compact('review'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $review = $this->Reviews->newEmptyEntity();

        $bookID = $this->request->getQuery('book_id');

        if ($bookID)
        {
            $review->book_id = $bookID;
        }

        if ($this->request->is('post')) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));
                if ($review->book_id)
                {
                    return $this->redirect(['controller' => 'Books', 'action' => 'view', $review->book_id]);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }
        $books = $this->Reviews->Books->find('list', limit: 200)->all();
        $users = $this->Reviews->Users->find('list', limit: 200)->all();
        $this->set(compact('review', 'books', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $review = $this->Reviews->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));
                $bookId = $review->book_id;

                return $this->redirect(['controller' => 'Books', 'action' => 'view', $bookId]);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }
        $books = $this->Reviews->Books->find('list', limit: 200)->all();
        $users = $this->Reviews->Users->find('list', limit: 200)->all();
        $this->set(compact('review', 'books', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $review = $this->Reviews->get($id);
        if ($this->Reviews->delete($review)) {
            $this->Flash->success(__('The review has been deleted.'));
        } else {
            $this->Flash->error(__('The review could not be deleted. Please, try again.'));
        }

        $bookId = $review->book_id;
        $this->Reviews->delete($review);
        return $this->redirect(['controller' => 'Books', 'action' => 'view', $bookId]);
    }
}
