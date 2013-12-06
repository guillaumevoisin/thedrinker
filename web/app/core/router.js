App.Router.map(function() {
	this.route('recipes');
	this.resource('recipe', function(){
		this.route("show", { path: "/:recipe_id" });
	});
});