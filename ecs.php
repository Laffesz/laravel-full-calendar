<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUnreachableDefaultArgumentValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\StaticLambdaFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitSetUpTearDownVisibilityFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\StringNotation\HeredocToNowdocFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->sets([SetList::PSR_12, SetList::CLEAN_CODE, SetList::STRICT]);

    $ecsConfig->rules([
        PsrAutoloadingFixer::class,
        OrderedClassElementsFixer::class,
        ProtectedToPrivateFixer::class,
        NoUselessElseFixer::class,
        NoUnreachableDefaultArgumentValueFixer::class,
        StaticLambdaFixer::class,
        PhpUnitSetUpTearDownVisibilityFixer::class,
        NoUselessReturnFixer::class,
        HeredocToNowdocFixer::class,
        ArrayIndentationFixer::class,
        NoUnusedImportsFixer::class,
    ]);

    $ecsConfig->ruleWithConfiguration(GlobalNamespaceImportFixer::class, ['import_classes' => false, 'import_constants' => false, 'import_functions' => false]);
    $ecsConfig->ruleWithConfiguration(NativeFunctionInvocationFixer::class, ['include' => ['@compiler_optimized']]);
    $ecsConfig->ruleWithConfiguration(PhpdocAlignFixer::class, ['align' => 'left']);
    $ecsConfig->ruleWithConfiguration(PhpUnitMethodCasingFixer::class, ['case' => 'snake_case']);
    $ecsConfig->ruleWithConfiguration(PhpUnitTestAnnotationFixer::class, ['style' => 'annotation']);
    $ecsConfig->ruleWithConfiguration(LineLengthFixer::class, ['line_length' => 160, 'inline_short_lines' => false]);

    $ecsConfig->skip([
        PhpdocToCommentFixer::class => null,
        ConcatSpaceFixer::class,
    ]);

    $ecsConfig->paths([__FILE__, __DIR__ . '/src', __DIR__ . '/tests']);
};
