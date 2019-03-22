<?php

require './app/bootstrap.php';

use App\Src\YasLife\LanguageService;
use App\Src\YasLife\Country;

global $argc, $argv;

$languageService = new App\Src\YasLife\LanguageService();

ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');



$countryTemp = new Country();
$languageTemp = new App\Src\YasLife\Language();
$languageTemp->setLanguageCodeIso6391('tr');
$languageTemp->setName('Turkish');
$languageTemp->setNativeName("Türkçe");
$languageTemp->setlanguageCodeIso6392("trk");
$countryTemp->setCountryCode("TR");
$countryTemp->setCountryNames("Türkiye");
$countryTemp->setOfficialLanguages($languageTemp);
$languageTemp = new App\Src\YasLife\Language();
$languageTemp->setLanguageCodeIso6391("kr");
$languageTemp->setName("Kurdish");
$languageTemp->setNativeName("Kürtçe");
$languageTemp->setlanguageCodeIso6392("krd");
$countryTemp->setOfficialLanguages($languageTemp);


if (count($argv) == 2) {
    $a = $argv[1];
    print $a;


    //$country = $languageService->getLanguageCode($a);
    $country = $countryTemp;
    if (!empty($country)) {
        var_dump($country);
        die();
        return $languageService->formatLanguageCode($country);
    }
} else if (count($argv) == 3) {
    
} else
    return null;