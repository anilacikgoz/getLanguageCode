<?php
namespace App\Test;
use SebastianBergmannann\CodeCoverage;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use App\Src\LanguageService;
use App\Src\Country;
use App\Src\Language;
/**
 * Description of TestLanguageService
 * Test processing for \App\Src\LanguageService class
 * @author anila
 */
final class TestLanguageService extends TestCase {
    
    final function testGetLanguageCode()
    {
        $languageService = new LanguageService();
        $country =$languageService->getCountryDetail('Spain');        
        $this->assertInstanceOf(Country::class,$country);
    }
    
    final function testCompareCountry()
    {
        $languageService = new LanguageService();
        $compareResults = null;
        $compareResults = $languageService->compareCountry('Spain', 'Honduras');
        $this->assertInternalType('array',$compareResults);
        $this->assertTrue($compareResults['status']);
    }
    
    final function testRestUriByLanguage()
    {
        $parameter = new \App\Config\Parameters();
        $serviceUri = $parameter->getBaseRestUrl().'/'.$parameter->getRestType('byLang').'/'.urlencode('de');
        $this->assertTrue($this->checkServiceUri($serviceUri));
        
    }
    final function testRestUriByCountryName()
    {
        $parameter = new \App\Config\Parameters();
        $serviceUri = $parameter->getBaseRestUrl().'/'.$parameter->getRestType('byName').'/'.urlencode('Germany').'?fullText=true';
        $this->assertTrue($this->checkServiceUri($serviceUri));
    }
    function checkServiceUri($serviceUri)
    {
        $client = new Client();
        try {
            $client->head($serviceUri);
            return true;
        } catch (GuzzleHttp\Exception\ClientException $e) {
            return false;
        }
    }
}