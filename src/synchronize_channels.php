<?php

/*-----------------------------------------------------------------------------------*/
/* Require WP functions
/*-----------------------------------------------------------------------------------*/
require_once( 'wp-load.php' );

$sites = get_sites();


/*-----------------------------------------------------------------------------------*/
/* Delete transients
/*-----------------------------------------------------------------------------------*/
// Suppression + création des transients qui contiendront la liste des pays par langue + ceux qui contiendront la liste des types par langue
foreach( $sites as $site ){
    switch_to_blog( $site->blog_id );
    $lang = get_field('lang2', 'options');

    delete_site_transient( 'channels_index_' . $lang );
    echo( 'Transient for channels index ' . $lang . ' deleted. <br>' );

    $transientChannelsIndex = beezup_get_data_transient( 'channels_index_' . $lang, 'lov/www_ChannelCountry', array('accept-language' => $lang) );
    $allChannelsIndex[] = $transientChannelsIndex;
    if( $transientChannelsIndex ){
        echo( 'Transient for channels index ' . $lang . ' created. <br>' );
    }else{
        echo( "ERROR: Transient for channels index " . $lang . "  couldn't be created. <br>" );
    }

    delete_site_transient( 'channels_type_index_' . $lang );
    echo( 'Transient for channels type index ' . $lang . ' deleted. <br>' );

    $transientChannelsTypeIndex = beezup_get_data_transient( 'channels_type_index', 'lov/ChannelType', array('accept-language' => $lang) );
    $allChannelsTypeIndex[] = $transientChannelsTypeIndex;
    if( $transientChannelsIndex ){
        echo( 'Transient for channels type index ' . $lang . ' created. <br>' );
    }else{
        echo( "ERROR: Transient for channels type index " . $lang . "  couldn't be created. <br>" );
    }
}

$channelsIndex = $allChannelsIndex[0];
$channelsTypeIndex = $allChannelsTypeIndex[0];

// Suppression des channels par pays
if( $channelsIndex && property_exists($channelsIndex, 'items') ){
    foreach( $channelsIndex->items as $channel ){
        $code = $channel->codeIdentifier;
        delete_site_transient( 'channels_' . $code );
        echo( 'Transient for ' . $code . ' channels deleted. <br>' );
    }
}else{
    echo( "ERROR: Transient for channels by country couldn't be deleted. <br>" );
}

delete_site_transient( 'channels_by_type' );
echo( 'Transient for channels ordered by type deleted. <br><br>' );


/*-----------------------------------------------------------------------------------*/
/* Register new transients
/*-----------------------------------------------------------------------------------*/
if( $channelsIndex && property_exists($channelsIndex, 'items') ){
    foreach( $channelsIndex->items as $channel ){
        $code = $channel->codeIdentifier;
        // Création du transient contenant les channels pour une langue donnée
        $allChannels[$code] = beezup_get_data_transient( 'channels_' . $code, 'channels/' . $code );
        if( $allChannels[$code] ){
            echo( 'Transient for ' . $code . ' channels created. <br>' );
        }else{
            echo( "ERROR: Transient for " . $code . " channels couldn't be created." );
        }
        // $allChannelsTogether = array_merge( $allChannelsTogether, $allChannels[$code]->channels );

        // Remplissage du tableau qui servira à créer le transient qui contient les channels triés par pays et par type
        $channelsByType[$code] = beezup_get_channels_by_type( $channelsTypeIndex, $allChannels[$code] );
    }
}else{
    echo( "ERROR: Transient for channels by country couldn't be created. <br>" );
}

if( !empty($channelsByType)){
    set_site_transient( 'channels_by_type', $channelsByType, MONTH_IN_SECONDS );
    echo( 'Transient for channels ordered by type created. <br>' );
}else{
    echo( "ERROR: Transient for channels ordered by type couldn't be created. <br>" );
}


/*-----------------------------------------------------------------------------------*/
/* Create channels by type subpages in WordPress
/*-----------------------------------------------------------------------------------*/
if( $channelsTypeIndex && property_exists($channelsTypeIndex, 'items') ){
    foreach( $sites as $site ){
        // On crée les pages dans chaque site
        switch_to_blog( $site->blog_id );
        
        echo '<br>';

        $lang = get_field('lang2', 'options');

        // Récupération de la page réseaux qui sera la page parente des pages "types de canaux"
        $parentPageId = get_field('networkPage', 'options');
        $parentPage = get_post( $parentPageId );

        if( !$parentPage ){
            echo "ERROR: Subpages couldn't be created on '" . $lang . "' since parent page doesn't exist.";
            continue;
        }

        foreach( $channelsTypeIndex->items as $type ){
            // Si la page existe deja, on ne fait rien
            $page = get_page_by_path( $parentPage->post_name . '/' . sanitize_text_field( $type->translationText ), OBJECT );
            if( $page ){
                echo( "Subpage for " . $type->translationText . " on '" . $lang . "' already exists. <br>" );
                continue;
            }

            // Sinon on la crée et on l'insère dans la bdd
            $newPage = wp_insert_post( array(
                'post_title' => $type->translationText,
                'post_name' => sanitize_text_field( $type->translationText ),
                'page_template' => 'reseaux.php',
                'post_parent' => get_field('networkPage', 'options'),
                'post_type' => 'page',
                'post_status' => 'publish'
            ) );
            if( is_wp_error($newPage) ){
                echo( "ERROR: The subpage for " . $type->translationText . " on '" . $lang . "' couldn't be created. <br>" );
            }else{
                update_field('field_5922e0a0d5d62', $type->codeIdentifier, $newPage);
                echo( "Subpage for " . $type->translationText . " on '" . $lang . "' created. <br>" );
            }
        }
    }
}

?>