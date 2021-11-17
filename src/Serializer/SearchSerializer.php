<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\Search\Serializer;

use MagicLegacy\Component\Search\Exception\SearchSerializerException;
use Safe\Exceptions\JsonException;

use function Safe\{json_encode, json_decode};

/**
 * Class SearchSerializer
 * Exception code range: 8200-8250
 * @author Romain Cottard
 */
final class SearchSerializer
{
    /**
     * @param \JsonSerializable $object
     * @return string
     * @throws SearchSerializerException
     */
    public function serialize(\JsonSerializable $object): string
    {
        try {
            return json_encode($object);
        } catch (JsonException $exception) {
            throw new SearchSerializerException('[CLI-8200] Cannot serialize data (json_encode failed)!', 8200, $exception);
        }
    }

    /**
     * @param string $json
     * @param string $class
     * @param bool $skippableParameters
     * @return SearchSerializerInterface|self
     * @throws SearchSerializerException
     */
    public function unserialize(string $json, string $class, bool $skippableParameters = false)
    {
        try {
            $data = json_decode($json, true);

            return $this->hydrate($class, $data, $skippableParameters);
        } catch (JsonException $exception) {
            throw new SearchSerializerException('[CLI-8201] Cannot unserialize data (json_decode failed)!', 8201, $exception);
        }
    }

    /**
     * @param string $class
     * @param array $data
     * @param bool $skippableParameters
     * @return mixed
     * @throws SearchSerializerException
     */
    private function hydrate(string $class, array $data, bool $skippableParameters)
    {
        try {
            $reflection = new \ReflectionClass($class);
        } catch (\ReflectionException $exception) {
            throw new SearchSerializerException("[CLI-8202] Given class does not exists! (class: '$class')", 8203, $exception);
        }

        $parameters   = $reflection->getConstructor()->getParameters();
        $nbParameters = count($parameters);

        $orderedArguments = [];
        foreach ($parameters as $parameter) {
            $parameterName = $parameter->getName();
            $argumentValue = null;

            if ($this->hasValidNamedData($parameterName, $data)) {
                $parameterReflectionClass = $parameter->getClass();
                $argumentValue            = $data[$parameterName];
                if ($this->isHydratableArgument($parameterReflectionClass, $argumentValue)) {
                    $argumentValue = $this->hydrate($parameterReflectionClass->getName(), $argumentValue, $skippableParameters);
                }
            } elseif ($this->hasValidArrayData($parameter, $nbParameters)) {
                $argumentValue = $data;
            } elseif (!$skippableParameters) {
                throw new SearchSerializerException("[CLI-8203] Cannot deserialize object: data '$parameterName' does not exist!", 8203);
            }

            $orderedArguments[$parameter->getPosition()] = $argumentValue;
        }

        ksort($orderedArguments);

        return new $class(...$orderedArguments);
    }

    /**
     * @param string $parameterName
     * @param array $data
     * @return bool
     */
    private function hasValidNamedData(string $parameterName, array $data): bool
    {
        return array_key_exists($parameterName, $data);
    }

    /**
     * @param \ReflectionParameter $parameter
     * @param int $nbParameters
     * @return bool
     */
    private function hasValidArrayData(\ReflectionParameter $parameter, int $nbParameters): bool
    {
        return ($nbParameters === 1 && $parameter->isArray());
    }

    /**
     * @param \ReflectionClass|null $parameterReflectionClass
     * @param mixed $data
     * @return bool
     */
    private function isHydratableArgument(?\ReflectionClass $parameterReflectionClass, $data): bool
    {
        return (
            $parameterReflectionClass !== null
            && in_array(\JsonSerializable::class, $parameterReflectionClass->getInterfaceNames())
            && is_array($data)
        );
    }
}
