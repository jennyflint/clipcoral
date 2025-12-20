<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

// 1. Finder Configuration
// Finds files in the current directory, excluding specific folders
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

// 2. Rules Configuration
return (new Config())
    ->setRiskyAllowed(true) // Allows rules that might change code behavior (like modernization)
    ->setCacheFile('.php-cs-fixer.cache')
    ->setRules([
        // --- BASE STANDARDS ---
        // Applies the latest PER Coding Style (Standard evolution of PSR-12)
        '@PER-CS2x0' => true,
        // Applies the Symfony coding standard
        '@Symfony' => true,
        // Applies risky Symfony rules (e.g., modernizing code structures)
        '@Symfony:risky' => true,

        // --- MODERN PHP MIGRATION ---
        // Migrates syntax to PHP 8.4 features (safe changes)
        '@PHP8x4Migration' => true,

        // --- STRICT TYPES & COMPARISONS ---
        // Forces `declare(strict_types=1);` at the top of every file
        'declare_strict_types' => true,
        // Replaces `==` with `===` and `!=` with `!==` for strict comparison
        'strict_comparison' => true,
        // Adds `true` as the third argument to functions like `in_array` (strict mode)
        'strict_param' => true,

        // --- CODE STYLE PREFERENCES ---
        // Enforces non-Yoda style (e.g., `$val === true` instead of `true === $val`)
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => false,
        ],
        // Enforces short array syntax `[]` instead of `array()`
        'array_syntax' => ['syntax' => 'short'],
        // Enforces short list syntax `[...] = ...` instead of `list(...)`
        'list_syntax' => ['syntax' => 'short'],
        // Ensures no space between array index and brackets
        'normalize_index_brace' => true,

        // --- CLASSES & ATTRIBUTES ---
        // Removes empty parentheses in attributes: `#[Route()]` becomes `#[Route]`
        'attribute_empty_parentheses' => true,
        // Ensures only one property or constant is defined per statement
        'single_class_element_per_statement' => [
            'elements' => ['property', 'const'],
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
        // Sorts class elements (constants, properties, methods) in a specific order
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'constant_public', 'constant_protected', 'constant_private',
                'property_public', 'property_protected', 'property_private',
                'construct', 'destruct', 'magic', 'phpunit',
                'method_abstract', 'method_public', 'method_protected', 'method_private',
            ],
        ],
        // Replaces `get_class($this)` with `$this::class` (modern PHP)
        'get_class_to_class_keyword' => true,

        // --- IMPORTS (USE STATEMENTS) ---
        // Sorts imports alphabetically and prioritizes them: class -> function -> const
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],
        // Removes unused `use` statements
        'no_unused_imports' => true,
        // Imports global classes (like `\DateTime`) but leaves global functions native
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => false,
            'import_functions' => false,
        ],

        // --- TYPES & SIGNATURES ---
        // Transforms imported FQCN parameters to their short version in PHPDoc and code
        'fully_qualified_strict_types' => true,
        // Adds `: void` return type if the function returns nothing
        'void_return' => true,
        // Ensures method arguments are either on one line or strictly multiline
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => false,
        ],
        // Ensures single space after type hint
        'type_declaration_spaces' => true,
        // Removes space before colon in return type
        'return_type_declaration' => ['space_before' => 'none'],
        // Replaces function calls like `intval($var)` with casting `(int) $var`
        'modernize_types_casting' => true,

        // --- FORMATTING & WHITESPACE ---
        // Aligns binary operators (like `=`) with a single space (no vertical alignment)
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        // Enforces a single space around concatenation operators (`.`)
        'concat_space' => ['spacing' => 'one'],
        // Enforces a single space between the cast and the variable
        'cast_spaces' => ['space' => 'single'],
        // Adds a blank line before specific statements (return, if, try, etc.) for readability
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try', 'if', 'switch', 'for', 'foreach', 'while', 'do'],
        ],
        // Ensures operators are at the beginning of the line when a line wraps
        'operator_linebreak' => [
            'only_booleans' => true,
            'position' => 'beginning',
        ],
        // Removes extra blank lines to keep code compact
        'no_extra_blank_lines' => [
            'tokens' => ['extra', 'throw', 'use'],
        ],
        // Adds trailing commas in multiline arrays and arguments (cleaner git diffs)
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters', 'match'],
        ],
        // Removes unnecessary semicolons
        'no_empty_statement' => true,

        // --- PHPDOC (COMMENTS) ---
        // Vertically aligns tags in PHPDoc (e.g., aligning variable names)
        'phpdoc_align' => ['align' => 'vertical'],
        // Orders PHPDoc tags (@param first, then @return, etc.)
        'phpdoc_order' => true,
        // Adds an empty line between different groups of annotations
        'phpdoc_separation' => true,
        // Disables requirement for a summary period (dot) at the end
        'phpdoc_summary' => false,
        // Prevents docblocks from being converted to single-line comments (preserves metadata/attributes)
        'phpdoc_to_comment' => false,
        // Removes `@return void` if the function is natively typed as `: void`
        'phpdoc_no_empty_return' => true,
        // Trims empty lines in PHPDoc
        'phpdoc_trim' => true,
        // Removes @param/@return tags if they duplicate native type hints (reduces noise)
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'remove_inheritdoc' => true,
        ],
        // Orders types in PHPDoc (null is always last, e.g., `string|null`)
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'alpha',
        ],
        
        // --- STRING & FUNCTIONS OPTIMIZATION ---
        // Replaces `strpos(...) !== false` with `str_contains(...)` (PHP 8+)
        'modernize_strpos' => true,
    ])
    ->setFinder($finder);