<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class ServicesController extends AdminAppController
{
    public function index()
    {
        $servicesTable = $this->fetchTable('Services');
        $categoriesTable = $this->fetchTable('ServiceCategories');

        $services = $servicesTable->find()
            ->contain(['ServiceCategories'])
            ->order(['Services.id' => 'DESC'])
            ->all();

        $categories = $categoriesTable->find()->all();

        $this->set(compact('services', 'categories'));
    }

    public function add()
    {
        $servicesTable = $this->fetchTable('Services');
        $categoriesTable = $this->fetchTable('ServiceCategories');

        $service = $servicesTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Handle optional image upload or image path string
            $imageFile = $this->request->getData('image_file');
            if ($imageFile && is_object($imageFile) && $imageFile->getError() === UPLOAD_ERR_OK) {
                $filename = time() . '_' . $imageFile->getClientFilename();
                $targetPath = WWW_ROOT . 'img' . DS . $filename;
                $imageFile->moveTo($targetPath);
                $data['image'] = $filename;
            } elseif (empty($data['image'])) {
                $data['image'] = 'service_default.jpg';
            }

            $service = $servicesTable->patchEntity($service, $data);
            if ($servicesTable->save($service)) {
                $this->Flash->success(__('Service added successfully!'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Could not save service. Please check validation errors.'));
            }
        }

        $categories = $categoriesTable->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set(compact('service', 'categories'));
    }

    public function edit($id = null)
    {
        $servicesTable = $this->fetchTable('Services');
        $categoriesTable = $this->fetchTable('ServiceCategories');

        $service = $servicesTable->get($id);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            $imageFile = $this->request->getData('image_file');
            if ($imageFile && is_object($imageFile) && $imageFile->getError() === UPLOAD_ERR_OK) {
                $filename = time() . '_' . $imageFile->getClientFilename();
                $targetPath = WWW_ROOT . 'img' . DS . $filename;
                $imageFile->moveTo($targetPath);
                $data['image'] = $filename;
            }

            $service = $servicesTable->patchEntity($service, $data);
            if ($servicesTable->save($service)) {
                $this->Flash->success(__('Service updated successfully!'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Could not update service.'));
            }
        }

        $categories = $categoriesTable->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set(compact('service', 'categories'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $servicesTable = $this->fetchTable('Services');
        $service = $servicesTable->get($id);

        if ($servicesTable->delete($service)) {
            $this->Flash->success(__('Service deleted successfully.'));
        } else {
            $this->Flash->error(__('Unable to delete service.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
