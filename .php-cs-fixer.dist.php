<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        'src',
        'tests',
    ])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'phpdoc_align' => ['align' => 'left'],
        'declare_strict_types' => true,
        'phpdoc_separation' => false,
        'phpdoc_summary' => false,
        'phpdoc_to_comment' => ['ignored_tags' => ['var']],
        'visibility_required' => ['elements' => ['property', 'method', 'const']],
        'yoda_style' => true,
        'concat_space' => ['spacing' => 'one'],
    ])
    ->setFinder($finder);
