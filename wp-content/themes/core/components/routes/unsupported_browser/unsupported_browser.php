<?php
declare( strict_types=1 );

$controller = \Tribe\Project\Templates\Components\routes\unsupported_browser\Controller::factory();
?>
<!DOCTYPE html>
<html>
<head>

    <title><?php echo esc_attr( __('Unsupported Browser') ) ?> | <?php echo esc_html( $controller->name ) ?></title>

    <meta charset="utf-8">
    <meta name="author" content="{{ name|esc_attr }}">
    <meta http-equiv="cleartype" content="on">
    <meta name="robots" content="noindex, nofollow">

    <?php echo $controller->styles ?>

    <link rel="shortcut icon" href="<?php esc_url( $controller->favicon ) ?>">

    <?php do_action( 'tribe/unsupported_browser/head') ?>

</head>
<body>
<main id="main-content">

<div class="site-header">
    <div class="l-container">
        <h1 class="site-brand">
            <img src="<?php echo $controller->legacy_logo_header ?>"
                 class="site-logo site-logo--header"
                 alt="<?php echo $controller->name?> <?php echo esc_attr( __('logo', 'tribe') ) ?>"/>
        </h1>
    </div>
</div>

<div class="site-content">
    <div class="l-container">

        <div class="site-content__content">
            <h2><?php echo $controller->legacy_browser_title ?></h2>
            <p><?php echo $controller->legacy_browser_content ?></p>
        </div>

        <ul class="browser-list">
            <li class="browser-list__item">
                <a href="http://www.google.com/chrome/"
                   class="browser-list__item-anchor"
                   rel="external noopener"
                   target="_blank">
	                           <span class="browser-list__item-image">
	                               <img src="<?php echo $controller->legacy_browser_icon_chrome ?>"
                                        alt="<?php echo esc_attr( __('Chrome browser logo', 'tribe') ) ?>"/>
	                           </span>
	                <?php echo esc_html( __('Chrome', 'tribe') ) ?>
                </a>
            </li>
            <li class="browser-list__item">
                <a href="https://www.mozilla.org/firefox/new/"
                   class="browser-list__item-anchor"
                   rel="external noopener"
                   target="_blank">
	                           <span class="browser-list__item-image">
	                               <img src="<?php echo esc_url( $controller->legacy_browser_icon_firefox ) ?>"
                                        alt="<?php echo esc_attr( __('Firefox browser logo') ) ?>"/>
	                           </span>
	                <?php echo esc_html( __('Firefox') ) ?>
                </a>
            </li>
            <li class="browser-list__item">
                <a href="https://support.apple.com/downloads/#safari"
                   class="browser-list__item-anchor"
                   rel="external noopener"
                   target="_blank">
	                           <span class="browser-list__item-image">
	                               <img src="<?php echo esc_url( $controller->legacy_browser_icon_safari ) ?>"
                                        alt="<?php echo esc_attr( __('Safari browser logo') ) ?>"/>
	                           </span>
	                <?php echo esc_html( __('Safari') ) ?>
                </a>
            </li>
            <li class="browser-list__item">
                <a href="http://windows.microsoft.com/internet-explorer/download-ie"
                   class="browser-list__item-anchor"
                   rel="external noopener"
                   target="_blank">
	                           <span class="browser-list__item-image">
	                               <img src="<?php echo esc_url( $controller->legacy_browser_icon_ie ) ?>"
                                        alt=""<?php echo esc_attr( __('Internet Explorer browser logo') ) ?>"/>
	                           </span>
	                <?php echo esc_html( __('Internet Explorer') ) // TODO Move to Edge. No longer supporting IE11.?>
                </a>
            </li>
        </ul>

    </div>
</div>

<div class="site-footer">
    <div class="l-container">

        <img src="<?php echo esc_url( $controller->legacy_logo_footer ) ?>"
             class="site-logo site-logo--footer"
             alt="<?php echo esc_attr( $controller->name ) ?> <?php echo esc_attr( __('logo') ) ?>"/>

        <p class="site-footer__copy"><?php sprintf( __( '%s %d All Rights Reserved.', 'tribe' ), '&copy;', date( 'Y' ) );?> <?php echo esc_attr( $controller->name ) ?>.</p>

    </div>
</div>

</body>
</html>
