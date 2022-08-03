<?php

declare(strict_types=1);

namespace yxorP\app\lib\data\graphQL\Type\Definition;

use yxorP\app\lib\data\graphQL\Language\AST\EnumValueDefinitionNode;

class EnumValueDefinition
{
    /** @var string */
    public $name;

    /** @var mixed */
    public $value;

    /** @var string|null */
    public $deprecationReason;

    /** @var string|null */
    public $description;

    /** @var EnumValueDefinitionNode|null */
    public $astNode;

    /** @var array */
    public $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->name = $config['name'] ?? null;
        $this->value = $config['value'] ?? null;
        $this->deprecationReason = $config['deprecationReason'] ?? null;
        $this->description = $config['description'] ?? null;
        $this->astNode = $config['astNode'] ?? null;

        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function isDeprecated()
    {
        return (bool)$this->deprecationReason;
    }
}
