<?php 
/*
Template Name: Réseaux
*/

$networkPage = get_field('networkPage', 'options');
$isNetworkPage = $post->ID === $networkPage;

$fieldLang = get_field('lang', 'options');
$defaultCountry = $fieldLang ? $fieldLang : 'FRA';

if( !session_id() ) session_start();
$country = isset( $_SESSION['country'] ) ? $_SESSION['country'] : $defaultCountry;

if( isset( $_GET['country'] ) ){
    $country = $_GET['country'];
    $_SESSION['country'] = $country;
}

$dataToDisplay = beezup_get_data_to_display($isNetworkPage, $country, get_field('type'));

$channelsIndex = $dataToDisplay['channelsIndex'];
$channelsToDisplay = $dataToDisplay['channelsToDisplay'];
$channelsByType = $dataToDisplay['channelsByType'];
$noChannels = $dataToDisplay['noChannels'];


get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container page-intro'>
        
        <div class='page-intro-title'>
            <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

            <h1 class='page-title'>
                <?php get_field('title') ? the_field('title') : the_title(); ?>
            </h1>

            <?php if( get_field('subtitle') ){ ?>
                <h2><?php the_field('subtitle'); ?></h2>
            <?php }elseif( get_field('subtitle', $networkPage) ){ ?>
                <h2><?php the_field('subtitle', $networkPage); ?></h2>
            <?php } ?>

            <?php if( get_field('text') ){ ?>
                <?php the_field('text'); ?>
            <?php }elseif( get_field('text', $networkPage) ){ ?>
                <?php the_field('text', $networkPage); ?>
            <?php } ?>
        </div>
        
        <div class='page-intro-img'>
            <?php if( has_post_thumbnail() ){ ?>
                <?php the_post_thumbnail( 'full' ); ?>
            <?php }elseif( has_post_thumbnail($networkPage) ){ ?>
                <?php the_post_thumbnail( 'full', $networkPage ); ?>
            <?php } ?>
        </div>

    </section>
    
    <section class='block-full block-pale no-pad above-title'>
        <div class='container relative'>

            <?php $countrySelect = beezup_get_country_select($channelsIndex, $country); ?>
            
            <?php if( $countrySelect ){ ?>
                <form action='<?php the_permalink(); ?>' method='GET' class='js-inline-form channels-form'>
                    <?php if( get_field('form') ){ ?>
                        <legend><?php the_field('form'); ?></legend>
                    <?php }elseif( get_field('form', $networkPage) ){ ?>
                        <legend><?php the_field('form', $networkPage); ?></legend>
                    <?php } ?>

                    <fieldset>
                        <?php echo beezup_get_sector_select(); ?>
                        <?php echo $countrySelect; ?>
                        <div class='field-inline channels-search'>
                            <input type='search' name='' id='channelsSearch' data-list='.channels-list'>
                            <label for='channelsSearch'><?php _e('Search', 'beezup'); ?>...</label>
                            <svg class='icon'><use xlink:href='#icon-search'></use></svg>
                            <?php get_template_part( 'includes/loader' ); ?>
                        </div>

                        <button type='submit' name='' value='true' class='btn-secondary'>GO</button>
                    </fieldset>
                </form>
            <?php } ?>


            <?php $subPages = get_pages( array('child_of' => $networkPage) ); ?>
            <?php $typePages = beezup_get_types_pages($channelsByType, $subPages, $country, $post->ID); ?>

            <?php if( $typePages ){ ?>
                <div class='channels-type dropdown js-dropdown closed'>
                    <ul class='dropdown-list'>
                        <?php if( $isNetworkPage ){ ?>
                            <li class='current'><?php _e('All types of channels', 'beezup'); ?><svg class='icon'><use xlink:href='#icon-check'></use></svg></li>
                        <?php }else{ ?>
                            <li><a href='<?php echo get_the_permalink($networkPage); ?>' class='link-arrow'><?php _e('All types of channels', 'beezup'); ?></a></li>
                        <?php } ?>
                        <?php echo $typePages; ?>
                    </ul>

                    <button class='btn-list js-btn-list' type='button'>
                        <?php _e('Open channels type list', 'beezup'); ?>
                        <svg class='icon'><use xlink:href='#icon-list'></use></svg>
                    </button>

                    <button class='btn-close js-btn-list' type='button'>
                        <?php _e('Close channels type list', 'beezup'); ?>
                        <svg class='icon'><use xlink:href='#icon-close'></use></svg>
                    </button>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class='block-full no-pad'>
        <div class='container channels' id='channels'>
            <p id='sectorError' class='channels-error'></p>
            
            <div id='channelsList'>
                <?php echo beezup_get_channels_to_display($channelsToDisplay, $noChannels); ?>
            </div>

            <?php get_template_part( 'includes/loader' ); ?>
        </div>
    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>