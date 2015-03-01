<?php
// source: C:\xampp\htdocs\PhpProject1\app/templates/@layout.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('9509387024', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block head
//
if (!function_exists($_b->blocks['head'][] = '_lbaf691322f0_head')) { function _lbaf691322f0_head($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lba40a6516ad_scripts')) { function _lba40a6516ad_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
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

        <title><?php if (isset($_b->blocks["title"])) { ob_start(); Latte\Macros\BlockMacros::callBlock($_b, 'title', $template->getParameters()); echo $template->striptags(ob_get_clean()) ?>
 | <?php } ?>Bio-Culture</title>

        <link rel="stylesheet" type="text/css" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/screen.css">
        <link rel="shortcut icon" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/favicon.ico">
        <?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['head']), $_b, get_defined_vars())  ?>

    </head>

    <body>
        <div class="logo">
            <div class="login">
<?php if ($user->isLoggedIn()) { ?>
                    <div class="loginLine">
                        <a class="loginLine" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Sign:out"), ENT_COMPAT) ?>
">Odhlasit</a>
                    </div>
<?php } else { ?>
                    <div class="loginLine">
                        <a class="loginLine" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Sign:in"), ENT_COMPAT) ?>
">Prihlasit</a>
                    </div>
                    <div class="loginLine">
                        <a class="loginLine" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Sign:novy"), ENT_COMPAT) ?>
">Registrace</a>
                    </div>
<?php } ?>
            </div>
        </div>
        <div class="menu">
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
        </div>

        <script> document.documentElement.className += ' js'</script>

<?php $iterations = 0; foreach ($flashes as $flash) { ?>        <div class="flash <?php echo Latte\Runtime\Filters::escapeHtml($flash->type, ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; } ?>

        <div class="obsah">
<?php Latte\Macros\BlockMacros::callBlock($_b, 'content', $template->getParameters()) ?>
        </div>

<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>
    </body>
</html>
