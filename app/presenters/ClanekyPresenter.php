<?php


namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form,
    Nette\Utils\Strings;
/**
 * Homepage presenter.
 */
class ClankyPresenter extends BasePresenter {

    //private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }
    
    public function renderDefault(){
        $this->template->clanky = $this->database->table('clanky')->order('datum DESC');
    }

    public function renderDetail($clanekId) {
        $clanek = $this->database->table('clanky')->get($clanekId);
        if (!$clanek) {
            $this->error('Stránka nebyla nalezena');
        }

        $this->template->clanek = $clanek;
    }

    public function createComponentClanekForm() {
        $form = new Form;
        $form->addText('nadpis', 'Nadpis:')
                ->setRequired();
        $form->addTextArea('text', 'Text:')
                ->setRequired();
        $form->addSubmit('send', 'Ulozit clanek');
        $form->onSuccess[] = array($this, 'insertClanek');
        return $form;
    }

    public function insertClanek($form, $values) {

        $ClanekId = $this->getParameter('clanekId');

        if ($ClanekId) {
            $clanek = $this->database->table('clanky')->get($ClanekId);
            $clanek->update($values);
            $this->flashMessage('Clanek byl úspěšně upraven.', 'success');
        } else {
            $clanek = $this->database->table('clanky')->insert($values);
            $this->flashMessage('Clanek byl úspěšně vlozen.', 'success');
        }
        $this->redirect('this');
    }

    public function actionEdit($clanekId) {
        $clanek = $this->database->table('clanky')->get($clanekId);
        if (!$clanek) {
            $this->error('Produkt nebyl nalezen');
        }
        $this['clanekForm']->setDefaults($clanek->toArray());
    }

    public function actionDelete($clanekId) {
        $this->database->table('clanky')->where('id_clanku', $clanekId)->delete();
        $this->flashMessage('Clanek byl úspěšně smazan.', 'success');
        $this->redirect('default');
    }


}
