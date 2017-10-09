<?php

use Illuminate\Support\Facades\Artisan;
use \Laravel\Lumen\Testing\DatabaseMigrations;
use Symfony\Component\Console\Application;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{

     /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
     public function createApplication()
     {
         return require __DIR__.'/../bootstrap/app.php';
     }
 
     public function setUp()
     {
         parent::setUp();
         $this->refreshApplication();
         Artisan::call('migrate');
     }
 
     public function tearDown()
     {
         Artisan::call('migrate:reset');
     }
 
}
