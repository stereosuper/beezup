<?php

require_once( 'wp-load.php' );

$channelsIndex = beezup_get_data_transient( 'channels_index', 'lov/www_ChannelCountry' );

if( $channelsIndex ){
    foreach( $channelsIndex->items as $channel ){
        $code = $channel->codeIdentifier;
        delete_transient( 'channels_' . $code );
        echo( 'Transient for ' . $code . ' channels deleted. <br>' );
    }
}

delete_transient( 'channels_index' );
echo( 'Transient for channels index deleted.' );

?>