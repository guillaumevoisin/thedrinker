App = Ember.Application.create({
	rootElement: '#main-content'
});

App.ApplicationAdapter = DS.RESTAdapter.extend({
	host: 'http://localhost/www/thedrinker/web/app_dev.php',
	namespace: 'api'
});