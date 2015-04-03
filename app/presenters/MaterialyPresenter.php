<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form;

/**
 * Description of MaterialyPresenter
 *
 * @author sasa
 */
class MaterialyPresenter extends BasePresenter {

    //private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function renderDefault() {
        $this->template->materialy = $this->database->table('materialy');
    }

    public function createComponentMaterialForm() {
        $form = new Form;
        $form->addText('nazev', 'Název:')
                ->setRequired();
        $form->addText('mnozstvi', 'Množství:')
                ->setRequired();        
        $form->addSubmit('send', 'Uložit materiál');
        $form->onSuccess[] = array($this, 'insertMaterial');
        return $form;
    }

    public function insertMaterial($form, $values) {

        $materialId = $this->getParameter('materialId');

        if ($materialId) {
            $material = $this->database->table('materialy')->get($materialId);
            $material->update($values);
            $this->flashMessage('Material byl úspěšně upraven.', 'success');
        } else {
            $material = $this->database->table('materialy')->insert($values);
            $this->flashMessage('Material byl úspěšně vložen.', 'success');
        }
        $this->redirect('this');
    }

    public function actionEdit($materialId) {
        $material = $this->database->table('materialy')->get($materialId);
        if (!$material) {
            $this->error('Material nebyl nalezen');
        }
        $this['materialForm']->setDefaults($material->toArray());
    }
    
    public function actionDelete($materialId) {        
        $this->database->table('materialy')->where('id_materialu', $materialId)->delete();
        $this->flashMessage('Material byl úspěšně smazán.', 'success');
        $this->redirect('default');
    }

}
