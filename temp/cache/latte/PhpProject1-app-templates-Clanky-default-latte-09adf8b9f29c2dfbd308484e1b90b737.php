<?php
// source: C:\xampp\htdocs\PhpProject1\app/templates/Clanky/default.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('1336500886', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbf7bd0ca0c1_content')) { function _lbf7bd0ca0c1_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;if ($user->isInRole('admin')) { ?>
    <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Clanky:novy"), ENT_COMPAT) ?>
">Novy clanek</a>
<?php } ?>

<?php $iterations = 0; foreach ($clanky as $clanek) { ?><div class="post">
    <div class="date"><?php echo Latte\Runtime\Filters::escapeHtml($template->date($clanek->datum, 'j. n. Y'), ENT_NOQUOTES) ?></div>

    <h3><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Clanky:detail", array($clanek->id_clanku)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($clanek->nadpis, ENT_NOQUOTES) ?></a></h3>

<?php if ($user->isInRole('admin')) { ?>
        <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Clanky:edit", array($clanek->id_clanku)), ENT_COMPAT) ?>
">Editovat</a>
        <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Clanky:delete", array($clanek->id_clanku)), ENT_COMPAT) ?>
">Smazat</a>
<?php } ?>

    <div><?php echo Latte\Runtime\Filters::escapeHtml($template->truncate($clanek->text, 25), ENT_NOQUOTES) ?></div>
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