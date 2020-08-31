<?php


namespace Demoshop\service;


class ApiOutput {

    /**
     * @param $output
     * @return false|string
     */
    public function buildJsonOutput ( $output ) {
        return json_encode( $output );
    }

    /**
     * @param $output
     * @param int $responseCode
     */
    public function sendJsonOutput ( $output, $responseCode = 200 ) {
        http_response_code( $responseCode );
        echo $output;
        die;
    }

}