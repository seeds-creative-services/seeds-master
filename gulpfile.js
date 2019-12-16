const { src, dest, watch, series } = require('gulp')

const config = { env: process.env.NODE_ENV || 'development', paths: {} }

config.paths.src = { css: `assets/src/css`, js: `assets/src/js` }
config.paths.dist = { css: `assets/dist/css`, js: `assets/dist/js` }
config.paths.blocks = `../../plugins/seedscs-blocks/blocks`

const tasks = {


  /**
   * Environment tasks.
   */

  env: {

    /**
     * @method tasks.env.development
     * @description Set the Node environment to "development".
     */
  
    development: function() {
  
      return Promise.resolve(process.env.NODE_ENV = config.env = 'development')
  
    },
  
    /**
     * @method tasks.env.production
     * @description Set the Node environment to "production".
     */
  
    production: function() {
  
      return Promise.resolve(process.env.NODE_ENV = config.env = 'production')
  
    }
  
  },


  /**
   * Compiler tasks.
   */

  compile: {

    /**
     * @method tasks.compile.css
     * @description Compile Stylesheet files.
     */

    css: function() {
  
      if(config.env === 'production') {
  
        const minifycss = require('gulp-csso')
  
        return src(`${config.paths.src.css}/*.css`)
          .pipe(minifycss())
          .pipe(dest(config.paths.dist.css));
  
      }else{
  
        const sourcemaps = require('gulp-sourcemaps')
  
        return src(`${config.paths.src.css}/*.css`)
          .pipe(sourcemaps.init())
          .pipe(sourcemaps.write('.'))
          .pipe(dest(config.paths.dist.css));
  
      }
  
    },


    /**
     * @method tasks.compile.js
     * @description Compile JavaScript files.
     */

    js: function() {

      const cleanjs = require('gulp-prettier')

      if(config.env === 'production') {

        const minifyjs = require('gulp-uglify-es').default

        return src(`${config.paths.src.js}/*.js`)
          .pipe(cleanjs())
          .pipe(minifyjs({mangle: false}))
          .pipe(dest(config.paths.dist.js));

      }else{

        return src(`${config.paths.src.js}/*.js`)
          .pipe(cleanjs())
          .pipe(dest(config.paths.dist.js));
        
      }

    }

  },


  /**
   * File watch tasks.
   */

  watch: function() {

    // Watch configuration files for changes.
    watch(`tailwind.config.js`, series(tasks.compile.css))

    // Watch CSS files for changes.
    watch(`${config.paths.src.css}/**/*.css`, series(tasks.compile.css))

    // Watch JS files for changes.
    watch(`${config.paths.src.js}/**/*.js`, series(tasks.compile.js))

  }

}

exports.build = series(tasks.env.production, tasks.compile.css, tasks.compile.js)
exports.development = series(tasks.env.development, tasks.compile.css, tasks.compile.js, tasks.watch)
exports.production = series(tasks.env.production, tasks.compile.css, tasks.compile.js)

exports.default = config.env === 'production' ? exports.production : exports.development