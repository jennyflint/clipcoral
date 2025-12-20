<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return RectorConfig::configure()
    // 1. Paths to the code to analyze
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])

    // 2. Cache configuration (important for speed on large projects)
    ->withCache(
        cacheDirectory: __DIR__ . '/var/rector',
    )

    // 3. Symfony Container integration (CRITICALLY IMPORTANT)
    // This allows Rector to understand your service types and injection
    ->withSymfonyContainerXml(__DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.xml')
    ->withComposerBased(symfony: true, doctrine: true, phpunit: true)
    ->withAttributesSets(symfony: true, phpunit: true, doctrine: true)

    // 4. Rule Sets
    ->withSets([
        // --- PHP Version ---
        // Upgrade code to PHP 8.4 features (readonly, enums, new in initializers)
        LevelSetList::UP_TO_PHP_84,
    ])
    ->withPreparedSets(deadCode: true, codeQuality: true, typeDeclarations: true, earlyReturn: true, privatization: true)

    // 5. Exclusions (Skip)
    // Here we specify folders or specific rules to ignore
    ->withSkip([
        // Standard folders to skip
        __DIR__ . '/var',
        __DIR__ . '/vendor',
        __DIR__ . '/public',
        __DIR__ . '/config', // It is safer to modify configs manually

        // --- Examples of specific rule exclusions ---

        // If you don't want Rector to add 'void' to methods without return
        // \Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector::class,

        // Sometimes Rector is too aggressive with readonly entities
        // \Rector\Php84\Rector\Class_\ReadOnlyClassRector::class => [
        //     __DIR__ . '/src/Entity/*',
        // ],
    ])
    ->withComposerBased(symfony: true);
