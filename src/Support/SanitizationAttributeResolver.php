<?php

namespace Upward\Formatters\Support;

use ReflectionClass;
use Upward\Formatters\Contracts\SanitizationAttribute;

/** @internal */
final class SanitizationAttributeResolver
{
    public static function using(ReflectionClass $reflector, object $object): void
    {
        if ($reflector->hasProperty(name: 'value')) {
            $property = $reflector->getProperty(name: 'value');

            $property->setAccessible(accessible: true);
            $value = $property->getValue($object);

            $attributes = $property->getAttributes();

            if (count($attributes)) {
                foreach ($attributes as $attribute) {
                    $attribute = $attribute->newInstance();

                    if ($attribute instanceof SanitizationAttribute) {
                        $property->setValue($object, $attribute::resolve($value));
                    }
                }
            }
        }
    }
}
