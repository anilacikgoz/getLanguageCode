<?php
namespace App\Test;
use SebastianBergmannann\CodeCoverage;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use \App\Src\YasLife;
/**
 * Description of TestLanguageService
 * Test processing for \App\Serv\YasLife\LanguageService class
 * @author anila
 */
final class TestLanguageService extends TestCase {
    
    final function testGetLanguageCode()
    {
        $languageService = new YasLife\LanguageService();
        $country =$languageService->getCountryDetail('Spain');        
        $this->assertInstanceOf(YasLife\Country::class,$country);
    }
    
    final function testCompareCountry()
    {
        $languageService = new YasLife\LanguageService();
        $comparaResults = null;
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