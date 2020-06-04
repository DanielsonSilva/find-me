<?php

namespace danielsonsilva\FindMe;

use Location\Coordinate;
use Location\Distance\Vincenty;
use Location\Distance\Haversine;

class FindMe
{
    /**
     * Api Key from IpStack
     * @var string apiId
     */
    private $apiId;
    
    /**
     * Store the ip string to search
     * @var string ip
     */
    private $ip;
    
    /**
     * All the information related to that Ip
     * @var array info
     */
    private $info;
    
    /**
     * Construct the object with an API Key
     * @param string $apiId
     */
    public function __construct(string $apiId)
    {
        $this->apiId = $apiId;
    }
    
    /**
     * Resets the object to search for another IP
     */
    public function reset(): void
    {
        $this->info = null;
    }
    
    /**
     * Checks if the info is already loaded
     * @return bool True if the info was loaded and False otherwise
     */
    private function isInfoLoaded(): bool
    {
        return ($this->info != null);
    }
    
    /**
     * Load the information of that Ip
     * @param string $ip IP to search for
     */
    public function setInformationFromIp(string $ip): void
    {
        $addrService = "http://api.ipstack.com/$ip?access_key=$this->apiId";
        $result = file_get_contents($addrService);
        $this->info = json_decode($result);
    }
    
    /**
     * Get the property from the info by the name
     * @param string $property Property to be searched for
     * @return The property inside info
     */
    private function getPropertyFromInfo($property)
    {
        return $this->info->$property;
    }
    
    /**
     * Get the property if that property exists
     * @param string $property Property to search inside info
     * @return NULL|string|float The property value if exist or NULL otherwise
     */
    private function getPropertyIfExists($property)
    {
        $value = null;
        if ($this->isInfoLoaded()) {
            $value = $this->getPropertyFromInfo($property);
        }
        return $value;
    }
    
    /**
     * Get the distance from that IP location to another latitude and longitude
     * using a mathematical approach
     * @param float $latitude Destination latitude
     * @param float $longitude Destination longitude
     * @return int|NULL The distance if the info is loaded or NULL otherwise
     */
    public function getDistanceTo($latitude, $longitude): ?int
    {
        $distance = null;
        if ($this->isInfoLoaded()) {
            $lat1 = deg2rad($this->getLatitude());
            $lon1 = deg2rad($this->getLongitude());
            $lat2 = deg2rad($latitude);
            $lon2 = deg2rad($longitude);
            
            $R = 6373.0;
            $dlon = $lon2 - $lon1;
            $dlat = $lat2 - $lat1;
            $a = (sin($dlat/2))**2 + cos($lat1) * cos($lat2) * (sin($dlon/2))**2;
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            $distance = floor($R * $c);
        }
        return $distance;
    }
    
    public function getDistanceToVicenty($latitude, $longitude): int
    {
        $distance = null;
        if ($this->isInfoLoaded()) {
            $coordinate1 = new Coordinate($this->getLatitude(), $this->getLongitude());
            $coordinate2 = new Coordinate($latitude, $longitude);
            
            $calculator = new Vincenty();
            
            $distance = floor($calculator->getDistance($coordinate1, $coordinate2));
        }
        return $distance;
    }
    
    public function getDistanceToHaversine($latitude, $longitude): ?int
    {
        $distance = null;
        if ($this->isInfoLoaded()) {
            $coordinate1 = new Coordinate($this->getLatitude(), $this->getLongitude());
            $coordinate2 = new Coordinate($latitude, $longitude);
            
            $calculator = new Haversine();
            
            $distance = floor($calculator->getDistance($coordinate1, $coordinate2));
        }
        return $distance;
    }
    
    public function getTypeIp(): ?string
    {
        return $this->getPropertyIfExists('type');
    }
    
    public function getContinentCode(): ?string
    {
        return $this->getPropertyIfExists('continent_code');
    }
    
    public function getContinentName(): ?string
    {
        return $this->getPropertyIfExists('continent_name');
    }
    
    public function getCountryCode(): ?string
    {
        return $this->getPropertyIfExists('country_code');
    }
    
    public function getCountryName(): ?string
    {
        return $this->getPropertyIfExists('country_name');
    }
    
    public function getRegionCode(): ?string
    {
        return $this->getPropertyIfExists('region_code');
    }
    
    public function getRegionName(): ?string
    {
        return $this->getPropertyIfExists('region_name');
    }
    
    public function getCityName(): ?string
    {
        return $this->getPropertyIfExists('city');
    }
    
    public function getZipCode(): ?string
    {
        return $this->getPropertyIfExists('zip');
    }
    
    public function getLatitude(): ?float
    {
        return $this->getPropertyIfExists('latitude');
    }
    
    public function getLongitude(): ?float
    {
        return $this->getPropertyIfExists('longitude');
    }
    
    public function getGeonameId(): ?string
    {
        return $this->getPropertyIfExists('location->geoname_id');
    }
    
    public function getCountryCapital(): ?string
    {
        return $this->getPropertyIfExists('location->capital');
    }
    
    public function getLanguageCode(): ?string
    {
        return $this->getPropertyIfExists('location->languages->code');
    }
    
    public function getLanguageName(): ?string
    {
        return $this->getPropertyIfExists('location->languages->name');
    }
    
    public function getLanguageNative(): ?string
    {
        return $this->getPropertyIfExists('location->languages->native');
    }
    
    public function getCountryFlagUnicode(): ?string
    {
        return $this->getPropertyIfExists('country_flag_emoji_unicode');
    }
    
    public function getCountryFlagSvg(): ?string
    {
        return $this->getPropertyIfExists('country_flag');
    }
    
    public function getCountryFlagEmoji(): ?string
    {
        return $this->getPropertyIfExists('country_flag_emoji');
    }
    
    public function getCallingCode(): ?string
    {
        return $this->getPropertyIfExists('calling_code');
    }
    
    public function isEU(): ?bool
    {
        return $this->getPropertyIfExists('is_eu');
    }

}