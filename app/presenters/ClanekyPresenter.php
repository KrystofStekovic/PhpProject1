<?php


namespace App\Presenters;

use Nette,
    Nette\Application\UI\Form,
    Nette\Utils\Strings;
/**
 * Homepage presenter.
 */
class ClankyPresenter extends BasePresenter {
    
    /**
     * @var \App\Model\ObrazkyManager
     * @inject
     */
    public $obrazkyManager;

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
    
    public function renderNovy(){
        $this->template->obrazky = $this->obrazkyManager->getObrazky();
    }
    
    public function renderEdit(){
        $this->template->obrazky = $this->obrazkyManager->getObrazky();
    }

    public function createComponentClanekForm() {
        $form = new Form;
        $form->addText('nadpis', 'Nadpis:')
                ->setRequired();
        $form->addTextArea('popis', 'Popis:')
                ->setRequired();
        $form->addTextArea('text', 'Text:')
                ->setRequired()
                ->getControlPrototype()->setClass('ckeditor');
        $form->addSubmit('send', 'Uložit článek');
        $form->onSuccess[] = array($this, 'insertClanek');
        return $form;
    }

    public function createComponentPridatObrForm() {
        $form = new Form;
        $form->addUpload('obrazek', 'Obrázek:', TRUE)
                ->addRule(Form::IMAGE, 'Musí to být JPEG, PNG nebo GIF.');
        $form->addSubmit('send', 'Přidat obrazek');
        $form->onSuccess[] = array($this, 'pridatObrazek');
        return $form;
    }

    public function insertClanek($form, $values) {

        $ClanekId = $this->getParameter('clanekId');

        if ($ClanekId) {
            $clanek = $this->database->table('clanky')->get($ClanekId);
            $clanek->update($values);
            $this->flashMessage('Článek byl úspěšně upraven.', 'success');
        } else {
            $clanek = $this->database->table('clanky')->insert($values);
            $this->flashMessage('Članek byl úspěšně vložen.', 'success');
        }
        $this->redirect('this');
    }
    
    public function pridatObrazek($form, $values){
        $this->obrazkyManager->addObrazek($_FILES['obrazek']);
        $this->flashMessage('Obrazek byl úspěšně vložen.', 'success');
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
        $this->flashMessage('Clanek byl úspěšně smazán.', 'success');
        $this->redirect('default');
    }


}
