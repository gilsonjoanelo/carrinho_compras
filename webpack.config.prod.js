const path = require('path');
const { merge } = require('webpack-merge');
const baseConfig = require('./webpack.config.base.js');

module.exports = merge(baseConfig, {
    mode: 'production',
    watch: false,
    //DIST: path.resolve('C:/xampp/htdocs/arfaculdade') //path.resolve(__dirname, 'output')
});