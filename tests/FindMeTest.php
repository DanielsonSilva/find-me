<?php
namespace danielsonsilva\FindMe\Tests;

define('DS', DIRECTORY_SEPARATOR);

require_once(__DIR__ . DS . '..' . DS . 'vendor' . DS . 'autoload.php');

use PHPUnit\Framework\TestCase;
use danielsonsilva\FindMe\FindMe;

final class FindMeTest extends TestCase
{

    private $findMeObject;
    
    private $citiesInformation;
    
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
        // write your own IP
        return "177.89.53.143";
    }
    
    private function readyCitiesInformation(): bool
    {
        try {
            $file = fopen(__DIR__ . DS ."citiesinformation.csv", "r");
            while (($fileContents = fgetcsv($file)) !== FALSE) {
                $this->citiesInformation[] = $fileContents;
            }
            return true;
        } catch (Exception $e) {
            print($e);
            return false;
        }
    }
    
    public function testFindMyCountry()
    {
        $ip = $this->getMyIp();
        $this->findMeObject->setInformationFromIp($ip);
        $this->assertEquals("Brazil", $this->findMeObject->getCountryName());
    }
    
    public function testDistanceToLatLon()
    {
        $ip = $this->getMyIp();
        $this->findMeObject->setInformationFromIp($ip);
        if ($this->readyCitiesInformation()) {
            $cityIndex = -1;
            for ($i = 0; $i < count($this->citiesInformation); $i++) {
                if ($this->citiesInformation[$i][0] == "Rio Branco") {
                    $cityIndex = $i;
                    break;
                }
            }
            $destinyLatitude = $this->citiesInformation[$cityIndex][2];
            $destinyLongitude = $this->citiesInformation[$cityIndex][3];
            $distance = $this->findMeObject->getDistanceTo((float)$destinyLatitude, (float)$destinyLongitude);
            $this->assertEqualsWithDelta(3617, $distance, 30617*0.005, "Excepcted:30617 | Calculated Normal: $distance | delta = " . (0.005*100) . '%(' . (30617*0.005) . ')');
            $distance = $this->findMeObject->getDistanceToVicenty((float)$destinyLatitude, (float)$destinyLongitude)/1000;
            $this->assertEqualsWithDelta(3617, $distance, 30617*0.005, "Excepcted:30617 | Calculated Vicenty: $distance | delta = " . (0.005*100) . '%(' . (30617*0.005) . ')');
            $distance = $this->findMeObject->getDistanceToHaversine((float)$destinyLatitude, (float)$destinyLongitude)/1000;
            $this->assertEqualsWithDelta(3617, $distance, 30617*0.005, "Excepcted:30617 | Calculated Haversine: $distance | delta = " . (0.005*100) . '%(' . (30617*0.005) . ')');
        }
    }
}