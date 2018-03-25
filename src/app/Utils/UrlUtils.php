<?php

namespace RaphaelVilela\CrudRails\Utils;

class UrlUtils
{
    /**
     * Função para remover acentos de uma string
     */
    static function encodeUrlParameter($parameterValue, $keepSpaces = false)
    {
        $slug = '-';
        $parameterValue = strtolower($parameterValue);

        // Código ASCII das vogais
        $ascii['a'] = range(224, 230);
        $ascii['e'] = range(232, 235);
        $ascii['i'] = range(236, 239);
        $ascii['o'] = array_merge(range(242, 246), array(240, 248));
        $ascii['u'] = range(249, 252);
        $ascii['b'] = array(223);
        $ascii['c'] = array(231);
        $ascii['d'] = array(208);
        $ascii['n'] = array(241);
        $ascii['y'] = array(253, 255);

        foreach ($ascii as $key => $item) {
            foreach ($item AS $codigo) {
                $parameterValue = str_replace(utf8_encode(chr($codigo)), $key, $parameterValue);
            }
        }

        if ($keepSpaces) {
            // Troca tudo que não for letra, space ou número por um caractere ($slug)
            $parameterValue = preg_replace('/[^a-z0-9 ]/i', $slug, $parameterValue);
        } else {
            // Troca tudo que não for letra ou número por um caractere ($slug)
            $parameterValue = preg_replace('/[^a-z0-9]/i', $slug, $parameterValue);
        }

        // Tira os caracteres ($slug) repetidos
        $parameterValue = preg_replace('/' . $slug . '{2,}/i', $slug, $parameterValue);
        //Remove os espaços em branco das pontas
        $parameterValue = trim($parameterValue, $slug);

        return urlencode($parameterValue);
    }

    /**
     * Transforma um parâmetro recebido na url em um texto a ser apresentado.
     */
    static function decodeUrlParameter($parameterValue)
    {
        return ucwords(str_replace("-", " ", $parameterValue));
    }

    public static function shortfyUrl($longUrl)
    {
        $postData = array('longUrl' => $longUrl, 'key' => config('app.googleApiKey'));
        $jsonData = json_encode($postData);
        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($curlObj, CURLOPT_POST, 1);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
        $response = curl_exec($curlObj);
        $json = json_decode($response);
        curl_close($curlObj);
        return $json->id;
    }

}