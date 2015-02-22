<?php
// source: C:\xampp\htdocs\PhpProject1\app/templates/Aktuality/default.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5299716019', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbb12f23ecc4_content')) { function _lbb12f23ecc4_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;if ($user->isInRole('admin')) { ?>
    <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Aktuality:nova"), ENT_COMPAT) ?>
">Nova aktualita</a>
<?php } ?>


<?php $iterations = 0; foreach ($aktuality as $aktualita) { ?><div class="aktualita">
    <div class="date"><?php echo Latte\Runtime\Filters::escapeHtml($template->date($aktualita->datum, 'j. n. Y'), ENT_NOQUOTES) ?></div>

    <h3><?php echo Latte\Runtime\Filters::escapeHtml($aktualita->nadpis, ENT_NOQUOTES) ?></h3>

<?php if ($user->isInRole('admin')) { ?>
        <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Aktuality:edit", array($aktualita->id_aktuality)), ENT_COMPAT) ?>
">Editovat</a>
        <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Aktuality:delete", array($aktualita->id_aktuality)), ENT_COMPAT) ?>
">Smazat</a>
<?php } ?>

    <div><?php echo Latte\Runtime\Filters::escapeHtml($aktualita->text, ENT_NOQUOTES) ?></div>
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
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 