<?php

require './app/bootstrap.php';

use App\Src\YasLife\LanguageService;
use App\Src\YasLife\Country;

global $argc, $argv;

$languageService = new App\Src\YasLife\LanguageService();

ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');


/*$countryTemp = new Country();
$languageTemp = new App\Src\YasLife\Language();
$languageTemp->setLanguageCodeIso6391('tr');
$languageTemp->setName('Turkish');
$languageTemp->setNativeName("Turkce");
$languageTemp->setlanguageCodeIso6392("trk");
$countryTemp->setCountryCode("TR");
$countryTemp->setCountryNames("Turkiye");
$countryTemp->setOfficialLanguages($languageTemp);
$languageTemp = new App\Src\YasLife\Language();
$languageTemp->setLanguageCodeIso6391("kr");
$languageTemp->setName("Kurdish");
$languageTemp->setNativeName("Kurdce");
$languageTemp->setlanguageCodeIso6392("krd");
$countryTemp->setOfficialLanguages($languageTemp);*/


if (count($argv) == 2) {
    $countryName = $argv[1];
    
    $country = $languageService->getLanguageCode($countryName);
    
    if (!empty($country)) {
        print $languageService->formatLanguageCode($country);
    }
} else if (count($argv) == 3) {
    
   $comparedCountries = $languageService->compareCountry($argv[1], $argv[2]);
   print $languageService->formatComparedCountries($comparedCountries);
   
   
   
    
} else
    return null;