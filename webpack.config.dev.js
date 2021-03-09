const path = require('path');
const { merge } = require('webpack-merge');
const baseConfig = require('./webpack.config.base.js');

module.exports = merge(baseConfig, {
    mode: 'production',//'development',
    watch: false,
    optimization: {
        minimize: false
    }
});