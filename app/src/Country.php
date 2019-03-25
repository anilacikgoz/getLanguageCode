<?php

namespace App\Src;

/*
 * This object created for basic country data. 
 * A country might be has more than one official language. 
 * $officalLanguages has include all of the offical language of this country.
 * $countryNames has include country name and alt spellings.
 */

class Country {

    protected $countryCode;
    protected $officalLanguages;
    protected $countryNames;

    function __construct() {
        
    }

    public function setCountryCode($countryCode) {
        $this->countryCode = $countryCode;
    }

    public function setOfficialLanguages(Language $language) {
        $this->officalLanguages[] = $language;
        return $this;
    }

    public function setCountryNames($countryName) {
        $this->countryNames[] = $countryName;
        return $this;
    }

    public function getCounrtyCode() {
        return $this->countryCode;
    }

    public function getOfficialLanguages() {
        return $this->officalLanguages;
    }

    public function getCountryName() {
        return $this->countryNames;
    }

}
