<?php

namespace App\Tests;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use App\Src\LanguageService;
use App\Src\Country;

/**
 * Test processing for \App\Src\LanguageService class
 */
final class TestLanguageService extends TestCase {

     function testGetCountryDetail() {
        
        $client = \Mockery::mock('overload:\GuzzleHttp\Client');
        $client->shouldReceive('request->getBody->getContents')->andReturn('[{"name":"Spain","topLevelDomain":[".es"],"alpha2Code":"ES","alpha3Code":"ESP","callingCodes":["34"],"capital":"Madrid","altSpellings":["ES","Kingdom of Spain","Reino de España"],"region":"Europe","subregion":"Southern Europe","population":46438422,"latlng":[40.0,-4.0],"demonym":"Spanish","area":505992.0,"gini":34.7,"timezones":["UTC","UTC+01:00"],"borders":["AND","FRA","GIB","PRT","MAR"],"nativeName":"España","numericCode":"724","currencies":[{"code":"EUR","name":"Euro","symbol":"€"}],"languages":[{"iso639_1":"es","iso639_2":"spa","name":"Spanish","nativeName":"Español"}],"translations":{"de":"Spanien","es":"España","fr":"Espagne","ja":"スペイン","it":"Spagna","br":"Espanha","pt":"Espanha","nl":"Spanje","hr":"Španjolska","fa":"اسپانیا"},"flag":"https://restcountries.eu/data/esp.svg","regionalBlocs":[{"acronym":"EU","name":"European Union","otherAcronyms":[],"otherNames":[]}],"cioc":"ESP"}]');
        $languageService = new LanguageService();
        $country = $languageService->getCountryDetail('Spain');
        $this->assertInstanceOf(Country::class, $country);
        $this->tearDown();
        $client = null;
    }
    final function testCompareCountryResultStatus() {
        $client = \Mockery::mock('overload:\GuzzleHttp\Client');
        $client->shouldReceive('request->getBody->getContents')->times()->andReturn('[{"name":"Spain","topLevelDomain":[".es"],"alpha2Code":"ES","alpha3Code":"ESP","callingCodes":["34"],"capital":"Madrid","altSpellings":["ES","Kingdom of Spain","Reino de España"],"region":"Europe","subregion":"Southern Europe","population":46438422,"latlng":[40.0,-4.0],"demonym":"Spanish","area":505992.0,"gini":34.7,"timezones":["UTC","UTC+01:00"],"borders":["AND","FRA","GIB","PRT","MAR"],"nativeName":"España","numericCode":"724","currencies":[{"code":"EUR","name":"Euro","symbol":"€"}],"languages":[{"iso639_1":"es","iso639_2":"spa","name":"Spanish","nativeName":"Español"}],"translations":{"de":"Spanien","es":"España","fr":"Espagne","ja":"スペイン","it":"Spagna","br":"Espanha","pt":"Espanha","nl":"Spanje","hr":"Španjolska","fa":"اسپانیا"},"flag":"https://restcountries.eu/data/esp.svg","regionalBlocs":[{"acronym":"EU","name":"European Union","otherAcronyms":[],"otherNames":[]}],"cioc":"ESP"}]')
                                                                                    ->times()->andReturn('[{"name":"Honduras","topLevelDomain":[".hn"],"alpha2Code":"HN","alpha3Code":"HND","callingCodes":["504"],"capital":"Tegucigalpa","altSpellings":["HN","Republic of Honduras","República de Honduras"],"region":"Americas","subregion":"Central America","population":8576532,"latlng":[15.0,-86.5],"demonym":"Honduran","area":112492.0,"gini":57.0,"timezones":["UTC-06:00"],"borders":["GTM","SLV","NIC"],"nativeName":"Honduras","numericCode":"340","currencies":[{"code":"HNL","name":"Honduran lempira","symbol":"L"}],"languages":[{"iso639_1":"es","iso639_2":"spa","name":"Spanish","nativeName":"Español"}],"translations":{"de":"Honduras","es":"Honduras","fr":"Honduras","ja":"ホンジュラス","it":"Honduras","br":"Honduras","pt":"Honduras","nl":"Honduras","hr":"Honduras","fa":"هندوراس"},"flag":"https://restcountries.eu/data/hnd.svg","regionalBlocs":[{"acronym":"CAIS","name":"Central American Integration System","otherAcronyms":["SICA"],"otherNames":["Sistema de la Integración Centroamericana,"]}],"cioc":"HON"}]');
        $languageService = new LanguageService();
        $compareResults = $languageService->compareCountry('Spain', 'Honduras');
        $this->assertTrue($compareResults['status']);
        $this->tearDown();
        $client = null;
    }
    final function testCompareCountryResultsType() {
        $client = \Mockery::mock('overload:\GuzzleHttp\Client');
        $client->shouldReceive('request->getBody->getContents')->times()->andReturn('[{"name":"Spain","topLevelDomain":[".es"],"alpha2Code":"ES","alpha3Code":"ESP","callingCodes":["34"],"capital":"Madrid","altSpellings":["ES","Kingdom of Spain","Reino de España"],"region":"Europe","subregion":"Southern Europe","population":46438422,"latlng":[40.0,-4.0],"demonym":"Spanish","area":505992.0,"gini":34.7,"timezones":["UTC","UTC+01:00"],"borders":["AND","FRA","GIB","PRT","MAR"],"nativeName":"España","numericCode":"724","currencies":[{"code":"EUR","name":"Euro","symbol":"€"}],"languages":[{"iso639_1":"es","iso639_2":"spa","name":"Spanish","nativeName":"Español"}],"translations":{"de":"Spanien","es":"España","fr":"Espagne","ja":"スペイン","it":"Spagna","br":"Espanha","pt":"Espanha","nl":"Spanje","hr":"Španjolska","fa":"اسپانیا"},"flag":"https://restcountries.eu/data/esp.svg","regionalBlocs":[{"acronym":"EU","name":"European Union","otherAcronyms":[],"otherNames":[]}],"cioc":"ESP"}]')
                                                                                    ->times()->andReturn('[{"name":"Honduras","topLevelDomain":[".hn"],"alpha2Code":"HN","alpha3Code":"HND","callingCodes":["504"],"capital":"Tegucigalpa","altSpellings":["HN","Republic of Honduras","República de Honduras"],"region":"Americas","subregion":"Central America","population":8576532,"latlng":[15.0,-86.5],"demonym":"Honduran","area":112492.0,"gini":57.0,"timezones":["UTC-06:00"],"borders":["GTM","SLV","NIC"],"nativeName":"Honduras","numericCode":"340","currencies":[{"code":"HNL","name":"Honduran lempira","symbol":"L"}],"languages":[{"iso639_1":"es","iso639_2":"spa","name":"Spanish","nativeName":"Español"}],"translations":{"de":"Honduras","es":"Honduras","fr":"Honduras","ja":"ホンジュラス","it":"Honduras","br":"Honduras","pt":"Honduras","nl":"Honduras","hr":"Honduras","fa":"هندوراس"},"flag":"https://restcountries.eu/data/hnd.svg","regionalBlocs":[{"acronym":"CAIS","name":"Central American Integration System","otherAcronyms":["SICA"],"otherNames":["Sistema de la Integración Centroamericana,"]}],"cioc":"HON"}]');
        $languageService = new LanguageService();
        $compareResults = $languageService->compareCountry('Spain', 'Honduras');
        $this->assertInternalType('array', $compareResults);
        $this->tearDown();
    }
    
