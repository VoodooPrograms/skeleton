<?php

namespace App\SharedKernel\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\GuidType;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

class UuidType extends GuidType
{
    private const NAME = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Uuid
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if ($value instanceof Uuid) {
            return $value;
        }

        try {
            return Uuid::fromString($value);
        } catch (InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed($value, self::NAME, $exception);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (
            $value instanceof Uuid
            || (
                (is_string($value)
                    || (is_object($value) && method_exists($value, 'toRfc4122')))
                && Uuid::isValid((string) $value)
            )
        ) {
            return (string) $value;
        }

        throw ConversionException::conversionFailed($value, self::NAME);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getMappedDatabaseTypes(AbstractPlatform $platform): array
    {
        return [self::NAME];
    }
}