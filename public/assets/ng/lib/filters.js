/*!
	filters.js: is a file requires all filters belongs to us.
	plug_options
  lists
	trans
	price
	dateF
	trueToList
	include_path
	trusted
*/
/* Plugin Options */
App.filter('plugin_options', function() {
	return function(v,data) {
		var options = v;
		switch (data) {
			case 'range':
				var options = angular.extend(options,{opens: 'left',minDate: new Date,autoApply: true,locale: {
            format: 'dddd MM/DD'
        }});
			break;
		}
    return options;
	}
});

/* Lists */
App.filter('lists', function() {
	return function(v,data) {
		switch (data) {
			case 'homes_types':
				var list = ['bed','private_room','entire_home'];
			break;
			case 'realestate_types':
				var list = ['hotel_apartments','hotel','apartment','house','villa','building','tower','chalet'];
			break;
			case 'amenities':
				var list = ['breakfast','wifi','tv','air_conditioning','bathroom','balcony','kitchen','sitting','washer','cleaning_tools','heater','water_cooler','desk','wardrobe','coffee_tea_maker','shuttle_to_haram','shuttle_to_airport','resturant','business_centre','babysitting_service','parking','gym','barber','atm','cafe','laundary','elevator'];
			break;
			case 'pricing_packages':
				/*
					cities: when add a home and select a city so show only the packages related with it.
				*/
				var list = [{id: 1,code: 'weekly'},{id: 2,code: 'monthly'},{id: 3,code: 'full_ramadan',cities: [1,2]},{id: 4,code: 'ramadan_1_9',cities: [1,2]},{id: 5,code: 'ramadan_10_19',cities: [1,2]},{id: 6,code: 'ramadan_last_ten',cities: [1,2]},{id: 7,code: 'hajj',cities: [1]}];
			break;
		}
    return list;
	}
});

/* Translate */
function getNestedObjectByDots( propertyName, object ) {
  var parts = propertyName.split( "." ),
    length = parts.length,
    i,
    property = object || this;

  for ( i = 0; i < length; i++ ) {
    property = property[parts[i]];
  }

  return property;
}
App.filter('trans', function() {
	return function(v) {
		return getNestedObjectByDots(v,window.trans);
	}
});

/* URL */
App.filter('url', function() {
	return function(v,key) {
		var url = home_url;

		switch (key) {
			case 'upload_homes':
				url += '/uploads/homes/'+v;
			break;
		}
    return url;
	}
});

App.filter('price', function($filter) {
	return function(v) {
		return ((!v) ? 0 : $filter('currency')(v,'',0))+' ر.س';
	}
});

App.filter('dateF', function($filter) {
	return function(dateSTR,v) {
		return $filter('date')(new Date(dateSTR),v);
	}
});

/*
	When we have checkbox list such as amenities and we need to get all selected values into an array
*/
App.filter('trueToList', function($filter) {
	return function(val) {
		var arr = [];
		if (angular.isObject(val)) {
			angular.forEach(val,function(v,k){
				if (v === true) {
					arr.push(k);
				}
			});
		}
		return arr.join(',');
	}
});


/*
	Include Path
*/
App.filter('include_path', function($rootScope) {
	return function(v) {
		return '/assets/templates/includes/'+v+'.html?v='+assets_ver;
	}
});

/*
	Trusted html content
*/
App.filter('trusted', function($sce){
	return function(html){
		return $sce.trustAsHtml(html)
	}
})
