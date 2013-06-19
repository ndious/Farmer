<?php
namespace FarmerTest;

use Farmer\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSpawnersFolder()
    {
        $this->assertEquals(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Spawners' . DIRECTORY_SEPARATOR, Application::SPAWNERS_DIR());
    }

    public function testGetNonReferecedFolder()
    {
        try {
            Application::NONREFERENCED_DIR();
        } catch (\Exception $exc) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testGetNonexistantFolder()
    {
        $this->markTestIncomplete('This function has not been implemented yet.');
        Application::set('folder', 'nonexistant');
        try {
            Application::NONEXISTANT_DIR();
        } catch (\Exception $exc) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }
}