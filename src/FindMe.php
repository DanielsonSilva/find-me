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
    
    public function getTypeIp(): ?string
    {
        
    }
    
    public function getContinentCode(): ?string
    {
        
    }
    
    public function getContinentName(): ?string
    {
        
    }
    
    public function getCountryCode(): ?string
    {
        
    }
    
    public function getCountryName(): ?string
    {
        $value = null;
        if ($this->isInfoLoaded()) {
            return $this->info->country_name;
        }
        return $value;
    }
    
    public function getRegionCode(): ?string
    {
        
    }
    
    public function getRegionName(): ?string
    {
        
    }
    
    public function getCityName(): ?string
    {
        
    }
    
    public function getZipCode(): ?string
    {
        
    }
    
    public function getLatitude(): ?float
    {
        $value = null;
        if ($this->isInfoLoaded()) {
            return $this->info->latitude;
        }
        return $value;
    }
    
    public function getLongitude(): ?float
    {
        $value = null;
        if ($this->isInfoLoaded()) {
            return $this->info->longitude;
        }
        return $value;
    }
    
    public function getGeonameId(): ?string
    {
        
    }
    
    public function getCountryCapital(): ?string
    {
        
    }
    
    public function getLanguageCode(): ?string
    {
        
    }
    
    public function getLanguageName(): ?string
    {
        
    }
    
    public function getLanguageNative(): ?string
    {
        
    }
    
    public function getCountryFlagUnicode(): ?string
    {
        
    }
    
    public function getCountryFlagSvg(): ?string
    {
        
    }
    
    public function getCountryFlagEmoji(): ?string
    {
        
    }
    
    public function getCallingCode(): ?string
    {
        
    }
    
    public function isEU(): ?bool
    {
        
    }

}