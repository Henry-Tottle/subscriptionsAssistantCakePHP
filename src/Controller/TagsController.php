<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tags Controller
 *
 * @property \App\Model\Table\TagsTable $Tags
 */
class TagsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 100,
            'order' => [
                'Tags.name' => 'asc',
            ]
        ];
        $query = $this->Tags->find()
            ->contain(['Books']);
        $tags = $query->select(['Tags.id','Tags.tag'])->distinct('tag');
        $tags = $this->paginate($tags);

        $this->set(compact('tags'));
    }

    /**
     * View method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // Get the tag entity
        $tag = $this->Tags->get($id);

        // Find all tags with the same tag text
        $tagsWithSameText = $this->Tags->find()
            ->where(['tag' => $tag->tag])
            ->contain(['Books']) // load associated books
            ->all();

        // Collect all unique books linked to those tags
        $books = [];
        foreach ($tagsWithSameText as $t) {
            if ($t->book) {
                $books[$t->book->id] = $t->book;
            }
        }
        // Pass tag and books to the view
        $this->set(compact('tag', 'books'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tag = $this->Tags->newEmptyEntity();

        $bookId = $this->request->getQuery('book_id');
        if ($bookId) {
            $tag->book_id = $bookId;
        }

        if ($this->request->is('post')) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'));
                if ($tag->book_id) {
                    return $this->redirect(['controller' => 'Books', 'action' => 'view', $tag->book_id]);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }
        $books = $this->Tags->Books->find('list')->all();
        $this->set(compact('tag', 'books'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tag = $this->Tags->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'));

                return $this->redirect(['controller' => 'Books', 'action' => 'view', $tag->book_id]);
            }
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }
        $books = $this->Tags->Books->find('list', limit: 200)->all();
        $this->set(compact('tag', 'books'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('The tag has been deleted.'));
        } else {
            $this->Flash->error(__('The tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Books', 'action' => 'view', $tag->book_id]);
    }
}
