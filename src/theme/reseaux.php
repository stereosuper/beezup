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
	
	<section class='container'>
       <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>
        
		<h1 class='title-black'>
			<?php echo get_the_title( $networkPage ); ?>
			<?php if( get_field('title2', $networkPage) ){ ?>
				<span><?php the_field('title2', $networkPage); ?></span>
			<?php } ?>
		</h1>

        <?php if( get_field('subtitle', $networkPage) ){ ?>
            <h3><?php the_field('subtitle', $networkPage); ?></h3>
        <?php } ?>

        <?php the_field('text', $networkPage); ?>
        <?php the_post_thumbnail( 'full', $networkPage ); ?>


        <?php $countrySelect = beezup_get_country_select($channelsIndex, $country); ?>
        
        <?php if( $countrySelect ){ ?>
            <?php the_field('form', $networkPage); ?>

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
	</section>

    <section class='container'>
        <p id='sectorError' class='channels-error'></p>
        
        <div id='channelsList' class='channels-list'>
            <?php echo beezup_get_channels_to_display($channelsToDisplay, $noChannels); ?>
        </div>
    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>