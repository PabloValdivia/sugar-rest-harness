<?php
/*
 * Copyright (c) 2015 SugarCRM Inc. Licensed by SugarCRM under the Apache 2.0 license.
 */
namespace SugarRestHarness;

/**
 * RandomizerFactory
 *
 * The RandomizerFactory's job is to generate random data - random names for people,
 * companies, cities, opportunities, ramdom phone numbers, random states and
 * countries, etc. This is all for the purpose of creating large amounts of
 * new entries into sugar quickly and easily without having to think too hard.
 *
 * The RandomizerFactory has two sources of data:
 * 1) hard-coded dictionaries of things like people's names, cities, etc.
 * 2) lists retrived from sugar for things like countries and pull down menu values.
 *
 * The class is implemented as a singleton so that dictionaries don't have to
 * be retrieved from disk/network more than once.
 */
class RandomizerFactory
{
    protected static $instance = null;
    private $randomizers = array();
    
    private function __construct()
    {
    }
    
    
    /**
     * Returns the singleton for this class.
     *
     * @return RandomizerFactory
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    
    /**
     * Loads the specified type of Randomizer. Randomizer names must match an
     * existing Randomizer class, i.e. RandomizerNumber, which must be defined in
     * lib/Randomizers/RandomizerNumber.php or custom/lib/Randomizers/RandomizerNumber.php.
     *
     * This function will cache an instantiaion of the specified class in this 
     * class's randomizers array, and return the instantiated class.
     *
     * @param string $name - the name of the randomizer you want to load.
     * @return RandomizerAbstact - a randomizer object.
     */
    public function loadRandomizer($name)
    {
        $fileName = "Randomizer{$name}";
        $className = "\SugarRestHarness\Randomizers\Randomizer{$name}";
        
        if (!isset($this->randomizers[$className])) {
            $this->randomizers[$className] = $className::getInstance();
        }
        
        return $this->randomizers[$className];
    }
}