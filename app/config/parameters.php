<?php 
namespace App\Config;
class Parameters
{
private   $restUrl = 'https://restcountries.eu/rest/v2';
private   $restType = array ('byName' => 'name',
							'byLang' => 'lang');
public function getRestUrl()
{
	return $this->restUrl;
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