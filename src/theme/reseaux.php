<?php 
/*
Template Name: Réseaux
*/

$networkPage = get_field('networkPage', 'options');
$isNetworkPage = $post->ID === $networkPage;

$fieldLang = get_field('lang', 'options');
$defaultCountry = $fieldLang ? $fieldLang : 'FRA';

$country = isset( $_GET['country'] ) ? $_GET['country'] : $defaultCountry;

if( !session_id() ) session_start();
if( isset( $_SESSION['country'] ) ){
    $country = $_SESSION['country'];
}

$dataToDisplay = beezup_get_data_to_display($isNetworkPage, $country);

$channelsIndex = $dataToDisplay['channelsIndex'];
$channelsToDisplay = $dataToDisplay['channelsToDisplay'];
$channelsByType = $dataToDisplay['channelsByType'];
$noChannels = $dataToDisplay['noChannels'];


get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container page-intro'>
        
        <div class='page-intro-title'>
            <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

            <h1 class='page-title title-black'>
                <?php the_title(); ?>
                <?php if( get_field('title2') ){ ?>
                    <span><?php the_field('title2'); ?></span>
                <?php } ?>
            </h1>

            <?php if( get_field('subtitle') ){ ?>
                <h3 class='h2'><?php the_field('subtitle'); ?></h3>
            <?php }elseif( get_field('subtitle', $networkPage) ){ ?>
                <h3 class='h2'><?php the_field('subtitle', $networkPage); ?></h3>
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
    
    <section class='block-full no-pad'>
        <div class='container'>

            <?php $countrySelect = beezup_get_country_select($channelsIndex, $country); ?>
            
            <?php if( $countrySelect ){ ?>
                <?php if( get_field('form') ){ ?>
                    <?php the_field('form'); ?>
                <?php }elseif( get_field('form', $networkPage) ){ ?>
                    <?php the_field('form', $networkPage); ?>
                <?php } ?>

                <form action='<?php the_permalink(); ?>' method='GET'>
                    <?php echo beezup_get_sector_select(); ?>
                    <?php echo $countrySelect; ?>
                    <button type='submit' name='filter' value='true' id='channelsSubmit'>Go</button>
                </form>
            <?php } ?>


            <?php $subPages = get_pages( array('child_of' => $networkPage) ); ?>
            <?php $typePages = beezup_get_types_pages($channelsByType, $subPages, $country, $post->ID); ?>

            <?php if( $typePages ){ ?>
                <ul>
                    <li class='<?php if( $isNetworkPage ) echo "current"; ?>'><a href='<?php echo get_the_permalink($networkPage); ?>'><?php _e('All types of channels', 'beezup'); ?></a></li>
                    <?php echo $typePages; ?>
                </ul>
            <?php } ?>
        </div>
    </section>

    <section class='block-full no-pad'>
        <div class='container'>
            <p id='sectorError' class='channels-error'></p>
            
            <div id='channelsList' class='channels-list'>
                <?php echo beezup_get_channels_to_display($channelsToDisplay, $noChannels); ?>
            </div>
        </div>
    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>