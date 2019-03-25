<?php

require './app/bootstrap.php';

use App\Src\YasLife\LanguageService;
use App\Src\YasLife\Country;

global $argc, $argv;
$languageService = new App\Src\YasLife\LanguageService();
if (count($argv) == 2) {
    $countryName = $argv[1];
    $country = $languageService->getCountryDetail($countryName);
    
    if (!empty($country)) {
        print $languageService->formatLanguageCode($country);
    }
} else if (count($argv) == 3) {
    
   $comparedCountries = $languageService->compareCountry($argv[1], $argv[2]);
   print $languageService->formatComparedCountries($comparedCountries);
   
   
   
    
} else
    return null;