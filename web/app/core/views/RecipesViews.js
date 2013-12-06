App.RecipeItemView = Ember.View.extend({
	templateName: "_recipe",
	defaultClass: "recipe",
	tagName: "li"
})

App.RecipesListView = Ember.CollectionView.extend({
	itemViewClass: "App.RecipeItemView",
	contentBinding: "controller",
	tagName: "ul"
});