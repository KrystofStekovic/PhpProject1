<?php
// source: C:\xampp\htdocs\PhpProject1\app/templates/Produkty/default.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('3360449591', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb7e80ee98d8_content')) { function _lb7e80ee98d8_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;if ($user->isInRole('admin')) { ?>
    <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Produkty:novy"), ENT_COMPAT) ?>
">Novy produkt</a>
<?php } $iterations = 0; foreach ($produkty as $produkt) { ?><div>
    <?php echo Latte\Runtime\Filters::escapeHtml($produkt->nazev, ENT_NOQUOTES) ?>

    <?php echo Latte\Runtime\Filters::escapeHtml($produkt->popis, ENT_NOQUOTES) ?>

    <?php echo Latte\Runtime\Filters::escapeHtml($produkt->cena, ENT_NOQUOTES) ?>

    <?php echo Latte\Runtime\Filters::escapeHtml($produkt->id_materialu, ENT_NOQUOTES) ?>

    <?php echo Latte\Runtime\Filters::escapeHtml($produkt->mnozstvi, ENT_NOQUOTES) ?>


    <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["mnozstviForm"], array()) ?>

    <?php $_input = is_object($form['mnozstvi']) ? $form['mnozstvi'] : $_form[$form['mnozstvi']]; if ($_label = $_input->getLabel()) echo $_label->startTag() ;$_input = is_object($form['mnozstvi']) ? $form['mnozstvi'] : $_form[$form['mnozstvi']]; echo $_input->getControl() ;if ($_label) echo $_label->endTag() ?>

    <?php $_input = is_object($form['id_produktu']) ? $form['id_produktu'] : $_form[$form['id_produktu']]; echo $_input->getControl()->addAttributes(array('value'=>$produkt->id_produktu)) ?>

    <?php $_input = is_object($form['send']) ? $form['send'] : $_form[$form['send']]; echo $_input->getControl() ?>

<?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>

<?php if ($user->isInRole('admin')) { ?>
    <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Produkty:edit", array($produkt->id_produktu)), ENT_COMPAT) ?>
">Editovat</a>
    <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Produkty:delete", array($produkt->id_produktu)), ENT_COMPAT) ?>
">Smazat</a>
<?php } ?>
</div><?php $iterations++; } 
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
?>


<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 