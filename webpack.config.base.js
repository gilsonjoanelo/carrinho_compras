const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const FileManagerPlugin = require('filemanager-webpack-plugin');

module.exports = {
  entry: {
    login: './src/scripts/login/index.js',
    funcoes: './src/scripts/funcoes/index.js',
    home: './src/scripts/home/index.js',
    theme_padrao: ['./src/content/padrao/index.css']
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'output'),
    clean: true
  },
  plugins: [
    new MiniCssExtractPlugin({
      linkType: false,
      filename: "[name].css",
    }),
    new FileManagerPlugin({
      events: {
        onEnd: {
          copy: [
            { source: path.resolve(__dirname, 'src/rootFiles'), destination: path.resolve(__dirname, "dist") },
            { source: path.resolve(__dirname, 'src/base'), destination: path.resolve(__dirname, "dist/base") },
            { source: path.resolve(__dirname, 'src/controllers'), destination: path.resolve(__dirname, "dist/controllers") },
            { source: path.resolve(__dirname, 'src/services'), destination: path.resolve(__dirname, "dist/services") },
            { source: path.resolve(__dirname, 'src/views'), destination: path.resolve(__dirname, "dist/views") },

            { source: path.resolve(__dirname, 'node_modules/jquery/dist/*.*'), destination: path.resolve(__dirname, "dist/scripts") },
            { source: path.resolve(__dirname, 'node_modules/bootstrap/dist/js/*.*'), destination: path.resolve(__dirname, "dist/scripts") },
            { source: path.resolve(__dirname, 'node_modules/toastr/build/**/*.js'), destination: path.resolve(__dirname, "dist/scripts") },
            { source: path.resolve(__dirname, 'output/**/*.js'), destination: path.resolve(__dirname, "dist/scripts") },
            
            { source: path.resolve(__dirname, 'node_modules/bootstrap/dist/css/*.*'), destination: path.resolve(__dirname, "dist/content") },
            { source: path.resolve(__dirname, 'node_modules/toastr/build/**/*.css'), destination: path.resolve(__dirname, "dist/content") },
            { source: path.resolve(__dirname, 'output/**/*.css'), destination: path.resolve(__dirname, "dist/content") },
          ]
        }
      }
    }),
    {
      apply: (compiler) => {
        compiler.hooks.done.tap('DonePlugin', (stats) => {
          console.log('Compile is done !')
          setTimeout(() => {
            process.exit(0)
          })
        });
      }
    }
  ],
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [MiniCssExtractPlugin.loader, 'css-loader']
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel-loader'
      }
    ]
  }
};