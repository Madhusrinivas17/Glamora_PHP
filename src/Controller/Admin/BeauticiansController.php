<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class BeauticiansController extends AdminAppController
{
    public function index()
    {
        $beauticiansTable = $this->fetchTable('Beauticians');
        $beauticians = $beauticiansTable->find()->order(['id' => 'DESC'])->all();

        $this->set(compact('beauticians'));
    }

    public function add()
    {
        $beauticiansTable = $this->fetchTable('Beauticians');
        $beautician = $beauticiansTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $imageFile = $this->request->getData('image_file');
            if ($imageFile && is_object($imageFile) && $imageFile->getError() === UPLOAD_ERR_OK) {
                $filename = time() . '_' . $imageFile->getClientFilename();
                $imageFile->moveTo(WWW_ROOT . 'img' . DS . $filename);
                $data['profile_image'] = $filename;
            } elseif (empty($data['profile_image'])) {
                $data['profile_image'] = 'beautician_default.jpg';
            }

            $beautician = $beauticiansTable->patchEntity($beautician, $data);
            if ($beauticiansTable->save($beautician)) {
                $this->Flash->success(__('Beautician profile created successfully!'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Failed to add beautician.'));
            }
        }

        $this->set(compact('beautician'));
    }

    public function edit($id = null)
    {
        $beauticiansTable = $this->fetchTable('Beauticians');
        $beautician = $beauticiansTable->get($id);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            $imageFile = $this->request->getData('image_file');
            if ($imageFile && is_object($imageFile) && $imageFile->getError() === UPLOAD_ERR_OK) {
                $filename = time() . '_' . $imageFile->getClientFilename();
                $imageFile->moveTo(WWW_ROOT . 'img' . DS . $filename);
                $data['profile_image'] = $filename;
            }

            $beautician = $beauticiansTable->patchEntity($beautician, $data);
            if ($beauticiansTable->save($beautician)) {
                $this->Flash->success(__('Beautician details updated!'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Could not update beautician.'));
            }
        }

        $this->set(compact('beautician'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $beauticiansTable = $this->fetchTable('Beauticians');
        $beautician = $beauticiansTable->get($id);

        if ($beauticiansTable->delete($beautician)) {
            $this->Flash->success(__('Beautician removed successfully.'));
        } else {
            $this->Flash->error(__('Unable to delete beautician.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function toggleLeave($id = null)
    {
        $this->request->allowMethod(['post']);
        $beauticiansTable = $this->fetchTable('Beauticians');
        $beautician = $beauticiansTable->get($id);

        $beautician->leave_status = $beautician->leave_status ? 0 : 1;
        $beautician->availability_status = $beautician->leave_status ? 'on_leave' : 'available';

        if ($beauticiansTable->save($beautician)) {
            $statusText = $beautician->leave_status ? 'Marked as ON LEAVE' : 'Marked as AVAILABLE';
            $this->Flash->success(__('{0} - {1}', $beautician->name, $statusText));
        }

        return $this->redirect(['action' => 'index']);
    }
}
