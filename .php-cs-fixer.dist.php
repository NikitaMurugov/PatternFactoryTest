<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'final_class' => true,
        'declare_strict_types' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'try',
                'if',
                'return',
                'throw',
                'exit',
                'continue',
                'yield',
            ],
        ],
        'class_attributes_separation' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'not_operator_with_successor_space' => true,
        'method_chaining_indentation' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
;
