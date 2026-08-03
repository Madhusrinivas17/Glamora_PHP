<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class ReviewsController extends AdminAppController
{
    public function index()
    {
        $reviewsTable = $this->fetchTable('Reviews');

        $reviews = $reviewsTable->find()
            ->contain(['Users', 'Services'])
            ->order(['Reviews.created' => 'DESC'])
            ->all();

        $this->set(compact('reviews'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reviewsTable = $this->fetchTable('Reviews');

        $review = $reviewsTable->get($id);
        if ($reviewsTable->delete($review)) {
            $this->Flash->success(__('Review deleted successfully by Admin.'));
        } else {
            $this->Flash->error(__('Unable to delete review.'));
        }

        return $this->redirect($this->referer(['controller' => 'Reviews', 'action' => 'index']));
    }
}
