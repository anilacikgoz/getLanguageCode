<?php

namespace App\Src\YasLife;

interface LanguageServiceInterface
{

    public function getOtherCountries($languageCode);
    public function getLanguageCode($languageCode);
    public function compareCountry($langFirst, $langSec);
    public function formatLanguageCode(\App\Src\YasLife\Country $country);
    public function formatComparedCountries(\App\Src\YasLife\Country $country);
}

