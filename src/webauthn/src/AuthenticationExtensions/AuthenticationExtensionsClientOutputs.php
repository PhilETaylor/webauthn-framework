<?php

declare(strict_types=1);

namespace Webauthn\AuthenticationExtensions;

use function array_key_exists;
use ArrayIterator;
use Assert\Assertion;
use function count;
use const COUNT_NORMAL;
use Countable;
use Iterator;
use IteratorAggregate;
use const JSON_THROW_ON_ERROR;
use JsonSerializable;

/**
 * @implements IteratorAggregate<AuthenticationExtension>
 */
class AuthenticationExtensionsClientOutputs implements JsonSerializable, Countable, IteratorAggregate
{
    /**
     * @var AuthenticationExtension[]
     */
    private array $extensions = [];

    public static function create(): self
    {
        return new self();
    }

    public function add(AuthenticationExtension ...$extensions): void
    {
        foreach ($extensions as $extension) {
            $this->extensions[$extension->name()] = $extension;
        }
    }

    public static function createFromString(string $data): self
    {
        $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        Assertion::isArray($data, 'Invalid data');

        return self::createFromArray($data);
    }

    /**
     * @param array<string, mixed> $json
     */
    public static function createFromArray(array $json): self
    {
        $object = new self();
        foreach ($json as $k => $v) {
            $object->add(AuthenticationExtension::create($k, $v));
        }

        return $object;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->extensions);
    }

    public function get(string $key): AuthenticationExtension
    {
        Assertion::true($this->has($key), sprintf('The extension with key "%s" is not available', $key));

        return $this->extensions[$key];
    }

    /**
     * @return AuthenticationExtension[]
     */
    public function jsonSerialize(): array
    {
        return array_map(static fn (AuthenticationExtension $object) => $object->jsonSerialize(), $this->extensions);
    }

    /**
     * @return Iterator<string, AuthenticationExtension>
     */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->extensions);
    }

    public function count(int $mode = COUNT_NORMAL): int
    {
        return count($this->extensions, $mode);
    }
}
