var webpack = require( 'webpack' ),
    extractTextPlugin = require( 'extract-text-webpack-plugin' )
    path = require('path'),
    bundlePath = path.resolve( __dirname, 'admin', 'js' );

module.exports = function( env ) {
    let config = {
        entry: "./js/src/index.js",
        output: {
            path: bundlePath,
            filename : 'bundle.js'
        },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader",
                    options: {
                        presets :[ 'react', 'es2015' ],
                        plugins : [
                                    ['import', { 'libraryName': 'antd', 'libraryDirectory': 'es', 'style': "css" }]
                        ]
                    },
           },
           {
               test : /\.css$/,
               use : extractTextPlugin.extract({
                    use : 'css-loader'
                })
            },
            {
               test: /\.(png|jpg|gif)$/,
               loader: 'file-loader',
               options:{
                   name:'[name].[ext]'
                }
           }
        ]
    },
    plugins : [
        new extractTextPlugin( `../css/typehub-admin.css` )
    ]
}
if( null != env && env.PROD ) {
    config.output.filename = 'bundle.min.js';
    config.plugins.push(
        new webpack.DefinePlugin({
            'process.env':{
            'NODE_ENV': JSON.stringify('production')
            }
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress:{
            warnings: true
            }
        })
    );
}else{
    config.watch = true;
}
return config;
}