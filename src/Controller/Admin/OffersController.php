<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class OffersController extends AdminAppController
{
    public function index()
    {
        $offersTable = $this->fetchTable('Offers');
        $offers = $offersTable->find()->order(['id' => 'DESC'])->all();

        $this->set(compact('offers'));
    }

    public function add()
    {
        $offersTable = $this->fetchTable('Offers');
        $offer = $offersTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $imageFile = $this->request->getData('image_file');
            if ($imageFile && is_object($imageFile) && $imageFile->getError() === UPLOAD_ERR_OK) {
                $filename = time() . '_' . $imageFile->getClientFilename();
                $imageFile->moveTo(WWW_ROOT . 'img' . DS . $filename);
                $data['offer_image'] = $filename;
            } elseif (empty($data['offer_image'])) {
                $data['offer_image'] = 'offer_default.jpg';
            }

            $offer = $offersTable->patchEntity($offer, $data);
            if ($offersTable->save($offer)) {
                $this->Flash->success(__('Offer created successfully!'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Failed to create offer.'));
            }
        }

        $this->set(compact('offer'));
    }

    public function edit($id = null)
    {
        $offersTable = $this->fetchTable('Offers');
        $offer = $offersTable->get($id);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            $imageFile = $this->request->getData('image_file');
            if ($imageFile && is_object($imageFile) && $imageFile->getError() === UPLOAD_ERR_OK) {
                $filename = time() . '_' . $imageFile->getClientFilename();
                $imageFile->moveTo(WWW_ROOT . 'img' . DS . $filename);
                $data['offer_image'] = $filename;
            }

            $offer = $offersTable->patchEntity($offer, $data);
            if ($offersTable->save($offer)) {
                $this->Flash->success(__('Offer updated!'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Unable to update offer.'));
            }
        }

        $this->set(compact('offer'));
    }

    public function toggle($id = null)
    {
        $this->request->allowMethod(['post']);
        $offersTable = $this->fetchTable('Offers');
        $offer = $offersTable->get($id);

        $offer->is_active = $offer->is_active ? 0 : 1;
        $offersTable->save($offer);

        $this->Flash->success(__('Offer status toggled.'));
        return $this->redirect(['action' => 'index']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $offersTable = $this->fetchTable('Offers');
        $offer = $offersTable->get($id);

        if ($offersTable->delete($offer)) {
            $this->Flash->success(__('Offer deleted.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
