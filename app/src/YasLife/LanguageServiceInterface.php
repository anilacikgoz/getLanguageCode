<?php

namespace App\Src\YasLife;

interface LanguageServiceInterface
{
    /**
     * Service interface for quering country and language operations
     */
    public function getOtherCountries($languageCode);
    public function getLanguageCode($languageCode);
    public function compareCountry($firstCountry, $secondCountry);
    public function formatLanguageCode(\App\Src\YasLife\Country $country);
    public function formatComparedCountries(\App\Src\YasLife\Country $country);
}