    final function testCountryOfficalLanguages()
    {
        
        $client = \Mockery::mock('overload:\GuzzleHttp\Client');
        $client->shouldReceive('request->getBody->getContents')->andReturn('[{"name":"Spain","topLevelDomain":[".es"],"alpha2Code":"ES","alpha3Code":"ESP","callingCodes":["34"],"capital":"Madrid","altSpellings":["ES","Kingdom of Spain","Reino de España"],"region":"Europe","subregion":"Southern Europe","population":46438422,"latlng":[40.0,-4.0],"demonym":"Spanish","area":505992.0,"gini":34.7,"timezones":["UTC","UTC+01:00"],"borders":["AND","FRA","GIB","PRT","MAR"],"nativeName":"España","numericCode":"724","currencies":[{"code":"EUR","name":"Euro","symbol":"€"}],"languages":[{"iso639_1":"es","iso639_2":"spa","name":"Spanish","nativeName":"Español"}],"translations":{"de":"Spanien","es":"España","fr":"Espagne","ja":"スペイン","it":"Spagna","br":"Espanha","pt":"Espanha","nl":"Spanje","hr":"Španjolska","fa":"اسپانیا"},"flag":"https://restcountries.eu/data/esp.svg","regionalBlocs":[{"acronym":"EU","name":"European Union","otherAcronyms":[],"otherNames":[]}],"cioc":"ESP"}]');
        $languageService = new LanguageService();
        $compareResults = null;
        $langCount = count($languageService->getCountryDetail('Spain')->getOfficialLanguages());
        $this->assertGreaterThanOrEqual(1,$langCount);
        $this->tearDown();
        $client = null;
    }

    public function tearDown() {
        \Mockery::close();
    }
}
