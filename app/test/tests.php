<?php
require '../../app/bootstrap.php';
use App\Test\TestLanguageService;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$tests = new TestLanguageService();
var_dump($tests->testGetLanguage());
