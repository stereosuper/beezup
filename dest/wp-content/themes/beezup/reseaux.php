<?php 
/*
Template Name: Réseaux
*/

$networkPage = get_field('networkPage', 'options');
$isNetworkPage = $post->ID === $networkPage;

$currentLang = get_field('lang2', 'options');

$fieldLang = get_field('lang', 'options');
$defaultCountry = $fieldLang ? $fieldLang : 'FRA';
$country = isset( $_GET['country'] ) ? $_GET['country'] : $defaultCountry;

$channelsIndex = beezup_get_data_transient( 'channels_index_' . $currentLang, 'lov/www_ChannelCountry' );
$channelsTypeIndex = beezup_get_data_transient( 'channels_type_index_' . $currentLang, 'lov/ChannelType' );

$channelsByType = get_site_transient('channels_by_type');

$allChannels = [];
$channelsToDisplay = [];

if( $channelsIndex && property_exists($channelsIndex, 'items') ){
    foreach( $channelsIndex->items as $channel ){
        $code = $channel->codeIdentifier;
        $allChannels[$code] = beezup_get_data_transient( 'channels_' . $code, 'channels/' . $code );
        if( !$channelsByType ){
            $channelsByType[$code] = beezup_get_channels_by_type( $channelsTypeIndex, $allChannels[$code] );
        }
    }
}

$noChannels = false;

if( $isNetworkPage ){
    if( isset($allChannels[$country]) && property_exists($allChannels[$country], 'channels') ){
        $channelsToDisplay = $allChannels[$country]->channels;
    }
}else{
    if( $channelsByType && isset($channelsByType[$country]) ){
        if( isset($channelsByType[$country][get_field('type')]) ){
            $channelsToDisplay = $channelsByType[$country][get_field('type')];
        }else{
            $noChannels = true;
        }
    }
}

if( $channelsToDisplay ){
    usort($channelsToDisplay, 'beezup_sort_by_name');
}

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container'>
        <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb(); } ?>
        
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

        <?php if( $channelsIndex && property_exists($channelsIndex, 'items') ){ ?>
            <?php the_field('form', $networkPage); ?>

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
        <?php } ?>

        <?php if( $channelsByType && isset($channelsByType[$country]) ){ ?>
            <?php $subPages = get_pages( array('child_of' => $networkPage) ); ?>
            <?php if( $subPages ){ ?>
                <ul>
                    <li class='<?php if( $isNetworkPage ) echo "current"; ?>'><a href='<?php echo get_the_permalink($networkPage); ?>'><?php _e('All types of channels', 'beezup'); ?></a></li>
                    <?php foreach( $subPages as $subPage ){ ?>
                        <?php if( isset($channelsByType[$country][get_field('type', $subPage->ID)]) ){ ?>
                            <li class='<?php if( $post->ID === $subPage->ID ) echo "current"; ?>'>
                                <a href='<?php echo $subPage->guid . "?country=" . $country; ?>'><?php echo $subPage->post_title; ?></a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>
	</section>

    <section class='container'>
        <?php if( $channelsToDisplay ){ ?>
            <ul>
                <?php foreach( $channelsToDisplay as $partner ){ ?>
                    <?php $name = $partner->name; ?>
                    <li>
                        <a href='<?php echo $partner->homeUrl; ?>' title='<?php echo $name; ?>' target='_blank'>
                            <?php echo $name; ?>
                            <img src='<?php echo $partner->logoUrl; ?>' alt='<?php echo $name; ?>'>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php }else{ ?>
            <?php if( $noChannels ){ ?>
                <p><?php _e("There are no channels of this type in this country.", 'beezup'); ?></p>
            <?php }else{ ?>
                <p><?php _e("Channels can't be displayed at this time. Please come back later!", 'beezup'); ?></p>
            <?php } ?>
        <?php } ?>
    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>