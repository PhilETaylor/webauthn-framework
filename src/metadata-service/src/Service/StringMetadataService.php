<?php

declare(strict_types=1);

namespace Webauthn\MetadataService\Service;

use function array_key_exists;
use Assert\Assertion;
use function Safe\sprintf;
use Webauthn\MetadataService\Statement\MetadataStatement;

final class StringMetadataService implements MetadataService
{
    /**
     * @var MetadataStatement[]
     */
    private array $statements = [];

    public function __construct(string ...$statements)
    {
        foreach ($statements as $statement) {
            $this->addStatements(MetadataStatement::createFromString($statement));
        }
    }

    public static function create(string ...$statements): self
    {
        return new self(...$statements);
    }

    public function addStatements(MetadataStatement ...$statements): self
    {
        foreach ($statements as $statement) {
            $aaguid = $statement->getAaguid();
            if ($aaguid === null) {
                continue;
            }
            $this->statements[$aaguid] = $statement;
        }

        return $this;
    }

    public function list(): iterable
    {
        yield from array_keys($this->statements);
    }

    public function has(string $aaguid): bool
    {
        return array_key_exists($aaguid, $this->statements);
    }

    public function get(string $aaguid): MetadataStatement
    {
        Assertion::keyExists(
            $this->statements,
            $aaguid,
            sprintf('The Metadata Statement with AAGUID "%s" is missing', $aaguid)
        );

        return $this->statements[$aaguid];
    }
}
