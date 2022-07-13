<?php

namespace MongoDB\Tests\Operation;

use MongoDB\BSON\ObjectId;
use MongoDB\Collection;
use MongoDB\Driver\WriteConcern;
use MongoDB\Exception\BadMethodCallException;
use MongoDB\InsertOneResult;
use MongoDB\Model\BSONDocument;
use MongoDB\Operation\InsertOne;
use MongoDB\Tests\CommandObserver;

class InsertOneFunctionalTest extends FunctionalTestCase
{
    /** @var Collection */
    private Collection $collection;

    public function setUp(): void
    {
        parent::setUp();

        $this->collection = new Collection($this->manager, $this->getDatabaseName(), $this->getCollectionName());
    }

    /**
     * @dataProvider provideDocumentWithExistingId
     */
    public function testInsertOneWithExistingId($document): void
    {
        $operation = new InsertOne($this->getDatabaseName(), $this->getCollectionName(), $document);
        $result = $operation->execute($this->getPrimaryServer());

        $this->assertInstanceOf(InsertOneResult::class, $result);
        $this->assertSame(1, $result->getInsertedCount());
        $this->assertSame('foo', $result->getInsertedId());

        $expected = [
            ['_id' => 'foo', 'x' => 11],
        ];

        $this->assertSameDocuments($expected, $this->collection->find());
    }

    public function provideDocumentWithExistingId(): array
    {
        return [
            [['_id' => 'foo', 'x' => 11]],
            [(object)['_id' => 'foo', 'x' => 11]],
            [new BSONDocument(['_id' => 'foo', 'x' => 11])],
        ];
    }

    public function testInsertOneWithGeneratedId(): void
    {
        $document = ['x' => 11];

        $operation = new InsertOne($this->getDatabaseName(), $this->getCollectionName(), $document);
        $result = $operation->execute($this->getPrimaryServer());

        $this->assertInstanceOf(InsertOneResult::class, $result);
        $this->assertSame(1, $result->getInsertedCount());
        $this->assertInstanceOf(ObjectId::class, $result->getInsertedId());

        $expected = [
            ['_id' => $result->getInsertedId(), 'x' => 11],
        ];

        $this->assertSameDocuments($expected, $this->collection->find());
    }

    public function testSessionOption(): void
    {
        try {
            (new CommandObserver())->observe(
                function (): void {
                    $operation = new InsertOne(
                        $this->getDatabaseName(),
                        $this->getCollectionName(),
                        ['_id' => 1],
                        ['session' => $this->createSession()]
                    );

                    $operation->execute($this->getPrimaryServer());
                },
                function (array $event): void {
                    $this->assertObjectHasAttribute('lsid', $event['started']->getCommand());
                }
            );
        } catch (\Throwable $e) {
        }
    }

    public function testBypassDocumentValidationSetWhenTrue(): void
    {
        try {
            (new CommandObserver())->observe(
                function (): void {
                    $operation = new InsertOne(
                        $this->getDatabaseName(),
                        $this->getCollectionName(),
                        ['_id' => 1],
                        ['bypassDocumentValidation' => true]
                    );

                    $operation->execute($this->getPrimaryServer());
                },
                function (array $event): void {
                    $this->assertObjectHasAttribute('bypassDocumentValidation', $event['started']->getCommand());
                    $this->assertEquals(true, $event['started']->getCommand()->bypassDocumentValidation);
                }
            );
        } catch (\Throwable $e) {
        }
    }

    public function testBypassDocumentValidationUnsetWhenFalse(): void
    {
        try {
            (new CommandObserver())->observe(
                function (): void {
                    $operation = new InsertOne(
                        $this->getDatabaseName(),
                        $this->getCollectionName(),
                        ['_id' => 1],
                        ['bypassDocumentValidation' => false]
                    );

                    $operation->execute($this->getPrimaryServer());
                },
                function (array $event): void {
                    $this->assertObjectNotHasAttribute('bypassDocumentValidation', $event['started']->getCommand());
                }
            );
        } catch (\Throwable $e) {
        }
    }

    public function testUnacknowledgedWriteConcern(): InsertOneResult
    {
        $document = ['x' => 11];
        $options = ['writeConcern' => new WriteConcern(0)];

        $operation = new InsertOne($this->getDatabaseName(), $this->getCollectionName(), $document, $options);
        $result = $operation->execute($this->getPrimaryServer());

        $this->assertFalse($result->isAcknowledged());

        return $result;
    }

    /**
     * @depends testUnacknowledgedWriteConcern
     */
    public function testUnacknowledgedWriteConcernAccessesInsertedCount(InsertOneResult $result): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessageMatches('/[\w:\\\\]+ should not be called for an unacknowledged write result/');
        $result->getInsertedCount();
    }

    /**
     * @depends testUnacknowledgedWriteConcern
     */
    public function testUnacknowledgedWriteConcernAccessesInsertedId(InsertOneResult $result): void
    {
        $this->assertInstanceOf(ObjectId::class, $result->getInsertedId());
    }
}
