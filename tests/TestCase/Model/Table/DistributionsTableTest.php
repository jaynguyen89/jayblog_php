<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DistributionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DistributionsTable Test Case
 */
class DistributionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DistributionsTable
     */
    public $Distributions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.distributions',
        'app.posts',
        'app.comments',
        'app.files',
        'app.messages',
        'app.categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Distributions') ? [] : ['className' => DistributionsTable::class];
        $this->Distributions = TableRegistry::get('Distributions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Distributions);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
