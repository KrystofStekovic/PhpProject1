<?php
// source: C:\xampp\htdocs\PhpProject1\app/templates/@layout.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5096363699', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb9327889ff7_scripts')) { function _lb9327889ff7_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>        <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery.js"></script>
        <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/netteForms.js"></script>
        <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/main.js"></script>
<?php
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
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Bio-Culture</title>
        <link rel="stylesheet" type="text/css" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/screen.css">
        <link rel="shortcut icon" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/favicon.ico">
    </head>

    <body>
        <header>
            <div class="login">
<?php if ($user->isLoggedIn()) { ?>
                    <div class="loginLine">
                        <a class="loginLine" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Sign:out"), ENT_COMPAT) ?>
">Odhlasit</a>
                    </div>
<?php } else { ?>
                    <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["signInForm"], array()) ?>

                        <table>
                            <tr class="required">
                                <td><?php if ($_label = $_form["email"]->getLabel()) echo $_label  ?></td>
                                <td><?php echo $_form["email"]->getControl() ?></td>
                            </tr>
                            <tr class="required">
                                <td><?php if ($_label = $_form["heslo"]->getLabel()) echo $_label  ?></td>
                                <td><?php echo $_form["heslo"]->getControl() ?></td>
                            </tr>
                            <td colspan="2">
                                <?php echo $_form["send"]->getControl() ?>

                                <button formaction="Sign/novy">Registrace</button>
                            </td>
                            </tr>
                        </table>
                    <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>

<?php } ?>
            </div>
        </header>
            
        <nav>
            <a class="prvekMenu" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Homepage:default"), ENT_COMPAT) ?>
">Hlavni Stranka</a> 
            <a class="prvekMenu" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Clanky:default"), ENT_COMPAT) ?>
">Clanky</a>
            <a class="prvekMenu" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Aktuality:default"), ENT_COMPAT) ?>
">Aktuality</a>
            <a class="prvekMenu" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Produkty:default"), ENT_COMPAT) ?>
">Produkty</a>
            <a class="prvekMenu" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Objednavky:default"), ENT_COMPAT) ?>
">Objednavky</a>
<?php if ($user->isInRole('admin')) { ?>
                <a class="prvekMenu" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Materialy:default"), ENT_COMPAT) ?>
">Materialy</a>
<?php } ?>
        </nav>

        <script> document.documentElement.className += ' js'</script>

<?php $iterations = 0; foreach ($flashes as $flash) { ?>        <div class="flash <?php echo Latte\Runtime\Filters::escapeHtml($flash->type, ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; } ?>

        <div class="obsah">
<?php Latte\Macros\BlockMacros::callBlock($_b, 'content', $template->getParameters()) ?>
        </div>

<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>
    </body>
</html>
