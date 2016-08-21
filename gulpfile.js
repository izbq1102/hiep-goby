var elixir = require('laravel-elixir');
var gulp = require('gulp');
/**
 * Copy any needed files.
 *
 * Do a 'gulp copyfiles' after bower updates
 */
gulp.task("copyfiles", function() {

  gulp.src("vendor/bower_dl/jquery/dist/jquery.js")
    .pipe(gulp.dest("resources/assets/js/"));
    
  gulp.src("vendor/bower_dl/jquery.fitvids/jquery.fitvids.js")
    .pipe(gulp.dest("resources/assets/js/"));
	
  gulp.src("vendor/bower_dl/headroom.js/dist/headroom.js")
    .pipe(gulp.dest("resources/assets/js/"));
    
  gulp.src("vendor/bower_dl/masonry/dist/masonry.pkgd.js")
    .pipe(gulp.dest("resources/assets/js/"));

  gulp.src("vendor/bower_dl/slick-carousel/slick/slick.js")
    .pipe(gulp.dest("resources/assets/js/"));
  
  gulp.src("vendor/bower_dl/jquery-hoverintent/jquery.hoverIntent.js")
    .pipe(gulp.dest("resources/assets/js/"));

  gulp.src("vendor/bower_dl/ev-emitter/ev-emitter.js")
        .pipe(gulp.dest("resources/assets/js/"));

  gulp.src("vendor/bower_dl/imagesloaded/imagesloaded.js")
    .pipe(gulp.dest("resources/assets/js/"));

  gulp.src("vendor/bower_dl/jquery_lazyload/jquery.lazyload.js")
    .pipe(gulp.dest("resources/assets/js/"));   
 
  //Fonts
  gulp.src("vendor/bower_dl/slick-carousel/slick/fonts/**")
    .pipe(gulp.dest("public/assets/fonts"));
  
  gulp.src("fonts/**")
    .pipe(gulp.dest("public/assets/fonts"));
    
  //Images
  gulp.src("vendor/bower_dl/slick-carousel/slick/ajax-loader.gif")
    .pipe(gulp.dest("public/assets/images"));

  gulp.src("images/**/*")
        .pipe(gulp.dest("public/assets/images"));


    // Css
 //  gulp.src("vendor/bower_dl/slick/*.scss")
//     .pipe(gulp.dest("public/assets/scss/slick"));

});

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
 // Combine scripts
  	mix.scripts([
      'js/jquery.js',
      'js/masonry.pkgd.js',
      'js/jquery.fitvids.js',
      'js/headroom.js',
      'js/jquery.lazyload.js',
      'js/ev-emitter.js',
      'js/imagesloaded.js',
      'js/jquery.hoverIntent.js',
      'js/slick.js'
    ],
    'public/assets/js/all.js',
    'resources/assets'
  	);
    mix.scripts([
            'js/common.js'
        ],
        'public/assets/js/common.js',
        'resources/assets'
    );
    mix.sass('app.scss', 'public/assets/css/all.css');
});