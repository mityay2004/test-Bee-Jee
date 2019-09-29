<?php

namespace system;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

/**
 * Class for working with URI
 */
class Uri
{
    public function getBaseUrl($s)
    {
        $ssl      = ( ! empty($s['HTTPS']) && $s['HTTPS'] === 'on' );
        $sp       = strtolower($s['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '' );
        $port     = $s['SERVER_PORT'];
        $port     = ((! $ssl && $port === '80') || ($ssl && $port === '443')) ? '' : ':'.$port;
        $host     = isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null ;
        $host     = isset($host) ? $host : $s['SERVER_NAME'] . $port;
        return $protocol . '://' . $host;
    }

    public function parseUri(string $uri): array
    {
        $preParsed = parse_url($uri);
        if (isset($preParsed['query'])) {
            $tmp = rawurldecode($preParsed['query']);
            parse_str($tmp, $preParsed['query']);
        }
        return $preParsed;
    }
    
    public function addGetParam(string $uri, array $param): string
    {
        $preParsed = $this->parseUri($uri);
        foreach ($param as $kk => $pp) {
            $preParsed['query'][$kk] = $pp;
        }
        $res = $uri;
        if (strpos($uri, '?') !== false) {
            $tmp = explode('?', $uri);
            $res = rtrim($tmp['0'], '/');
        }
        return $res . "?" . http_build_query($preParsed['query']);
    }
    
    public function removeGetParam(string $uri, array $param): string
    {
        $preParsed = $this->parseUri($uri);
        foreach ($param as $pp) {
            if (isset($preParsed['query'][$pp])) {
                unset($preParsed['query'][$pp]);
            }
        }
        $res = $uri;
        if (strpos($uri, '?') !== false) {
            $tmp = explode('?', $uri);
            $res = rtrim($tmp['0'], '/');
        }
        if (count($preParsed['query']) === 0) {
            return $res;
        }
        return $res . "?" . http_build_query($preParsed['query']);
    }
    
    public static function redirect(string $location, int $code = 302)
    {
        header('Location: ' . $location, TRUE, $code);
        exit;
    }
}
