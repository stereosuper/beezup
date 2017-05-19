<?php

/*-----------------------------------------------------------------------------------*/
/* Require WP functions
/*-----------------------------------------------------------------------------------*/
require_once( 'wp-load.php' );


/*-----------------------------------------------------------------------------------*/
/* Delete transients
/*-----------------------------------------------------------------------------------*/
$channelsIndex = beezup_get_data_transient( 'channels_index', 'lov/www_ChannelCountry' );

if( $channelsIndex ){
    foreach( $channelsIndex->items as $channel ){
        $code = $channel->codeIdentifier;
        delete_transient( 'channels_' . $code );
        echo( 'Transient for ' . $code . ' channels deleted. <br>' );
    }
}

delete_transient( 'channels_type_index' );
echo( 'Transient for channels type index deleted. <br>' );

delete_transient( 'channels_by_type' );
echo( 'Transient for channels ordered by type deleted. <br>' );

delete_transient( 'channels_index' );
echo( 'Transient for channels index deleted. <br><br>' );


/*-----------------------------------------------------------------------------------*/
/* Register new transients
/*-----------------------------------------------------------------------------------*/
// Création du transient qui contiendra la liste des types
$channelsTypeIndex = beezup_get_data_transient( 'channels_type_index', 'lov/ChannelType' );
if( $channelsTypeIndex ){
    echo( 'Transient for channels type index created. <br>' );
}else{
    echo( "ERROR: Transient for channels type index couldn't be created. <br>" );
}

// Création du transient qui contiendra la liste des langues
$channelsIndex = beezup_get_data_transient( 'channels_index', 'lov/www_ChannelCountry' );
if( $channelsIndex ){
    echo( 'Transient for channels index created. <br>' );
}else{
    echo( "ERROR: Transient for channels index couldn't be created. <br>" );
}

if( $channelsIndex ){
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

        if( !empty($channelsByType) ) continue;
        if( !$channelsTypeIndex->items || !$allChannels[$code]->channels ) continue;

        // Remplissage du tableau qui servira à créer le transient qui contient les channels triés par pays et par type
        foreach( $allChannels[$code]->channels as $channel ){
            foreach( $channelsTypeIndex->items as $type ){
                if($channel->types[0] !== $type->codeIdentifier) continue;
                $channelsByType[$code][$type->codeIdentifier][] = $channel;
            }
        }
    }
}

if( !empty($channelsByType)){
    set_transient( 'channels_by_type', $channelsByType, MONTH_IN_SECONDS );
    echo( 'Transient for channels ordered by type created.' );
}else{
    echo( "ERROR: Transient for channels ordered by type couldn't be created." );
}

?>