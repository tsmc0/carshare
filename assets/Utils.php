<?php

/*
 * Небольшой парсер
 * */

function findAutoImages($mark, $model, $coupleType)
{


    $url = "https://api.auto-data.net/image-database";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $res = curl_exec($ch);

    $dom = new DomDocument();
    @$dom->loadHTML($res);

    $elems = $dom->getElementsByTagName('a');

    foreach ($elems as $elem) {
        if (strpos($elem->textContent, "{$mark} {$model}") !== false) {

            if (strpos($elem->textContent, $coupleType) !== false) {
                //echo $elem->getAttribute('href');
                //extractImages($elem->getAttribute('href'));
            }

            //echo $elem->getAttribute('href');
        } else {

        }
    }

    curl_close($ch);


}

function extractModelsInter($full_uri, $brand, $callback) {
    httpClient($full_uri, function ($res) use ($brand, $callback) {
        $dom = new DomDocument();
        @$dom->loadHTML($res);

        $elems = $dom->getElementsByTagName('a');

        $full_list = [];

        foreach ($elems as $elem) {
            if ($elem->getAttribute('class') == "modeli") {
                $full_list[] = ["label" => trim($elem->textContent), 'img' => $elem->childNodes[1]->getAttribute('src')];
            }
        }

        $callback($full_list);
    });
}

function extractModels($brand, $callback)
{
    httpClient('https://www.auto-data.net/en/allbrands', function ($res) use ($brand, $callback) {
        $dom = new DomDocument();
        @$dom->loadHTML($res);

        $elems = $dom->getElementsByTagName('a');

        foreach ($elems as $elem) {
            if ($elem->getAttribute('class') == "marki_blok") {
                if ($elem->childNodes[1]->textContent === $brand) {
                    $full_uri = "https://www.auto-data.net" . $elem->getAttribute('href');

                    extractModelsInter($full_uri, $brand, $callback);
                }
            }
        }
    });
}

function extractImages($url = 'https://www.auto-data.net/en/audi-a6-4a-c4-generation-1119')
{
    $imgBase = 'https://www.auto-data.net';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $res = curl_exec($ch);

    $dom = new DomDocument();
    @$dom->loadHTML($res);

    $elems = $dom->getElementsByTagName('img');

    foreach ($elems as $elem) {
        if (strpos($elem->getAttribute('src'), "/images") !== false) {
            $replace = str_replace('_thumb', '', $elem->getAttribute('src'));

            echo "{$imgBase}{$replace}";
        }
    }

    curl_close($ch);
}

function extractBrands($url = 'https://www.auto-data.net/en/allbrands')
{
    httpClient($url, function ($res) {
        $dom = new DomDocument();
        @$dom->loadHTML($res);

        $elems = $dom->getElementsByTagName('a');

        foreach ($elems as $elem) {
            if ($elem->getAttribute('class') == "marki_blok") {
                $href = $elem->childNodes[0]->getAttribute('src');

                $ab = new \app\models\AutoBrand();
                $ab->title = $elem->textContent;
                $ab->save();
            }
        }
    });
}

function httpClient($url, $callback)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0');

    $res = curl_exec($ch);

    curl_close($ch);

    $callback($res);


}
