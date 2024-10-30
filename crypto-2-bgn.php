<?php
/*
Plugin Name: Crypto2BGN
Plugin URI:  https://github.com/atanasantonov/crypto-2-bgn
Description: Coinmarketcap.com based plugin for conversion of cryptocurrencis to BGN
Version:     1.0.3
Author:      Atanas Antonov
Author URI:  https://unax.org/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: crypto2bgn
Domain Path: /languages/
*/

defined( 'ABSPATH' ) or die( 'I can\'t do anything alone! Sorry!' );

/**
 * Coinmarketcap request and output the result.
 *
 * @param array $atts     Shortcode attributes.
 * @param string $content Shortcode content.
 *
 * @return string
 */
function crypto2bgn_convert( $atts, $content = '') {
    $params = shortcode_atts( array(
        'currency' => 'BTC',
        'fiat'     => 'BGN',
        'decimals' => 5,
        'simple'   => '0',
    ), $atts);

    try {
        $parameters = array(
            'amount' => 1,
            'symbol' => esc_html( $params['currency'] ),
            'convert' => 'BGN' === $params['fiat'] ? 'EUR' : esc_html( $params['fiat'] ),
        );

        // API's URI
        $url = sprintf( 'https://pro-api.coinmarketcap.com/v2/tools/price-conversion?%s', http_build_query( $parameters ) );

        // Args.
        $args = array(
            'headers' => 'X-CMC_PRO_API_KEY: 0a5215b3-894b-4338-8b63-899cf61f4b38',
            'Content-Type' => 'application/json'
        );

        // API call
        $response = wp_remote_get( $url, $args );
        if ( is_wp_error( $response ) ) {
            throw new \Exception( $response->get_error_message() );
        }

        $response_body = wp_remote_retrieve_body( $response );
        if ( empty( $response_body ) ) {
            throw new \Exception( esc_html( 'No data', 'crypto2bgn' ) );
        }

        $json = json_decode( $response_body );
        if ( \json_last_error() !== JSON_ERROR_NONE ) {
            throw new \Exception( \json_last_error_msg() );
        }

        if ( $json->status->error_code !== 0 ) {
            throw new \Exception( \esc_html( $json->status->error_message ) );
        }

        if ( empty( $json->data ) || ! is_array( $json->data ) ) {
            throw new \Exception( esc_html( 'No data', 'crypto2bgn' ) );
        }

        $data = reset( $json->data );

        if( empty( $data->quote->EUR->price ) ) {
            throw new \Exception( esc_html( 'Price missing', 'crypto2bgn' ) );
        }

        // Get price.
        $price = floatval( $data->quote->EUR->price );

        // Get rate.
        $rate = 'BGN' === $params['fiat'] ? floatval( $price ) * 1.95583 : $price;
        $rate = number_format( $rate, (int) $params['decimals'], '.', '' );

        // Get symbol.
        if( empty( $data->symbol ) ) {
            throw new \Exception('Currency symbol missing.');
        }

        // Generate output.
        if ( $params['simple'] !== '0' ) {
            $output = $rate;
        } else {
            $output = sprintf( '1 %s = %s %s', $data->symbol, $rate, $params['fiat'] );
        }
    } catch ( Exception $e ) {
        $output = $e->getMessage();
    }

    ob_start();

    echo apply_filters( 'crypto2bgn_convert_output', $output, $price, $data->symbol, $params['fiat'] );

    return ob_get_clean();
}

add_shortcode( 'crypto_to_bgn', 'crypto2bgn_convert' );
