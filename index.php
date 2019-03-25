<?php

require './app/bootstrap.php';
use App\Src\YasLife\LanguageService;
use App\Src\YasLife\Country;
global $argc, $argv;
$languageService = new App\Src\YasLife\LanguageService();
if ($argc == 2) {
    
    $countryName = $argv[1];
    $country = $languageService->getCountryDetail($countryName);
    print $languageService->formatLanguageCode($country);
    
} else if ($argc == 3) {
    
   $comparedCountries = $languageService->compareCountry($argv[1], $argv[2]);
   print $languageService->formatComparedCountries($comparedCountries);
} else
{
    return new Exception("Parameters count not be greater than two.");
}