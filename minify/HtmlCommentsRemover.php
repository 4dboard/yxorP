<?php

namespace yxorP\minify;

use JetBrains\PhpStorm\ArrayShape;

class htmlCommentsRemover extends areplacer implements minfyInterface
{
    #[ArrayShape(['{\s*<!--[^\[<>].*(?<!!)-->\s*}msU' => "string"])] public function getReplacePatternData(): array
    {
        return [
            '{\s*<!--[^\[<>].*(?<!!)-->\s*}msU' => ''
        ];
    }
}
