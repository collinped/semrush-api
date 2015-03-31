<?php


namespace Silktide\SemRushApi\Test\Model;

use Silktide\SemRushApi\Data\Column;
use Silktide\SemRushApi\Data\Database;
use Silktide\SemRushApi\Data\Type;
use Silktide\SemRushApi\Model\Request;
use PHPUnit_Framework_TestCase;

class RequestTest extends PHPUnit_Framework_TestCase {

    protected $key = 'testkey';
    protected $domain = 'domain';


    public function testGetExpectedResultColumns()
    {
        $columns = [
            Column::COLUMN_OVERVIEW_ADWORDS_BUDGET,
            Column::COLUMN_OVERVIEW_ADWORDS_KEYWORDS
        ];

        $request = new Request(Type::TYPE_DOMAIN_RANKS, [
            'key' => $this->key,
            'domain' => $this->domain,
            'export_columns' => $columns
        ]);

        $this->assertEquals($columns, $request->getExpectedResultColumns());
    }

    public function testRequest()
    {
        $date = '20150115';
        $columns = [
            Column::COLUMN_OVERVIEW_ADWORDS_BUDGET,
            Column::COLUMN_OVERVIEW_ADWORDS_KEYWORDS
        ];

        $options = [
            'key' => $this->key,
            'domain' => $this->domain,
            'display_date' => $date,
            'database' => Database::DATABASE_GOOGLE_UK,
            'export_columns' => $columns
        ];

        $request = new Request(Type::TYPE_DOMAIN_RANKS, $options);

        $options['type'] = Type::TYPE_DOMAIN_RANKS;
        $options['export_escape'] = "1";

        $this->assertEquals($options, $request->getUrlParameters());
    }

    public function testGetEndpoint()
    {
        $request = new Request(Type::TYPE_DOMAIN_RANKS, [
            'key' => $this->key,
            'domain' => $this->domain
        ]);
        $this->assertEquals("http://api.semrush.com/", $request->getEndpoint());
    }


    public function testRequestWithMissingOption()
    {
        $this->setExpectedException('Silktide\SemRushApi\Model\Exception\InvalidOptionException');
        new Request(Type::TYPE_DOMAIN_RANKS, []);
    }

    public function testRequestWithInvalidColumnData()
    {
        $this->setExpectedException('Silktide\SemRushApi\Model\Exception\InvalidOptionException');
        new Request(Type::TYPE_DOMAIN_RANKS, ['key' => $this->key, 'domain' => $this->domain, 'export_columns' => ['Blah', 'At']]);
    }

    public function testRequestWithInvalidColumnValue()
    {
        $this->setExpectedException('Silktide\SemRushApi\Model\Exception\InvalidOptionException');
        new Request(Type::TYPE_DOMAIN_RANKS, ['key' => $this->key, 'domain' => $this->domain, 'export_columns' => 'blah']);
    }

    public function testRequestWithInvalidOption()
    {
        $this->setExpectedException('Silktide\SemRushApi\Model\Exception\InvalidOptionException');
        new Request(Type::TYPE_DOMAIN_RANKS, ['something' => 'bad']);
    }

    public function testRequestWithInvalidDate()
    {
        $this->setExpectedException('Silktide\SemRushApi\Model\Exception\InvalidOptionException');
        new Request(Type::TYPE_DOMAIN_RANKS, ['key' => $this->key, 'domain' => $this->domain, 'display_date' => "20301215"]);
    }

    public function testRequestWithInvalidDomain()
    {
        $this->setExpectedException('Silktide\SemRushApi\Model\Exception\InvalidOptionException');
        new Request(Type::TYPE_DOMAIN_RANKS, ['key' => $this->key, 'domain' => $this->domain, 'export_escape' => 'wrong']);
    }

    public function testRequestWithInvalidBoolean()
    {
        $this->setExpectedException('Silktide\SemRushApi\Model\Exception\InvalidOptionException');
        new Request(Type::TYPE_DOMAIN_RANKS, ['key' => $this->key, 'domain' => "not a domain"]);
    }

    public function testRequestWithInvalidDatabase()
    {
        $this->setExpectedException('Silktide\SemRushApi\Model\Exception\InvalidOptionException');
        new Request(Type::TYPE_DOMAIN_RANKS, ['key' => $this->key, 'domain' => $this->domain, 'database' => 'rubbish']);
    }

    public function testRequestWithInvalidKey()
    {
        $this->setExpectedException('Silktide\SemRushApi\Model\Exception\InvalidOptionException');
        new Request(Type::TYPE_DOMAIN_RANKS, ['key' => 12, 'domain' => $this->domain]);
    }

} 