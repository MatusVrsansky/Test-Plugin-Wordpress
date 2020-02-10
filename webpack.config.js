const path = require("path");

module.exports = {
    mode: 'development',
    entry: "./wp-content/themes/qusq-lite/js/custom/custom-slider.js",
    output: {
        filename: 'custom-slider-minified.js',
        path: path.resolve(__dirname, './wp-content/themes/qusq-lite/dist')
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                "style-loader", //3. Inject styles into DOM
                "css-loader",   //2. Turns css into commonjs
                "sass-loader"]  //1. Turns sass into css
            }
        ]
    }
};