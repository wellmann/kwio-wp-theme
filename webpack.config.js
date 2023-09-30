let [editorConfig, frontendConfig] = require('@wellmann/gutenberg-blocks-components/configs/webpack.config');
const fastGlob = require('fast-glob');
const path = require('path');
const RemoveAssetWebpackPlugin = require('@automattic/remove-asset-webpack-plugin');
const webpack = require('webpack');

frontendConfig.entry = {
  ...frontendConfig.entry,
  'login': './assets/scss/login.scss',
  'theme.critical': './assets/scss/theme.critical.scss',
};

frontendConfig.plugins = [
  ...frontendConfig.plugins,
  new RemoveAssetWebpackPlugin({
    assets: [
      'critical.js',
      'login.js',
      'theme.critical.js',
    ],
  }),
];

module.exports = [editorConfig, frontendConfig];