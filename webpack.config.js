const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const pharmacies = ['melissa'];

function generateEntries(productName) {
    let entries = {};
    for (let pharmacy of pharmacies) {
        entries[pharmacy + '_' + productName] = [
            path.resolve(__dirname, 'assets', 'scss', 'pharmacy', '_' + pharmacy + '.scss'),
            path.resolve(__dirname, 'assets', 'scss', productName + '.scss'),
        ];
    }

    return entries;
}

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
                    'sass-loader',
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
        new ImageminPlugin({ test: /\.(jpe?g|png|gif|svg)$/i }),
    ],
    optimization: {
        minimizer: [
            new UglifyJsPlugin(),
            new OptimizeCssAssetsPlugin({}),
        ],
    },
};

