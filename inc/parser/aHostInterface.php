<?php

namespace yxorP\inc\parser;

use Countable;
use JsonSerializable;

interface aHostInterface extends Countable, JsonSerializable, \yxorP\inc\parser\domainNameInterface, \yxorP\inc\parser\domainNameInterface, \yxorP\inc\parser\effectiveTopLevelDomainInterface, \yxorP\inc\parser\effectiveTopLevelDomainInterface
{
    public function value(): ?string;

    public function toString(): string;

    public function jsonSerialize(): ?string;

    public function count(): int;

    public function toAscii(): self;

    public function toUnicode(): self;
}