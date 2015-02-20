<?php
// source: C:\xampp\htdocs\PhpProject1\app/templates/Objednavky/default.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('8413265786', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbc321f253cb_content')) { function _lbc321f253cb_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;$iterations = 0; foreach ($kosiky as $kosik) { ?><div>
    Datum vytvoreni: <?php echo Latte\Runtime\Filters::escapeHtml($template->date($kosik->datum_vytvoreni, 'j. n. Y G:i'), ENT_NOQUOTES) ?><br>
    Pocet produktu v kosiku: <?php echo Latte\Runtime\Filters::escapeHtml($kosik->produkty, ENT_NOQUOTES) ?><br>
    Celkova cena kosiku: <?php echo Latte\Runtime\Filters::escapeHtml($kosik->suma, ENT_NOQUOTES) ?>

    <hr>
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