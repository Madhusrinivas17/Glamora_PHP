<?php
declare(strict_types=1);

namespace App\Controller;

class ReviewsController extends AppController
{
    public function add()
    {
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            $this->Flash->error(__('Please log in to submit a review.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $reviewsTable = $this->fetchTable('Reviews');
        $appointmentsTable = $this->fetchTable('Appointments');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $serviceId = !empty($data['service_id']) ? (int)$data['service_id'] : null;
            $appointmentId = !empty($data['appointment_id']) ? (int)$data['appointment_id'] : null;

            // Verify customer completed appointment for this service
            if ($appointmentId) {
                $completed = $appointmentsTable->find()
                    ->where([
                        'id' => $appointmentId,
                        'user_id' => $identity->id,
                        'status' => 'Completed'
                    ])
                    ->first();
            } else {
                $completed = $appointmentsTable->find()
                    ->where([
                        'user_id' => $identity->id,
                        'service_id' => $serviceId,
                        'status' => 'Completed'
                    ])
                    ->first();
            }

            if (!$completed) {
                $this->Flash->error(__('Only customers who have completed an appointment for this service can submit a review.'));
                return $this->redirect($this->referer(['controller' => 'Services', 'action' => 'index']));
            }

            $alreadyReviewed = $reviewsTable->exists([
                'user_id' => $identity->id,
                'appointment_id' => $completed->id
            ]);

            if ($alreadyReviewed) {
                $this->Flash->error(__('You have already submitted a review for this appointment session.'));
                return $this->redirect($this->referer());
            }

            $review = $reviewsTable->newEntity([
                'user_id' => $identity->id,
                'service_id' => $completed->service_id,
                'appointment_id' => $completed->id,
                'rating' => min(5, max(1, (int)$data['rating'])),
                'title' => $data['title'] ?? 'Customer Review',
                'comment' => $data['comment'] ?? '',
                'status' => 'Approved',
            ]);

            if ($reviewsTable->save($review)) {
                $this->Flash->success(__('Thank you for your rating and review!'));
            } else {
                $this->Flash->error(__('Failed to submit review. Please check details.'));
            }
        }

        return $this->redirect($this->referer(['controller' => 'Services', 'action' => 'index']));
    }

    public function edit($id = null)
    {
        $identity = $this->Authentication->getIdentity();
        $reviewsTable = $this->fetchTable('Reviews');

        $review = $reviewsTable->find()
            ->where(['id' => $id, 'user_id' => $identity->id])
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $review->rating = min(5, max(1, (int)($data['rating'] ?? $review->rating)));
            $review->title = $data['title'] ?? $review->title;
            $review->comment = $data['comment'] ?? $review->comment;

            if ($reviewsTable->save($review)) {
                $this->Flash->success(__('Your review has been updated.'));
            } else {
                $this->Flash->error(__('Could not update review.'));
            }
        }

        return $this->redirect($this->referer());
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $identity = $this->Authentication->getIdentity();
        $reviewsTable = $this->fetchTable('Reviews');

        $review = $reviewsTable->find()
            ->where(['id' => $id, 'user_id' => $identity->id])
            ->first();

        if ($review && $reviewsTable->delete($review)) {
            $this->Flash->success(__('Review deleted successfully.'));
        } else {
            $this->Flash->error(__('Unable to delete review.'));
        }

        return $this->redirect($this->referer());
    }
}
