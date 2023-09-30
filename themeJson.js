const themeJson = require('./theme.json');
const colorPalette = themeJson.settings.color.palette;
const colors = {};

// Prepare for use in SCSS
colorPalette.forEach((color) => {
  colors[color.slug] = color.color;
});

module.exports {
  colors
};