<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Src\YasLife;

/**
 * Description of Country
 *
 * @author anila
 */
class Country {
    //put your code here
    
    protected  $countryCode;
    protected  $officalLanguages;
    protected  $countryNames; 
    
    
    
    function __construct()
    {

    }
    public function setCountryCode( $countryCode)
    {
        $this->countryCode = $countryCode;
    }
    
    public function setOfficialLanguages (Language $language)
    {
        $this->officalLanguages[] = $language;
        return $this;   
    }
    
    public function setCountryNames ($countryName)
    {
        $this->countryNames[] = $countryName;
        return $this;
    }
    
    public function getCounrtyCode()
    {
        return $this->countryCode;
    } 
    
    public function getOfficialLanguages()
    {
        return $this->officalLanguages;
    }
    public function getCountryName()
    {
        return $this->countryNames;
    }
}
