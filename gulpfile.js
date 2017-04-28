var elixir = require('laravel-elixir');
//gulp    = require('gulp'),

elixir(function(mix){
	mix
    .copy(
        'bootstrap-sass/assets/fonts/bootstrap', 'public/fonts'
    )
    
    .scripts('vis/dist/vis.js', 'public/js/vis.js', 'node_modules')

    .styles(['vis/dist/vis.css'], 'public/css/vis.css', 'node_modules');

});
