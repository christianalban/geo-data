<?php

namespace Alban\GeoData;

class EcuadorGeoData extends GeoData
{
    public function getCountryDataPath(): string
    {
        return __DIR__.'/../data/ecuador.json';
    }
}
