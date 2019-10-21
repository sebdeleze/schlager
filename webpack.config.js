const Encore = require('@symfony/webpack-encore');
const Dotenv = require('dotenv-webpack');
const assetsJsPath = './vendor/iomedia/aio-cms-bundle/assets/js/';
const cmsBundleInit = require(assetsJsPath + 'webpack.js');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .setManifestKeyPrefix('build/')
    .addEntry('app', './assets/app.js')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableStimulusBridge('./assets/controllers.json')
    .enableSassLoader()
    .autoProvidejQuery()
    .enablePostCssLoader()
    .enableSingleRuntimeChunk()
    .splitEntryChunks()

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')
    .addExternals({
        window: 'window',
        document: 'document'
    })
    .addPlugin(
        new Dotenv({
            path: '.env.local',
            defaults: '.env',
            systemvars: true,
            allowEmptyValues: true,
        })
    )
    ;

module.exports = cmsBundleInit(Encore, assetsJsPath);
