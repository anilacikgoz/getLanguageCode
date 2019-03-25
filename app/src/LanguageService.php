<?php

namespace App\Src;

use App\Src\Language;
use App\Src\Country;
use GuzzleHttp\Client;
use App\Config\Parameters;

final class LanguageService implements \App\Src\LanguageServiceInterface {

    /**
     * @var string rest service query type.
     */
    private $restType;
    /*
     * @var GuzzleHttp\Client object for rest rest operation. 
     */
    private $restClient;
    /*
     * @var App\Config\Parameters object for application parameters.
      . */
    private $parameters;

    /*
     * @var string Default rest service url.
     */
    private $baseRestUrl;

    public function __construct() {
        $this->parameters = new Parameters();
        $this->baseRestUrl = $this->parameters->getBaseRestUrl();
    }

    /**
     * Returns countries name which are using the same language.
     * @param string  $languageCode
     * @param string $countryName
     * @return array  $countries
     * 
     */
    private function getSameLanguageCountries($languageCode, $countryName): array {
        $this->restType = $this->parameters->getRestType('byLang');
        $this->restClient = new Client(['base_uri' => $this->baseRestUrl . '/' . $this->restType . '/' . urlencode($languageCode)]);
        $result = $this->restClient->request('get');
        $countries = array();
        if (!empty($result->getBody())) {
            $retObject = json_decode($result->getBody()->getContents());

            if (is_array($retObject) && !empty($retObject)) {
                foreach ($retObject as $country) {

                    if ($country->{'name'} != $countryName && empty(array_filter($country->{'altSpellings'}, function($v) use($countryName) {
                                        return $v == $countryName;
                                    }))) {
                        $countries[] = $country;
                    }
                }
            }
        }

        return $countries;
    }

    /**
     * Returns decoded json array from rest service. 
     * @param string $countryName 
     * @return array $retObject  
     * @throws \GuzzleHttp\Exception\ClientException
     */
    private function getCountryRawData($countryName)    {
        $result = null;
        $this->restType = $this->parameters->getRestType('byName');
        $this->restClient = new Client(['base_uri' => $this->baseRestUrl . '/' . $this->restType . '/' . urlencode($countryName) . '?fullText=true']);
        try {
            $result = $this->restClient->request('get');
            if (isset($result) && !empty($result->getBody())) {
                $retObject = json_decode($result->getBody()->getContents());
                if (is_array($retObject) && !empty($retObject)) {
                    return $retObject[0];
                } else
                    return null;
            } else
                return null;
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            throw new \Exception(sprintf('There is no data returned from this country. Country name might be misspelled. Country name: %s', $countryName));
        }
    }

    public function getCountryDetail($countryName): Country {

        $countryRawData = $this->getCountryRawData($countryName);
        $countryLanguage = null;
        $country = null;
        $language = null;
        if (!empty($countryRawData)) {
            $language = new Language();
            $country = new Country();
            $country->setCountryNames($countryRawData->{'name'});
            foreach ($countryRawData->{'altSpellings'} as $name) {
                $country->setCountryNames($name);
            }

            foreach ($countryRawData->{'languages'} as $language) {
                $countryLanguage = new Language();
                $countryLanguage->setLanguageCodeIso6391($language->{'iso639_1'});
                $countryLanguage->setLanguageCodeIso6392($language->{'iso639_2'});
                $countryLanguage->setName($language->{'name'});
                $countryLanguage->setNativeName($language->{'nativeName'});
                $country->setOfficialLanguages($countryLanguage);
            }

            $officalLanguages = $country->getOfficialLanguages();
            for ($i = 0; $i < count($officalLanguages); $i++) {

                $otherCountries = $this->getSameLanguageCountries($officalLanguages[$i]->getLanguageCodeIso6391(), $country->getCountryName()[0]);

                foreach ($otherCountries as $restCountry) {
                    $tempCountry = new Country();
                    $tempCountry->setCountryCode($restCountry->{'alpha2Code'});
                    $tempCountry->setCountryNames($restCountry->{'name'});
                    foreach ($restCountry->{'altSpellings'} as $name) {
                        $tempCountry->setCountryNames($name);
                    }
                    $country->getOfficialLanguages()[$i]->setCountry($tempCountry);
                }
            }
        }
        return $country;
    }

    public function compareCountry($countryFirst, $countrySecond) {
        $comparedCountries = array();
        $comparedCountries['first'] = $countryFirst;
        $comparedCountries['second'] = $countrySecond;
        $comparedCountries['status'] = false;
        $countryFirst = $this->getCountryDetail($countryFirst);
        $countrySecond = $this->getCountryDetail($countrySecond);
        foreach ($countryFirst->getOfficialLanguages() as $languageFirst) {
            foreach ($countrySecond->getOfficialLanguages() as $languageSec) {

                if ($languageFirst->getLanguageCodeIso6391() == $languageSec->getLanguageCodeIso6391()) {
                    $comparedCountries['status'] = true;
                    return $comparedCountries;
                }
            }
        }

        return $comparedCountries;
    }

    public function formatComparedCountries($comparedCountries): string {

        if (is_array($comparedCountries)) {
            if (!empty($comparedCountries)) {
                if ($comparedCountries['status'] === true) {
                    return sprintf("%s and %s speak the same language", $comparedCountries['first'], $comparedCountries['second']);
                } else
                    return sprintf("%s and %s do not speak the same language", $comparedCountries['first'], $comparedCountries['second']);
            }
        }
        else {
            throw new \Exception('Parameter format not valid');
        }
    }

    public function formatLanguageCode(Country $country): string {
        $formatSingle = null;
        $formatPlural = null;
        if (!empty($country)) {
            if (count($country->getOfficialLanguages()) == 1) {
                $formatSingle = sprintf("Country language code:%s \n"
                        . "%s speaks same language with these countries:"
                        . "%s", $country->getOfficialLanguages()[0]->getLanguageCodeIso6391(), $country->getCountryName()[0], implode(',', array_map(function($entry) {
                                    return $entry->getCountryName()[0];
                                }, $country->getOfficialLanguages()[0]->getCountries())));
            } else if (count($country->getOfficialLanguages()) > 1) {
                $formatPlural = sprintf("Country language codes:%s \n"
                        . "%s speaks same language with these countries:"
                        . "%s", implode(',', array_map(function($entry) {
                                    return $entry->getLanguageCodeIso6391();
                                }, $country->getOfficialLanguages())), $country->getCountryName()[0], implode(',', array_map(function($entry) {
                                    $lOtherCountries = array();
                                    foreach ($entry->getCountries() as $lCountry) {
                                        $lOtherCountries[] = $lCountry->getCountryName()[0];
                                    }
                                    return $lOtherCountries[0];
                                    ;
                                }, $country->getOfficialLanguages())));
            }
        }
        if (!is_null($formatSingle)) {
            return $formatSingle;
        } else if (!is_null($formatPlural)) {
            return $formatPlural;
        } else
            return null;
    }

}
