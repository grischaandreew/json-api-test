<?php
use \Codeception\Specify;

//Incude only licences that non-copy-left licences
const DWP_LICENCE_WHITELIST = [
    'BSD-2-Clause',
    'BSD-3-Clause',
    'BSD-3-Clause-Attribution',
    'BSD',
    'Apache-2.0',
    'MIT'
    ];

class LicenseTest extends \Codeception\Test\Unit
{
    /**
     * Identify copy-left FOSS licences in composer modules
     */
    public function testLicencesValid() {
        $installedJSONString = file_get_contents(__DIR__ . '/../../vendor/composer/installed.json');
        $installedJSON = json_decode($installedJSONString)->packages;

        $composerJSONString = file_get_contents(__DIR__ . '/../../composer.json');
        $composerJSON = (array)json_decode($composerJSONString);

        //ensure we have actually found the licensing info
        verify("found licensing info", count($installedJSON))->greaterThan(3);

        $requiredDependencies = array_keys((array)$composerJSON['require']);
        $requiredDevDependencies = array_keys((array)$composerJSON['require-dev']);

        //ensure we have actually found the required modules
        verify("found required modules", count($requiredDependencies))->greaterThan(1);

        foreach($installedJSON as $dependency) {
            $dependencyMetaData = (array)$dependency;
            $name = $dependencyMetaData['name'] ?? '==invalid name==';
            $licence = $dependencyMetaData['license'] ?? [];
            if(count(array_intersect($licence, DWP_LICENCE_WHITELIST)) == 0) {
                verify("prod modules have correct licenses: $name", !in_array($name, $requiredDependencies) && in_array($name, $requiredDevDependencies))->equals(true);
            }
        }
    }
}
