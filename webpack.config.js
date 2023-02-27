let [editorConfig, frontendConfig] = require('@wellmann/gutenberg-blocks-components/configs/webpack.config');
const fastGlob = require('fast-glob');
const PalettePlugin = require('palette-webpack-plugin');
const path = require('path');
const webpack = require('webpack');

editorConfig.plugins = [
  ...editorConfig.plugins,
  new webpack.DefinePlugin({
    __filebasename: webpack.DefinePlugin.runtimeValue(
      info => JSON.stringify(path.parse(info.module.resource).name)
    )
  })
];

frontendConfig.entry = {
  ...frontendConfig.entry,
  'theme.critical': './assets/scss/theme.critical.scss',
};

frontendConfig.plugins = [
  ...frontendConfig.plugins,
  new PalettePlugin({
    output: 'color-palette.json',
    sass: {
      path: 'assets/scss',
      files: ['_variables.scss'],
      variables: ['colors']
    }
  }),
  new PalettePlugin({
    output: 'font-sizes.json',
    sass: {
      path: 'assets/scss',
      files: ['_variables.scss'],
      variables: ['font-sizes']
    }
  })
];

module.exports = [editorConfig, frontendConfig];