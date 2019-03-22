<?php
namespace App\Src\YasLife;
use Language;
use GuzzleHttp\Client;
use App\Config\Parameters;

class LanguageService implements \App\Src\YasLife\LanguageServiceInterface
{
    private $restType;
    private $restClient;
    private $parameters;
    private $restUrl;


    public function __construct() {
        $this->parameters = new Parameters();
        $this->restUrl = $this->parameters->getRestUrl();
    }

    public function compareCountry( $langFirst,  $langSec) {
        $matchedLanguages = array();
        $countryFirst = $this->getLanguageCode($langFirst);
        $countrySecond = $this->getLanguageCode($langSec);
        foreach($countryFirst->getOfficialLanguages() as $languageFirst)
        {
            foreach ($countrySecond->getOfficialLanguages() as $languageSec )
            {
                if ($languageFirst->getLanguageCodeIso6391() == $languageSec->getLanguageCodeIso6391())
                {
                    $languageCodes = $languageFirst->getLanguageCodeIso6391();
                }
            }
        }
        
        return $matchedLanguages;
    }
    public function getLanguageCode($countryName)    {
    
        $countryDetail = $this->getCountryDetail($countryName);
        $countryLanguage = null;
        $country = null;
        $language = null;
        if(!empty($countryDetail))
        {
            $language  = new \App\Src\YasLife\Language();
            $country = new \App\Src\YasLife\Country();
            $country->setCountryNames($countryDetail->{'name'});
            foreach ($countryDetail->{'altSpellings'} as $name)
            {
                $country->setCountryNames($name);
            }
            
            foreach ($countryDetail->{'languages'} as $language)
            {
                $countryLanguage = new \App\Src\YasLife\Language();
                $countryLanguage->setLanguageCodeIso6391($language->{'iso639_1'});
                $countryLanguage->setLanguageCodeIso6392($language->{'iso639_2'});
                $countryLanguage->setName($language->{'name'});
                $countryLanguage->setNativeName($language->{'nativeName'});
                $country->setOfficialLanguages($countryLanguage);
            }

            $officalLanguages = $country->getOfficialLanguages(); 
            for ( $i=0;$i<count($officalLanguages);$i++)
            {
               $otherCountries = $this->getSameLanguageCountries($officalLanguages[$i]->getLanguageCodeIso6391(),$country->getCountryName()[0]);
               
                foreach($otherCountries as $restCountry)
                {
                    $tempCountry = new \App\Src\YasLife\Country();
                    $tempCountry->setCountryCode($restCountry->{'alpha2Code'});
                    $tempCountry->setCountryNames($restCountry->{'name'});
                    foreach ($restCountry->{'altSpellings'} as $name)
                    {
                        $tempCountry->setCountryNames($name);
                    }  
                    $country->getOfficialLanguages()[$i]->setCountry($tempCountry);    
                }
            }
        }
        return $country;
    }
    private function getSameLanguageCountries( $languageCode,  $countryName)
    {
        $this->restType = $this->parameters->getRestType('byLang');
        $this->restClient = new Client(['base_uri' => $this->restUrl.'/'.$this->restType.'/'.$languageCode]);
        $result = $this->restClient->request('get');
        $countries = array();
        
        if (!empty($result->getBody()))
        {
           $retObject = json_decode($result->getBody()->getContents());
           
           if (is_array($retObject)&& !empty($retObject))
           {
             foreach ($retObject as $country)
             {
                 
               if ($country->{'name'}!= $countryName && empty(array_filter($country->{'altSpellings'}, function($v) use($countryName)
                            {
                              return $v == $countryName;
                            })))
               { 
                 $countries[] = $country;
               }
             }
           }
        }
        return $countries;
    }
    private function getCountryDetail( $countryName)
    {
        $this->restType = $this->parameters->getRestType('byName');
        $this->restClient = new Client(['base_uri' => $this->restUrl.'/'.$this->restType.'/'.$countryName.'?fullText=true']);
        $result = $this->restClient->request('get');
        
        if (!empty($result->getBody()))
        {
           $retObject = json_decode($result->getBody()->getContents());
           if (is_array($retObject)&& !empty($retObject))
           {
               return $retObject[0];
           }
           else return null;
        }
     }

    public function getOtherCountries( $languageCode) {
        ;
    }
    
    public function formatComparedCountries(Country $country) {
        
    }
    
    public function formatLanguageCode(Country $country) {
        $formatSingle=null;
        $formatPlural =null;
        if(count($country)>0)
        {
            if(count($country->getOfficialLanguages()) ==1)
            {
                $formatSingle = sprintf("Country language code:%s",$country->getOfficialLanguages()[0]->getLanguageCodeIso6391());
            }
            else if(count($country->getOfficialLanguages()) >1)
            {
                $formatPlural =sprintf("Country language codes:%s", implode(',',array_map(function($entry){return $entry->getLanguageCodeIso6391();},$country->getOfficialLanguages())));           
            }
        }
        if(!is_null($formatSingle))
        {
            return $formatSingle;
        }
        else if(!is_null($formatPlural))
        {
            return $formatPlural;
        }
        else return null;
    }
    
}




