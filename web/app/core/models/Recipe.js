App.Recipe = DS.Model.extend({
	name: DS.attr('string'),
	description: DS.attr('string'),
	glassType: DS.attr('string'),
	creator: DS.attr('string'),
	garnish: DS.attr('string'),
	difficulty: DS.attr('string'),
	path: DS.attr('string'),
	slug: DS.attr('string'),
	created: DS.attr('string')
});