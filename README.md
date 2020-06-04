# Find Me Helper

 Package to help find you in this world and several others auxiliar methods relating to GPS
 
 This library uses the service from https://ipstack.com/


## How To Use

```
// create your object using your API Key from IpStack
$findMeObject = new FindMe('DUuhew712hnhNNASbdnw90');

// Get the IP string from your cliente and set the information
$findMeObject->setInformationFromIp($ip);

// Now that you have your object loaded, you can use methods like
echo $findMeObject->getCountryName();

// Or you can define new latitudes and longitudes
$destinyLatitude = -15.90377472;
$destinyLongitude = 9.673627181;

// And get the distance though three different ways
echo $findMeObject->getDistanceTo($destinyLatitude, $destinyLongitude); //in kilometers
echo $findMeObject->getDistanceToVicenty($destinyLatitude, $destinyLongitude); //in meters
echo $findMeObject->getDistanceToHaversine($destinyLatitude, $destinyLongitude); //in meters
```