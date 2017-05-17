<?php 
/*
Template Name: Réseaux
*/

$apiUrl = 'https://api.beezup.com/v2/public/';

$country = isset( $_GET['country'] ) ? $_GET['country'] : '';
$currentUrl = $country ? 'channels/' . $country : 'channels/USA';

$channelsIndex = json_decode( wp_remote_get($apiUrl . 'lov/www_ChannelCountry')['body'] );
$currentChannel = json_decode( wp_remote_get($apiUrl . $currentUrl)['body'] );


// print_r(json_decode( wp_remote_get($apiUrl . 'lov')['body'] ));


get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container'>
        <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb(); } ?>
        
		<h1 class='title-black'>
			<?php the_title(); ?>
			<?php if( get_field('title2') ){ ?>
				<span><?php the_field('title2'); ?></span>
			<?php } ?>
		</h1>

        <?php if( get_field('subtitle') ){ ?>
            <h3><?php the_field('subtitle'); ?></h3>
        <?php } ?>

        <?php the_field('text'); ?>

        <?php the_post_thumbnail( 'full' ); ?>

        <form action='<?php the_permalink(); ?>' method='GET'>
            <select name='country'>
                <?php foreach( $channelsIndex->items as $channel ){ ?>
                    <?php $code = $channel->codeIdentifier; ?>
                    <option value='<?php echo $code; ?>' <?php if($code === $country){ echo 'selected'; } ?>>
                        <?php echo $channel->translationText; ?>
                    </option>
                <?php } ?>
            </select>

            <button type='submit' name='filter' value='true'>Go</button>
        </form>
	</section>

    <section class='container'>
        <ul>
            <?php foreach($currentChannel->channels as $partner){ ?>
                <?php $name = $partner->name; ?>
                <li>
                    <a href='<?php echo $partner->homeUrl; ?>' title='<?php echo $name; ?>' target='_blank'>
                        <?php echo $name; ?>
                        <img src='<?php echo $partner->logoUrl; ?>' alt='<?php echo $name; ?>'>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>