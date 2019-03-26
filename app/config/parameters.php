<?php 
namespace App\Config;

/**
 * Parameters object returns rest service information. 
 */

class Parameters
{
private   $baseRestUrl = 'https://restcountries.eu/rest/v2';
private   $restType = array ('byName' => 'name',
							'byLang' => 'lang');
public function getBaseRestUrl()
{
	return $this->baseRestUrl;
}

public function getRestType($type)
{
	if (array_key_exists($type,$this->restType))
        {
		return $this->restType[$type];
        }
	else
        {
            return null ;
        }
}



}
