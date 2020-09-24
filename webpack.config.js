const { exec } = require('child_process');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const pharmacies = ['melissa', 'cefarm24', 'zawisza', 'allecco', 'olmed', 'wapteka', 'ziko', 'rosa', 'ceneo'];

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

module.exports = (env, argv) => {
    let plugins = [
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin(),
        new CopyWebpackPlugin({
            patterns: [{
                from: 'assets/img/',
                to: 'img/',
            }]
        }),
    ];

    if (argv.mode === 'production') {
        plugins.push(new ImageminPlugin({ test: /\.(jpe?g|png|gif|svg)$/i }));
    }

    return {
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
                                    if (argv.mode === 'development') {
                                        content = '@import \'base/dev\';\n' + content;
                                    }

                                    let pharmacy = loaderContext.request.match(/(\w+)[?]?$/)[1];
                                    content = `@import 'pharmacy/${pharmacy}';\n` + content;

                                    return content;
                                },
                            },
                        },
                    ],
                },
            ],
        },
        plugins: plugins,
        optimization: {
            minimize: true,
            minimizer: [
                new UglifyJsPlugin(),
                new OptimizeCssAssetsPlugin({}),
                new ArbitraryCodeAfterReload(() => {
                    let callback = (error, stdout, stderr) => {
                        console.log(`generator finished: ${stdout}`);
                    }

                    console.log('executing generators');
                    for (let pharmacy of pharmacies) {
                        exec('./console.php generator:render:single product1 ' + pharmacy, callback);
                    }
                }),
            ],
        },
    };
};

