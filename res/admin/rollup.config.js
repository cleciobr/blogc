import babel from 'rollup-plugin-babel'

const pkg  = require('./package')
const year = new Date().getFullYear()

const globals = {
  jquery: 'jQuery'
}

export default {
  input  : 'build/js/.js',
  output : {
    banner: `/*!
 *  v${pkg.version} (${pkg.homepage})
 * Copyright 2014-${year} ${pkg.author}
 * Licensed under MIT (https://github.com/almasaeed2010//blob/master/LICENSE)
 */`,
    file  : 'dist/js/adminlte.js',
    format: 'umd',
    globals,
    name  : 'adminlte'
  },
  plugins: [
    babel({
      exclude: 'node_modules/**'
    })
  ]
}
