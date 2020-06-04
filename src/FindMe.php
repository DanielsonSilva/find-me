<?php

namespace danielsonsilva\FindMe;

class FindMe
{
    private $apiId;
    
    private $ip;
    
    private $info;
    
    public function __construct(string $apiId)
    {
        $this->apiId = $apiId;
    }
    
    public function reset(): void
    {
        $this->info = null;
    }
    
    private function isInfoLoaded(): bool
    {
        return ($this->info != null);
    }
    
    public function setInformationFromIp(string $ip): void
    {
        $addrService = "http://api.ipstack.com/$ip?access_key=$this->apiId";
        $result = file_get_contents($addrService);
        $this->info = json_decode($result);
    }
    
    private function getPropertyFromInfo($property)
    {
        return $this->info->$property;
    }
    
    private function getPropertyIfExists($property)
    {
        $value = null;
        if ($this->isInfoLoaded()) {
            $value = $this->getPropertyFromInfo($property);
        }
        return $value;
    }
    
    public function getDistanceTo($latitude, $longitude): int
    {
        $lat1 = deg2rad($this->getLatitude());
        $lon1 = deg2rad($this->getLongitude());
        $lat2 = deg2rad($latitude);
        $lon2 = deg2rad($longitude);
        
        $R = 6373.0;
        $dlon = $lon2 - $lon1;
        $dlat = $lat2 - $lat1;
        $a = (sin($dlat/2))**2 + cos($lat1) * cos($lat2) * (sin($dlon/2))**2;
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $R * $c;
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