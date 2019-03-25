<?php 
namespace App\Src\YasLife;
use \App\Config ;
/**
 ** This object includes basic language information and which countries are using this language. 
 */
class Language{

    
        protected $languageCodeIso6391;
        protected $languageCodeIso6392;
        protected $name;
        protected $nativeName;
        protected $countries;
                
        function __construct()
	{
		
	}
        public function setLanguageCodeIso6391( $languageCode)
        {
            $this->languageCodeIso6391 = $languageCode;  
         
        }
        public function setlanguageCodeIso6392( $languageCode)
        {
            $this->languageCodeIso6392 = $languageCode;  
         
        }
        public function setName( $name)
        {
            $this->name = $name;  
         
        }
        public function setNativeName( $name)
        {
            $this->nativeName = $name;  
         
        }

        public function  setCountry(Country $country)
        {
            $this->countries[] = $country;
            return $this;
            
        }
        public function getLanguageCodeIso6391()
        {
            return $this->languageCodeIso6391;
            
        }
        public function getLanguageCodeIso6392()
        {
            return $this->languageCodeIso6392;
            
        }
        
        public function getName()
        {
            return $this->name;
        }    
        
        public function getNativeName()
        {
            return $this->nativeName;
        }    
        
        public function getCountries()
        {
            return $this->countries;
        }    	
}
