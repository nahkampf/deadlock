<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/screens',
        __DIR__ . '/src',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets(php71: true)
    ->withIndent(indentChar: ' ', indentSize: 4)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true
    );
