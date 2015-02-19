<?php
// source: C:\xampp\htdocs\PhpProject1\app/templates/Materialy/default.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5608683819', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb8745e46cd4_content')) { function _lb8745e46cd4_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Materialy:novy"), ENT_COMPAT) ?>
">Novy material</a>

<table>
<?php $iterations = 0; foreach ($materialy as $material) { ?>    <tr>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($material->nazev, ENT_NOQUOTES) ?></td>
        <td><?php echo Latte\Runtime\Filters::escapeHtml($material->mnozstvi, ENT_NOQUOTES) ?></td>
        <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Materialy:edit", array($material->id_materialu)), ENT_COMPAT) ?>
">Editovat</a></td>
        <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Materialy:delete", array($material->id_materialu)), ENT_COMPAT) ?>
">Smazat</a></td>
        

    </tr>
<?php $iterations++; } ?>
</table><?php
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