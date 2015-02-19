<?php

namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AktualityPresenter
 *
 * @author sasa
 */


class AktualityPresenter extends BasePresenter {

    //private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }
    
    public function renderDefault() {
        $this->template->aktuality = $this->database->table('aktuality')->order('datum DESC');
    }

    public function createComponentAktualitaForm() {
        $form = new Form;
        $form->addText('nadpis', 'Nadpis:')
                ->setRequired();
        $form->addTextArea('text', 'Text:')
                ->setRequired();
        $form->addSubmit('send', 'Ulozit aktualitu');
        $form->onSuccess[] = array($this, 'insertAktualitu');
        return $form;
    }

    public function insertAktualitu($form, $values) {

        $AktualitaId = $this->getParameter('aktualitaId');

        if ($AktualitaId) {
            $aktualita = $this->database->table('aktuality')->get($AktualitaId);
            $aktualita->update($values);
            $this->flashMessage('Aktualita byla úspěšně upravena.', 'success');
        } else {
            $aktualita = $this->database->table('aktuality')->insert($values);
            $this->flashMessage('Aktualita byla úspěšně vlozena.', 'success');
        }
        $this->redirect('this');
    }

    public function actionEdit($aktualitaId) {
        $aktualita = $this->database->table('aktuality')->get($aktualitaId);
        if (!$aktualita) {
            $this->error('Aktualita nebyla nalezena');
        }
        $this['aktualitaForm']->setDefaults($aktualita->toArray());
    }

    public function actionDelete($aktualitaId) {
        $this->database->table('aktuality')->where('id_aktuality', $aktualitaId)->delete();
        $this->flashMessage('Aktualita byla úspěšně smazana.', 'success');
        $this->redirect('default');
    }

}
