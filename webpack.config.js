let [editorConfig, frontendConfig] = require('@wellmann/gutenberg-blocks-components/configs/webpack.config');
const fastGlob = require('fast-glob');
const path = require('path');
const RemoveAssetWebpackPlugin = require('@automattic/remove-asset-webpack-plugin');
const webpack = require('webpack');

frontendConfig.entry = {
  ...frontendConfig.entry,
  'theme.critical': './assets/scss/theme.critical.scss',
};

frontendConfig.plugins = [
  ...frontendConfig.plugins,
  new RemoveAssetWebpackPlugin({
    assets: [
      'critical.js',
      'theme.critical.js',
    ],
  }),
];

module.exports = [editorConfig, frontendConfig];