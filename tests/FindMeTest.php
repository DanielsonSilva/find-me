<?php
namespace danielsonsilva\FindMe\Tests;

define('DS', DIRECTORY_SEPARATOR);

require_once(__DIR__ . DS . '..' . DS . 'vendor' . DS . 'autoload.php');

use PHPUnit\Framework\TestCase;
use danielsonsilva\FindMe\FindMe;

final class FindMeTest extends TestCase
{

    private $findMeObject;
    
    protected function setUp(): void
    {
        $propertyFile = __DIR__ . DS . '..' . DS . 'properties.xml';
        if (file_exists($propertyFile)) {
            $xml = simplexml_load_file($propertyFile);
        }
        $this->findMeObject = new FindMe($xml->property[0]->id);
    }
    
    private function getMyIp(): string
    {
        return "177.89.53.143";
    }
    
    public function testFindMyCountry()
    {
        $ip = $this->getMyIp();
        $this->findMeObject->setInformationFromIp($ip);
        $this->assertEquals("Brazil", $this->findMeObject->getCountryName());
    }
}