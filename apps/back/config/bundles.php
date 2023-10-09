<?php

return [
    Sentry\SentryBundle\SentryBundle::class => ['all' => true],
    Nelmio\CorsBundle\NelmioCorsBundle::class => ['all' => true],
    Nelmio\ApiDocBundle\NelmioApiDocBundle::class => ['all' => true],
    FOS\JsRoutingBundle\FOSJsRoutingBundle::class => ['all' => true],
    Shapecode\Bundle\HiddenEntityTypeBundle\ShapecodeHiddenEntityTypeBundle::class => ['all' => true],
    EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle::class => ['all' => true],
    JMS\TranslationBundle\JMSTranslationBundle::class => ['all' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    Scheb\TwoFactorBundle\SchebTwoFactorBundle::class => ['all' => true],
    NotFloran\MjmlBundle\MjmlBundle::class => ['all' => true],
    Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle::class => ['all' => true],
    Knp\Bundle\SnappyBundle\KnpSnappyBundle::class => ['all' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['dev' => true, 'test' => true],
    DAMA\DoctrineTestBundle\DAMADoctrineTestBundle::class => ['test' => true],
    Iomedia\TestBundle\TestBundle::class => ['dev' => true, 'test' => true],
];
