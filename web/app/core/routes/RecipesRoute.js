App.RecipesRoute = Ember.Route.extend({
	model: function(){
		return this.store.find('recipe')
	}
});

App.RecipeShowRoute = Ember.Route.extend({
	model: function(params) {
		return this.store.find('recipe', params.recipe_id);
	},
	serialize: function(model, params) {
		return { recipe_id: model.get('slug') };
	}
});