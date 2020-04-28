const path = require('path');

module.exports = {
  entry: path.resolve(__dirname, './assets/js/admin.js'),
  mode: 'production',
  output: {
    filename: 'admin.min.js',
    path: path.resolve(__dirname, './assets/js/'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: ['babel-loader'],
      },
    ],
  },
  devtool: 'source-map',
};
