<?php

declare(strict_types=1);

use Aio\CmsBundle\Tests\References;
use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Filesystem;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}

// Utilisé dans l'extension PHPUnit
// Aio\CmsBundle\Tests\PHPUnit\PHPUnitExtension
$_ENV['PROJECT_DIR'] = __DIR__ . '/..';

// Références
$fs = new Filesystem();
$fileRef = $_SERVER['FIXTURES_REFERENCES'];
// Création du dossier de références s'il n'existe pas.
$folder = dirname($fileRef);
if (!$fs->exists($folder)) {
    $fs->mkdir($folder);
}

// Chargement des références si le fichier existe.
if ($fs->exists($fileRef)) {
    $kernel = new Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
    $kernel->boot();
    $em = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');

    $data = json_decode(file_get_contents($fileRef), true, 512, JSON_THROW_ON_ERROR);

    $refs = References::getInstance();
    foreach ($data as $key => $ref) {
        $record = $em->getRepository($ref['class'])->findOneBy([
            'id' => $ref['id'],
        ]);
        $refs->addReference($key, $record);
    }
}
