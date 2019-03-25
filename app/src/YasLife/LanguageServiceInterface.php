<?php

namespace App\Src\YasLife;

    /**
     * Service interface for main functions of quering operations.
     */
 
interface LanguageServiceInterface
{
    
    /**
     * Returns country object from json array of rest service
     * @param string $countryName
     * @return \App\Src\YasLife\Country 
     *  
     */
    public function getCountryDetail($countryName);
  
    /**
     * Returns $comparedCountries array of compared two countries about if they are using same language or not
     * @param string $firstCountry
     * @param string $secondCountry
     * * @return array $comparedCountries
     *  -(string)$comparedCountries['first'] ;
     *  -(string)$comparedCountries['second']
     *  -(bool)$comparedCountries['status']
     *  If compared countries are using the same language, $comparedCountries['status'] variable set true.  
     */
     
    public function compareCountry($firstCountry, $secondCountry);
    
    /**
     * Returns formatted string for language code of a country 
     * and its related countries which using the same language.
     * @param \App\Src\YasLife\Country $country
     */
    public function formatLanguageCode(\App\Src\YasLife\Country $country);
    
    /*
     * Returns formatted string of compared two countries about if they are using same language or not. 
     * @param \App\Src\YasLife\Country $country
     *
     */
    public function formatComparedCountries(\App\Src\YasLife\Country $country);
    
}

