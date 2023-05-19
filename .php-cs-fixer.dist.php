<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'default' => 'align_single_space_minimal'
        ],
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'heredoc_to_nowdoc' => true,
        'php_unit_strict' => true,
        'php_unit_construct' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_var_annotation_correct_order' => true,
        'multiline_comment_opening_closing' => true,
        'phpdoc_order' => true,
        'phpdoc_to_comment' => false,
        'strict_comparison' => true,
        'strict_param' => true,
        /*'no_extra_consecutive_blank_lines' => [
            'break',
            'continue',
            'extra',
            'return',
            'throw',
            'use',
            'parenthesis_brace_block',
            'square_brace_block',
            'curly_brace_block',
        ],
        'no_short_echo_tag' => true,*/
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'semicolon_after_instruction' => true,
        'combine_consecutive_unsets' => true,
        'concat_space' => ['spacing' => 'one'],
        'ternary_to_null_coalescing' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile('.php-cs-fixer.cache') // forward compatibility with 3.x line
    ;
