var elixir = require('laravel-elixir');
var config = elixir.config;

// Add browserify transformer
config.js.browserify.transformers.push({
    name: 'vueify',
    options: {}
}); 


elixir.config.sourcemaps = false;
elixir(function(mix) {
	mix.sass('dashboard.scss', 'public/css/dashboard.css')
		.scripts(['jquery.js', 
				'bootstrap.min.js', 
				'dynamicForm.js', 
				'metisMenu.min.js',
				'fullscreenModal.js'
				], 'public/js/dashboard.js')
		.version(['public/css/dashboard.css', 
				'public/js/dashboard.js'])
		.copy('resources/assets/fonts', 'public/build/fonts/')
		.copy('resources/assets/plugins/', 'public/plugins/')
		.copy('resources/assets/images/', 'public/images/');
});
