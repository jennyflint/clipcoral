<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude([
        'config',
        'var',
        'vendor',
        'public/bundles',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setRiskyAllowed(true)
    ->setCacheFile('.php-cs-fixer.cache')
    ->setRules([
        // --- BASE STANDARDS ---
        // Applies PSR-12 coding standard
        '@PSR12' => true,
        // Applies Symfony coding standard
        '@Symfony' => true,
        // Applies risky Symfony rules (e.g., modernizing code)
        '@Symfony:risky' => true,

        // --- MODERN PHP MIGRATION ---
        // Migrates syntax to PHP 8.4 (safe changes)
        '@PHP84Migration' => true,

        // --- STRICT TYPES ---
        // Forces `declare(strict_types=1);` at the top of every file
        'declare_strict_types' => true,

        // --- CODE STYLE PREFERENCES ---
        // Enforces non-Yoda style (e.g., `$val === true` instead of `true === $val`)
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        
        // --- ARRAYS ---
        // Enforces short array syntax `[]` instead of `array()`
        'array_syntax' => ['syntax' => 'short'],
        // Ensures no space between array index and brackets
        'normalize_index_brace' => true,

        // --- TYPES & SIGNATURES ---
        // Transforms imported FQCN parameters to short version in PHPDoc
        'fully_qualified_strict_types' => true,
        // Adds `: void` return type if function returns nothing
        'void_return' => true,
        // Ensures function arguments are either on one line or strictly multiline
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => false,
        ],
        // Ensures single space after type hint
        'function_typehint_space' => true,
        // Removes space before colon in return type
        'return_type_declaration' => ['space_before' => 'none'],

        // --- PHPDOC (COMMENTS) ---
        // Vertically aligns tags in PHPDoc (e.g., @param)
        'phpdoc_align' => ['align' => 'vertical'],
        // Orders PHPDoc tags (@param first, then @return, etc.)
        'phpdoc_order' => true,
        // Adds empty line between different groups of annotations
        'phpdoc_separation' => true,
        // Disables requirement for a summary period
        'phpdoc_summary' => false,
        // Prevents docblocks from being converted to comments (preserves metadata/annotations)
        'phpdoc_to_comment' => false,
        // Removes @return void if the function is typed as :void
        'phpdoc_no_empty_return' => true,
        // Trims empty lines in PHPDoc
        'phpdoc_trim' => true,
        // Orders types in PHPDoc (null is always last, e.g., string|null)
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'alpha',
        ],

        // --- IMPORTS (USE STATEMENTS) ---
        // Sorts imports alphabetically and orders them: class -> function -> const
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],
        // Removes unused use statements
        'no_unused_imports' => true,
        // Imports global classes (like \DateTime) but keeps global functions (like \count) native
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => false,
            'import_functions' => false,
        ],

        // --- CLASSES & ATTRIBUTES ---
        // Removes empty parentheses in attributes: #[Route()] becomes #[Route]
        'attribute_empty_parentheses' => true,
        // Ensures only one property is defined per statement
        'single_class_element_per_statement' => [
            'elements' => ['property'],
        ],
        // Enforces one empty line between class methods and properties
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
                'property' => 'one',
                'const' => 'one',
                'trait_import' => 'one',
            ],
        ],

        // --- FORMATTING ---
        // Aligns binary operators (like =, =>) with single space
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        // Enforces spaces around concatenation (e.g., $a . $b)
        'concat_space' => ['spacing' => 'one'],
        // Enforces single space between cast and variable (e.g., (int) $var)
        'cast_spaces' => ['space' => 'single'],
        // Ensures space after comma in arrays
        'whitespace_after_comma_in_array' => true,
        // Adds trailing commas in multiline arrays/arguments (cleaner git diffs)
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters', 'match'],
        ],

        // --- CLEANUP ---
        // Removes @param/@return tags if they duplicate native type hints
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'remove_inheritdoc' => true,
        ],

        // --- STRICT/RISKY RULES ---
        // Replaces `==` with `===` (strict comparison)
        'strict_comparison' => true,
        // Adds `true` (strict mode) to functions like in_array, array_search
        'strict_param' => true,
    ])
    ->setFinder($finder);