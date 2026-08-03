<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Utility\Text;

class CategoriesController extends AdminAppController
{
    public function index()
    {
        $categoriesTable = $this->fetchTable('ServiceCategories');
        $categories = $categoriesTable->find()
            ->contain(['Services'])
            ->order(['ServiceCategories.name' => 'ASC'])
            ->all();

        $this->set(compact('categories'));
    }

    public function add()
    {
        $this->request->allowMethod(['post']);
        $categoriesTable = $this->fetchTable('ServiceCategories');
        
        $data = $this->request->getData();
        if (empty($data['slug'])) {
            $data['slug'] = Text::slug(strtolower($data['name']));
        }

        $category = $categoriesTable->newEntity($data);
        if ($categoriesTable->save($category)) {
            $this->Flash->success(__('Category "{0}" added successfully!', $category->name));
        } else {
            $this->Flash->error(__('Unable to add category. Please check details.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function edit($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $categoriesTable = $this->fetchTable('ServiceCategories');
        $category = $categoriesTable->get($id);

        $data = $this->request->getData();
        if (!empty($data['name']) && empty($data['slug'])) {
            $data['slug'] = Text::slug(strtolower($data['name']));
        }

        $category = $categoriesTable->patchEntity($category, $data);
        if ($categoriesTable->save($category)) {
            $this->Flash->success(__('Category updated successfully!'));
        } else {
            $this->Flash->error(__('Could not update category.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoriesTable = $this->fetchTable('ServiceCategories');
        $category = $categoriesTable->get($id);

        if ($categoriesTable->delete($category)) {
            $this->Flash->success(__('Category deleted successfully.'));
        } else {
            $this->Flash->error(__('Unable to delete category.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
