<?php
namespace App\Src\YasLife;
use Language;
use GuzzleHttp\Client;
use App\Config\Parameters;

final class LanguageService implements \App\Src\YasLife\LanguageServiceInterface
{
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
.    */
    private $parameters;
   
    /*
     * @var string Default rest service url.
     */
    private $restUrl;


    public function __construct() {
        $this->parameters = new Parameters();
        $this->restUrl = $this->parameters->getRestUrl();
    }

    /*
     * @var $countryName
     */
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
    public function compareCountry( $countryFirst,  $countrySecond) {
        $comparedCountries = array();
        $comparedCountries['first'] = $countryFirst;
        $comparedCountries['second'] = $countrySecond;
        $comparedCountries['status']  = false;
        $countryFirst = $this->getLanguageCode($countryFirst);
        $countrySecond = $this->getLanguageCode($countrySecond);
        foreach($countryFirst->getOfficialLanguages() as $languageFirst)
        {
            foreach ($countrySecond->getOfficialLanguages() as $languageSec )
            {
             
                if ($languageFirst->getLanguageCodeIso6391() == $languageSec->getLanguageCodeIso6391())
                {
                    $comparedCountries['status'] = true;
                    return $comparedCountries;
                }
            }
        }
        
        return $comparedCountries;
    }
    private function getSameLanguageCountries( $languageCode,  $countryName)
    {
        $this->restType = $this->parameters->getRestType('byLang');
        $this->restClient = new Client(['base_uri' => $this->restUrl.'/'.$this->restType.'/'.urlencode($languageCode)]);
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
        $this->restClient = new Client(['base_uri' => $this->restUrl.'/'.$this->restType.'/'.urlencode($countryName).'?fullText=true']);
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
    
    public function formatComparedCountries($comparedCountries) {
     
        if (is_array($comparedCountries))
        {
            if(!empty($comparedCountries))
            {
                if ($comparedCountries['status'] === true)
                {
                   return sprintf("%s and %s speak the same language",$comparedCountries['first'],$comparedCountries['second']);
            
                }
                else return sprintf("%s and %s do not speak the same language",$comparedCountries['first'],$comparedCountries['second']);
            }
        }
        else 
        {
           return new \Exception('Parameter format not valid');
        }
    }
    
    public function formatLanguageCode(Country $country) {
        $formatSingle=null;
        $formatPlural =null;
        if(!empty($country))
        {
            if(count($country->getOfficialLanguages()) ==1)
            {
                $formatSingle = sprintf("Country language code:%s \n"
                        . "%s speaks same language with thease countries:"
                        . "%s",$country->getOfficialLanguages()[0]->getLanguageCodeIso6391(),$country->getCountryName()[0],implode(',',array_map(function($entry){return $entry->getCountryName()[0];},$country->getOfficialLanguages()[0]->getCountries())));
            }
            else if(count($country->getOfficialLanguages()) >1)
            {                
                $formatPlural =sprintf("Country language codes:%s \n"
                        . "%s speaks same language with these countries:"
                        . "%s", implode(',',array_map(function($entry){return $entry->getLanguageCodeIso6391();},$country->getOfficialLanguages())),$country->getCountryName()[0], implode(',',array_map(function($entry){
                                    $lOtherCountries = array();
                                    foreach($entry->getCountries() as $lCountry)
                                        {
                                         $lOtherCountries[] = $lCountry->getCountryName()[0];   
                                        }   
                                      return $lOtherCountries[0];
                                    ;},$country->getOfficialLanguages())));           
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




