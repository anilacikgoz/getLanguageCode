# getLanguageCode

- This project provides information about the official language and other countries that use that language for a selected country.

- Used rest service(https://restcountries.eu/rest/v2) by Guzzle HTTP client.

- It has an extensible object structure and using easily.


```php
    $languageService = new App\Src\LanguageService();
    $countryName = 'Germany';
    $country = $languageService->getCountryDetail($countryName);
    print $languageService->formatLanguageCode($country); 
```


```php
interface LanguageServiceInterface
{
    
    /**
     * Returns country object from json array of rest service
     * @param string $countryName
     * @return \App\Src\Country 
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
     * @param \App\Src\Country $country
     */
    public function formatLanguageCode(\App\Src\Country $country);
    
    /**
     * Returns formatted string of compared two countries about if they are using same language or not. 
     * @param \App\Src\Country $country
     *
     */
    public function formatComparedCountries(\App\Src\Country $country);
    
}
```
