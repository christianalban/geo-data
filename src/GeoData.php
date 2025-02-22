<?php

namespace Alban\GeoData;

abstract class GeoData
{
    private static $instance;
    abstract public function getCountryDataPath(): string;

    /**
     * Decodificate JSON data.
     * @var array
     */
    protected $data;

    /**
     * Constructor.
     *
     * @param string|null $jsonPath Path to JSON file.
     * @throws \Exception If JSON file not found or invalid.
     */
    private function __construct() {
        $jsonPath = $this->getCountryDataPath();
        if (!file_exists($jsonPath)) {
            throw new \Exception("JSON file not found in $jsonPath");
        }
        $json = file_get_contents($jsonPath);
        $this->data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error at decodificate JSON: " . json_last_error_msg());
        }
    }

    /**
     * Get states data.
     *
     * @return array List of states.
     */
    public function getStates() {
        return $this->data['states'] ?? [];
    }

    /**
     * Get cities data.
     *
     * @param string $stateName State name.
     * @return array List of cities.
     */
    public function getCitiesByState($stateName) {
        foreach ($this->data['states'] as $state) {
            if (strcasecmp($state['name'], $stateName) === 0) {
                return $state['cities'];
            }
        }
        return [];
    }

    /**
     * Return all data.
     *
     * @return array All data.
     */
    public function getData() {
        return $this->data;
    }

    public static function instance(): self {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}
