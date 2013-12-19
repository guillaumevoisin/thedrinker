$(document).ready(function() {

	// Select2
	$("select:not('.tags')").width("100%").select2();

	// Ajax selects
	$("input.ajax-select:not('.ajax-select-initialized')").each(function(){//:not selecting the ones already initialized

		var route = $(this).data("ajax-route");
		var route_get = $(this).data("ajax-route-get");
		var multiple = $(this).data("multiple");
		var placeholder = $(this).data('pholder');
		var nb_results = ($(this).data('nb_results') == undefined) ? 10 : $(this).data('nb_results');
		var min_chars = ($(this).data('min_chars') == undefined) ? 0 : $(this).data('min_chars');
		var filter = ($(this).data('filter') == undefined) ? null : $(this).data('filter');
		var clear = ($(this).data('clear') == undefined) ? false : true;
		var tags = ($(this).data('tags') == undefined) ? false : $(this).data('tags');

		$(this).select2({
			placeholder: Translator.get(placeholder),
			minimumInputLength: min_chars,
			multiple: multiple,
			allowClear: clear,
			createSearchChoice: tags ? function(term, data) {
			    if ($(data).filter(function() {
			      return this.title.localeCompare(term) === 0;
			    }).length === 0) {
			      return {
			        id: term,
			        title: term
			      };
			    }
			  } : null,
			ajax: {
				url: Routing.generate(route),
				dataType: 'json',
				type: 'post',
				quietMillis: 100,
				data: function (term, page) {
					return {
						q: term,
						page_limit: nb_results,
						page: page,
						filter: filter
					};
				},
				results: function (data, page) {
					var more = (page * nb_results) < data.total;
					return { results: data.items, more: more };
				}
			},
			initSelection: function(element, callback) {
				var ids=$(element).val();
				if (ids!=="") {
					$.ajax(Routing.generate(route_get, { ids: ids }), {
						type: 'post',
						dataType: "json"
					}).done(function(data) { callback(data); });
				}
			},
			formatResult: formatSelection,
			formatSelection: function(item){ return item.title },
			escapeMarkup: function (m) { return m; }
		});

		$(this).addClass("ajax-select-initialized");//mark as initialized 
	});

	// Uniform
	$(":checkbox, :radio").uniform();

	// Swipes
	
	$(".swiper-container").each(function(){
		$(this).swiper({
			mode:'horizontal',
			calculateHeight: true,
			grabCursor: true
		});
	});	

	// Share
	
	$(".actions-buttons .like a").click(function(){

		var recipeId = $(this).parents(".actions-buttons").data("recipe-id");

		$.post(Routing.generate('recipe_favorite', { id: recipeId }), null, function(data, textStatus, xhr) {
			console.log(data.result);
		}, 'json');

		return false;

	})
});

function formatSelection(item)
{
	html = "<div class='search-item'>";

	if(item.img)
		html += "<div class='img'><img width='75' src='" + item.img + "' /></div>";

	html += "<div class='text'>";
	html += "<h4>" + item.title + "</h4>";

	if(item.description)
		html += "<p>" + item.description + "</p>";

	html += "</div><div class='clear'></div></div>";

	return html;
}