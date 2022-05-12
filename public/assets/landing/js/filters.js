/*
  filters.js requires all filters
	prepareFilterDate
	dateF
	price
	capitalize
	trusted
	random
	filter_lists
	url
	filesize
	lang
	lang_prop
*/
/* Prepare Filter Date */
App.filter('prepareFilterDate', function($filter) {
	return function(val) {
		var sdate = '',edate = '';
		var df = 'YYYY-MM-DD';
		switch (val) {
			case 'today':
				sdate = moment().format(df);
				edate = moment().format(df);
			break;
			case 'yesterday':
				sdate = moment().subtract(1, 'day').format(df);
				edate = moment().subtract(1, 'day').format(df);
			break;
			case 'tomorrow':
				sdate = moment().startOf('day').add(1, 'day').format(df);
				edate = moment().startOf('day').add(1, 'day').format(df);
			break;
			case 'thisweek':
			sdate = moment().startOf('isoWeek').format(df);
			edate = moment().endOf('isoWeek').format(df);
			break;
			case 'lastweek':
			sdate = moment().subtract(1, 'weeks').startOf('isoWeek').format(df);
			edate = moment().subtract(1, 'weeks').endOf('isoWeek').format(df);
			break;
			case 'nextweek':
			sdate = moment().add(1, 'weeks').startOf('isoWeek').format(df);
			edate = moment().add(1, 'weeks').endOf('isoWeek').format(df);
			break;
			case 'thismonth':
			sdate = moment().startOf('month').format(df);
			edate = moment().endOf('month').format(df);
			break;
			case 'nextmonth':
			sdate = moment().add(1, 'months').startOf('month').format(df);
			edate = moment().add(1, 'months').endOf('month').format(df);
			break;
			case 'lastmonth':
			sdate = moment().subtract(1, 'months').startOf('month').format(df);
			edate = moment().subtract(1, 'months').endOf('month').format(df);
			break;
			case 'thisquarter':
			sdate = moment().startOf('quarter').format(df);
			edate = moment().endOf('quarter').format(df);
			break;
			case 'lastquarter':
			sdate = moment().subtract(1, 'quarters').startOf('quarter').format(df);
			edate = moment().subtract(1, 'quarters').endOf('quarter').format(df);
			break;
			case 'thisyear':
			sdate = moment().startOf('year').format(df);
			edate = moment().endOf('year').format(df);
			break;
			case 'lastyear':
			sdate = moment().subtract(1, 'years').startOf('year').format(df);
			edate = moment().subtract(1, 'years').endOf('year').format(df);
			break;
			case 'expired':
				sdate = '';
				edate = moment().subtract(1, 'days').format(df);
			break;
		}

		// prepare filter dates
		if (val == 'all') {
			return {start_date: '',end_date: ''};
		} else {
			return {start_date: sdate,end_date: edate}
		}
	}
});
App.filter('dateF', function($filter) {
	return function(dateSTR,v) {
		if(dateSTR){
			if(angular.isString(dateSTR) && dateSTR.length == 10){
				return $filter('date')(new Date(dateSTR),'yyyy/MM/dd');
			}else {
				var o = (angular.isString(dateSTR)) ? dateSTR.replace(/-/g, "/") : dateSTR;
				v = (angular.isUndefined(v)) ? 'yyyy/MM/dd' : v;
				return $filter('date')(Date.parse(o + " -0000"),v,'+0000');
			}
			}else {
			return '';
		}
	}
});
App.filter('dateTimeF', function($filter) {
	return function(dateSTR,v) {
		if(dateSTR){
			if(angular.isString(dateSTR) && dateSTR.length == 10){
				return $filter('date')(new Date(dateSTR),'yyyy/MM/dd');
			}else {
				var o = (angular.isString(dateSTR)) ? dateSTR.replace(/-/g, "/") : dateSTR;
				v = (angular.isUndefined(v)) ? 'yyyy/MM/dd HH:mm' : v;
				return $filter('date')(Date.parse(o + " -0000"),v,'+0000');
			}
			}else {
			return '';
		}
	}
});
App.filter('price', function($filter) {
	return function(v,without_currency) {
		if(angular.isUndefined(v)){
			return 0;
		}else {
			let decimal = (v % 1 != 0) ? 2 : 0;
			return $filter('currency')(v, '', decimal) + ((without_currency) ? '' : ' ر.س');
		}
	}
});

App.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});

App.filter('trusted', function($sce){
	return function(html){
		return $sce.trustAsHtml(html)
	}
});

App.filter('random', function(){
	return function(v){
		min = 11111111;
    max = 99999999;
    return Math.floor(Math.random() * (max - min + 1)) + max;
	}
});

App.filter('filter_lists', function($sce,$filter){
	return function(list_type){
		var l = [];
		switch (list_type) {
			case 'dates':
				l = [
					{
						key: 'all',
						label: $filter('lang')('all_times')
					}, {
						key: 'today',
						label: $filter('lang')('today')
					}, {
						key: 'yesterday',
						label: $filter('lang')('yesterday')
					}
				];
			break;
			case 'towns':
				l = window.towns_list;
			break;

		}
		return l;
	}
});


/**
	* Provide us a full url of assets path
	* so when we use it just by code like this 'example.png' | asset: 'image'
	* then the result with show us a full url for example 'domain.com/assets/images/example.png'
	* so shortly it helps us to don't write a full url in View Templates
*/
App.filter('url', function () {
	return function(v,type){
		var r = v,
				prefix = 'assets/';
		switch (type) {
			case 'image':
				prefix += 'images/';
			break;
			case 'uploads':
				prefix = 'uploads/';
			break;
		}
		return baseUrl+'/'+prefix+r+((type != 'uploads') ? '?v='+assets_ver : '');
	}
});


/**
	* File size
*/
App.filter('filesize', function(Helpers){
	return function(v){
		return Helpers.formatFilesize(v);
	}
});

/**
	* Lang translation
*/
App.filter('lang', function() {
	return function(v) {
		var parts = v.split( "." ),
			length = parts.length,
			i,
			property = window.lang || this;
		for ( i = 0; i < length; i++ ) {
			property = property[parts[i]];
		}
		return property;
	}
});


/**
 * Lists
 */
App.filter('lists', function () {
	return function (type) {
		let result = [];
		switch(type){
			case 'banks':
				result = [
					{
						id: 1,
						name: 'مصرف الراجحي'
					},
					{
						id: 2,
						name: 'بنك الراجحي'
					},
					{
						id: 3,
						name: 'البنك العربي'
					},
					{
						id: 4,
						name: 'البنك الأول'
					},
					{
						id: 5,
						name: 'البنك السعودي الفرنسي'
					},
					{
						id: 6,
						name: 'بنك الإنماء'
					},
					{
						id: 7,
						name: 'بنك البلاد'
					},
					{
						id: 8,
						name: 'بنك الجزيرة'
					},
					{
						id: 9,
						name: 'بنك الخليج الدولي / ميم'
					},
					{
						id: 10,
						name: 'البنك الأهلي التجاري'
					},
					{
						id: 11,
						name: 'بنك ساب'
					},
					{
						id: 12,
						name: 'البنك السعودي للاستثمار'
					},
					{
						id: 13,
						name: 'بنك سامبا'
					}
				];
			break;
		}
		return result;
	}
});