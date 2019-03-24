<?php
namespace App\Test;
use SebastianBergmannann\CodeCoverage;
use PHPUnit\Framework\TestCase;
use \App\Src\YasLife;
/**
 * Description of TestLanguageService
 * Test processing for \App\Serv\YasLife\LanguageService class
 * @author anila
 */
final class TestLanguageService extends TestCase {
    
    final function testGetLanguage()
    {
        $languageService = new YasLife\LanguageService();
        $country =$languageService->getLanguageCode('Germany');
        var_dump($this->assertInstanceOf(YasLife\Country::class,$country));
        
        //$this->(1,1);
    }
}
