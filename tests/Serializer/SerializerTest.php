<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Test\Serializer;

use MagicLegacy\Component\Search\Entity\Ruling;
use MagicLegacy\Component\Search\Exception\SearchSerializerException;
use MagicLegacy\Component\Search\Serializer\SearchSerializer;
use PHPUnit\Framework\TestCase;
use Safe;
use Safe\Exceptions\JsonException;

/**
 * Class SerializerTest
 *
 * @author Romain Cottard
 */
class SerializerTest extends TestCase
{
    /**
     * @return void
     * @throws SearchSerializerException
     */
    public function testICanSerializeAndDeserializeAValueObject(): void
    {
        //~ Serializer / Unserializer service
        $serializer = new SearchSerializer();

        //~ Create new original VO
        $originalEntity = new Ruling('2020-01-01', 'Ruling text here');

        //~ Serialize VO
        $json = $serializer->serialize($originalEntity);

        //~ Unserialize VO
        /** @var Ruling $unserializedEntity */
        $unserializedEntity = $serializer->unserialize($json, Ruling::class);

        //~ Compare data
        $this->assertEquals($originalEntity, $unserializedEntity);
    }

    /**
     * @return void
     * @throws SearchSerializerException
     * @throws JsonException
     */
    public function testAnExceptionIsThrownWhenUnserializedStringHaveNotSupportedField(): void
    {
        $data = ['date' => '2020-01-01', 'other' => 'Ruling text here'];

        $this->expectException(SearchSerializerException::class);
        (new SearchSerializer())->unserialize(Safe\json_encode($data), Ruling::class);
    }

    /**
     * @return void
     * @throws SearchSerializerException
     */
    public function testAnMtgJsonSerializerExceptionIsThrownWhenSerializeInvalidData(): void
    {
        $this->expectException(SearchSerializerException::class);
        (new SearchSerializer())->serialize(
            new class implements \JsonSerializable {
                public function jsonSerialize(): string
                {
                    return "\xB1\x31";
                }
            }
        );
    }

    /**
     * @return void
     * @throws SearchSerializerException
     */
    public function testAnMtgJsonSerializerExceptionIsThrownWhenUnserializeInvalidJson(): void
    {
        $this->expectException(SearchSerializerException::class);
        (new SearchSerializer())->unserialize('[', Ruling::class);
    }

    /**
     * @return void
     * @throws SearchSerializerException
     */
    public function testAnMtgJsonSerializerExceptionIsThrownWhenUnserializeWithNonExistingClass(): void
    {
        $this->expectException(SearchSerializerException::class);
        (new SearchSerializer())->unserialize('[]', 'Test\Hello\Not\Exists');
    }
}
