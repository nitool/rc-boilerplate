const { exec } = require('child_process');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const pharmacies = ['melissa', 'cefarm24', 'zawisza', 'allecco', 'olmed', 'wapteka', 'ziko'];

const ArbitraryCodeAfterReload = function (callback) {
  this.apply = function(compiler) {
    if (compiler.hooks && compiler.hooks.done) {
      compiler.hooks.done.tap('webpack-arbitrary-code', callback);
    }
  };
};

const generateEntries = (productName) => {
    let entries = {};
    for (let pharmacy of pharmacies) {
        entries[pharmacy + '_' + productName] = [
            path.resolve(__dirname, 'assets', 'scss', productName + '.scss') + '?' + pharmacy,
            path.resolve(__dirname, 'assets', 'js', productName + '.js'),
        ];
    }

    return entries;
};

module.exports = {
    entry: {
        ...generateEntries('product1'),
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'build'),
    },
    module: {
        rules: [
            {
                test: /\.s[ac]ss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'sass-loader',
                        options: {
                            additionalData: function (content, loaderContext) {
                                let pharmacy = loaderContext.request.match(/(\w+)[?]?$/)[1];

                                return `@import 'pharmacy/${pharmacy}';` + content;
                            },
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin(),
        new CopyWebpackPlugin({
            patterns: [{
                from: 'assets/img/',
                to: 'img/',
            }]
        }),
        // new ImageminPlugin({ test: /\.(jpe?g|png|gif|svg)$/i }), // todo: run only in prod build
    ],
    optimization: {
        minimizer: [
            new UglifyJsPlugin(),
            new OptimizeCssAssetsPlugin({}),
            new ArbitraryCodeAfterReload(() => {
                let callback = (error, stdout, stderr) => {
                    console.log(`generator finished: ${stdout}`);
                }

                console.log('executing generators');
                for (let pharmacy of pharmacies) {
                    exec('./console.php generator:render:single ibuprom_kids_100 ' + pharmacy, callback);
                    exec('./console.php generator:render:single ibuprom_kids_150 ' + pharmacy, callback);
                }
            }),
        ],
    },
};

