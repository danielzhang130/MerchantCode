<?php

return [
  Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
  Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
  Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['dev' => true, 'test' => true],
  Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
  EightPoints\Bundle\GuzzleBundle\EightPointsGuzzleBundle::class => ['all' => true],
  Knp\Bundle\MenuBundle\KnpMenuBundle::class => ['all' => true],
  Sonata\BlockBundle\SonataBlockBundle::class => ['all' => true],
  Sonata\AdminBundle\SonataAdminBundle::class => ['all' => true],
  Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle::class => ['all' => true],
//  Sonata\UserBundle\SonataUserBundle::class => ['all' => true],
  Symfony\Bundle\AclBundle\AclBundle::class => ['all' => true],
  Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
  Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true, 'test' => true],
  Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
  Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
  Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
  Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
  Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle::class => ['all' => true],
//  HWI\Bundle\OAuthBundle\HWIOAuthBundle::class => ['all' => true],
  Http\HttplugBundle\HttplugBundle::class => ['all' => true],
  FOS\ElasticaBundle\FOSElasticaBundle::class => ['all' => true],
//  JMS\SerializerBundle\JMSSerializerBundle::class => ['all' => true],
//  OpenAPI\Server\OpenAPIServerBundle::class => ['all' => true],
  Symfony\WebpackEncoreBundle\WebpackEncoreBundle::class => ['all' => true],
  Sonata\Doctrine\Bridge\Symfony\SonataDoctrineBundle::class => ['all' => true],
  Gesdinet\JWTRefreshTokenBundle\GesdinetJWTRefreshTokenBundle::class => ['all' => true],
//  SymfonyCasts\Bundle\ResetPassword\SymfonyCastsResetPasswordBundle::class => ['all' => true],
//  SymfonyCasts\Bundle\VerifyEmail\SymfonyCastsVerifyEmailBundle::class => ['all' => true],
  Sonata\Form\Bridge\Symfony\SonataFormBundle::class => ['all' => true],
//  Sonata\DatagridBundle\SonataDatagridBundle::class => ['all' => true],
//  FOS\UserBundle\FOSUserBundle::class => ['all' => true],
  Sonata\CoreBundle\SonataCoreBundle::class => ['all' => true],
];
