/*
directives.js requires all angularjs directives

echarts
maskInput
ngEnter
ngFocus
ngLoading
usersRolesList
findactivetab
niceScroll
customersList
merchantsList
adminsList
leadsMerchantsCategoriesList
categoriesList
brandsList
citiesList
townsList
dateList
uploadImage
switch
moneyInput
numericInput
phoneInput
*/
/* Echarts */
echarts.registerTheme('App',{
  color: ['#FF003F', '#16b7c7', '#42e6ba', '#f0932b', '#f9ca24', '#95afc0', '#ff7979', '#30336b', '#6ab04c', '#badc58'],
  tooltip: {
    textStyle: {
      fontFamily: 'Janna LT',
      fontSize: '14px',
      color: 'initial'
    }
  },
  valueAxis: {
    axisLine: {
      lineStyle: {
        color: ['#C4C7CC']
      }
    },
    axisLabel: {
      color: '#313233'
    },
    splitArea : {
      show: false
    },
    splitLine: {
      lineStyle: {
        color: ['#DDE0E6']
      }
    }
  },
  categoryAxis: {
    axisLine: {
      lineStyle: {
        color: ['#C4C7CC']
      }
    },
    axisLabel: {
      color: '#313233'
    },
    splitArea : {
      show: false
    },
    splitLine: {
      lineStyle: {
        color: ['#DDE0E6']
      }
    }
  }

});
App.directive('echarts', function($window,$timeout) {
  return {
    restrict: 'EA',
    scope: {
      options: '=options',
      events: '=events'
    },
    link: function(scope, ele, attrs) {
      if(attrs.initLoader){
        ele.wrap('<div class="echart-init"></div>');
      }
      var chart, options, chartEvent = [];
      chart = echarts.init(ele[0],'App');

      function createChart(options) {
        if (!options) return;

        chart.setOption(options);
        $timeout(function(){
          chart.resize();
        },1);
        angular.element($window).bind('resize', function() {
          chart.resize();
        });

      }

      scope.$watch('options', function(newVal, oldVal) {
        var options = {
          animation: true
        };
        if (scope.options) {
          options = angular.merge(scope.options,options);
        }
        
        createChart(options);
        $timeout(function(){
          chart.resize();
          if(attrs.initLoader){
            ele.closest('.echart-init').addClass('active');
          }
        },1000);
      },true);

      scope.$watch('events', function(newVal, oldVal) {
        if (scope.events) {
          if (Array.isArray(scope.events)) {
            scope.events.forEach(function(ele) {
              if (!chartEvent[ele.type]) {
                $timeout(function(){
                  chartEvent[ele.type] = true;
                  chart.on(ele.type, function(param) {
                    ele.fn(param);
                    scope.$apply();
                  });
                },1);
              }
            });
          }
        }
      });
    }
  };
});

App.directive('maskInput', function() {
  return {
    require: 'ngModel',
    scope: {
      maskOptions: '='
    },
    link: function($scope, element, attrs, ngModelCtrl) {
      $scope.maskOptions = (angular.isObject($scope.maskOptions)) ? $scope.maskOptions : {};
      element.mask(attrs.maskInput,$scope.maskOptions);
      ngModelCtrl.$parsers.unshift(function(value) {
        return element.cleanVal();
      });
      ngModelCtrl.$formatters.unshift(function(value) {
        return element.masked(value);
      });
    }
  };
});

App.directive('ngEnter', function() {
  return function(scope, element, attrs) {
    element.bind("keydown keypress", function(event) {
      if(event.which === 13) {
        scope.$apply(function(){
          scope.$eval(attrs.ngEnter, {'event': event});
        });

        event.preventDefault();
      }
    });
  };
});
App.directive('ngFocus', function($timeout) {
  return {
    link: function ( scope, element, attrs ) {
      scope.$watch( attrs.ngFocus, function ( val ) {
        if ( angular.isDefined( val ) && val ) {
          $timeout( function () { element[0].focus(); } );
        }
      }, true);

      element.bind('blur', function () {
        if ( angular.isDefined( attrs.ngFocusLost ) ) {
          scope.$apply( attrs.ngFocusLost );

        }
      });
    }
  };
});
App.directive('ngLoading', function() {
  return {
    link: function($scope,$e,$a) {
      $scope.$watch($a.ngLoading, function (n,o) {
        // Btn loader
        if ($e.hasClass('btn')) {
          var loader_class = 'circle-loader';
          var btn_loading_class = 'btn-loading';
          if($a.ngLoadingPosition){
            btn_loading_class += ' btn-loading-'+$a.ngLoadingPosition;
          }
          if (n) {
            $e.addClass(btn_loading_class);
          }
          if (!$e.find('.dot-loader').length && n) {
            $e.append('<span class="'+loader_class+((!n) ? ' d-none' : '')+'"></span>');
          }else {
            if (n) {
              $e.find('.'+loader_class).removeClass('d-none');
            }else {
              $e.find('.'+loader_class).addClass('d-none');
            }
          }
          if(!n) {
            $e.removeClass(btn_loading_class);
          }
        }
      },true);
    }
  };
});

App.directive('usersRolesList', function (API) {
  return {
    template: '<ui-select search-enabled="false" ng-click="getList(null,true)" ng-required="required" ng-class="{\'loading\': isListLoading}" on-select="onChange()" append-to-body="{{ appendToBody }}" search-enabled="false" ng-model="parent[model]"><ui-select-match placeholder="اختر الدور">{{ $select.selected.name }}</ui-select-match><ui-select-choices repeat="item.id as item in list" refresh="getList($select.search)" refresh-delay="300"><div ng-class="{\'font-weight-bold\': item.email}" ng-bind-html="item.name | highlight: $select.search"></div><div class="text-muted small text-truncate mt-1 d-flex align-items-center" ng-show="item.email"><i class="ic-email ml-2"></i>{{ item.email }}</div></ui-select-choices></ui-select>',
    scope: {
      allOption: '=',
      parent: '=',
      appendToBody: '=',
      required: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      var allItem = {
        id: 'all',
        name: 'الكل',
        email: null
      };
      $scope.list = [];
      if($scope.allOption){
        $scope.list.push(allItem);
      }
      $scope.isListInitiated = false;
      $scope.getList = function (searchValue, isInit) {
        if (searchValue || isInit && !$scope.isListInitiated) {
          if (isInit && $scope.parent[$a.model] && $scope.parent[$a.model] != 'all') {
            $scope.parent[$a.model] = parseInt($scope.parent[$a.model]);
          }
          $scope.isListInitiated = true;
          $scope.isListLoading = true;
          let searchJson = {
            search: searchValue,
          };
          if (isInit && $scope.parent[$a.model]) {
            searchJson.user_id = $scope.parent[$a.model];
          }
          if($a.type){
            searchJson.type = $a.type;
          }
          API.GET('helpers/list/users-roles', searchJson).then(function (r) {
            $scope.isListLoading = false;
            $scope.list = r.data.data;
            if ($scope.allOption) {
              $scope.list.unshift(allItem);
            }
          }, function (r) {
            $scope.isListLoading = false;
            $scope.isListFailed = true;
          });
        }
      };

      $scope.$watch($scope.parent[$a.model], function(newVal, oldVal) {
        if (newVal && newVal != 'all' || $a.model == 'id') {
          $scope.getList('',true);
        }
      },true);
    }
  };
});

App.directive('findactivetab', ['$location', '$rootScope',
  function ($location, $rootScope) {
    return {
      scope: {
        onReload: '='
      },
      link: function postLink($scope, element, attrs) {
        $scope.initActiveLink = function(){
          var pathToCheck = $location.path().split('/')[attrs.findactivetab] || "current $location.path doesn't reach this level";
          angular.forEach(element.children().not('.' + element.attr('expect-class')), function (item) {
            var a = $(item).children('li > a'),
              parent = (typeof a.attr('href') !== undefined) ? a.attr('href') : a.attr('data-href');
            if (parent != undefined && pathToCheck == parent.split('/')[attrs.findactivetab]) {
              $(item).addClass('active');
            } else {
              $(item).removeClass('active');
            }
          });
        };

         $rootScope.$on('$locationChangeStart', function () {
           $scope.initActiveLink();
        });

        $scope.$watch('onReload',function(){
          $scope.initActiveLink();
        });

        
      }
    };
  }
]);

App.directive('niceScroll', function ($timeout) {
  return function (scope, element, attrs) {
    $(element).niceScroll({
      cursorcolor: '#dfe5eb',
      railalign: 'left'
    });
  };
});

App.directive('customersList', function (API) {
  return {
    template: '<ui-select search-enabled="true" ng-required="required" ng-class="{\'loading\': isListLoading}" on-select="onChange()" append-to-body="{{ appendToBody }}" search-enabled="false" ng-model="parent[model]"><ui-select-match placeholder="ابحث في العملاء">{{ $select.selected.name }}</ui-select-match><ui-select-choices repeat="item.id as item in list" refresh="getList($select.search)" refresh-delay="300"><div ng-class="{\'font-weight-bold\': item.email}" ng-bind-html="item.name | highlight: $select.search"></div><div class="text-muted small text-truncate mt-1 d-flex align-items-center" ng-show="item.email"><i class="ic-email ml-2"></i>{{ item.email }}</div></ui-select-choices></ui-select>',
    scope: {
      allOption: '=',
      parent: '=',
      appendToBody: '=',
      required: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      var allItem = {
        id: 'all',
        name: 'الكل',
        email: null
      };
      $scope.list = [];
      if($scope.allOption){
        $scope.list.push(allItem);
      }
      $scope.isListInitiated = false;
      $scope.getList = function (searchValue, isInit) {
        if (searchValue || isInit && !$scope.isListInitiated) {
          if (isInit && $scope.parent[$a.model] && $scope.parent[$a.model] != 'all') {
            $scope.parent[$a.model] = parseInt($scope.parent[$a.model]);
          }
          $scope.isListInitiated = true;
          $scope.isListLoading = true;
          let searchJson = {
            search: searchValue,
          };
          if (isInit && $scope.parent[$a.model]) {
            searchJson.user_id = $scope.parent[$a.model];
          }
          API.GET('helpers/list/customers', searchJson).then(function (r) {
            $scope.isListLoading = false;
            $scope.list = r.data.data;
            if ($scope.allOption) {
              $scope.list.unshift(allItem);
            }
          }, function (r) {
            $scope.isListLoading = false;
            $scope.isListFailed = true;
          });
        }
      };

      $scope.$watch($scope.parent[$a.model], function(newVal, oldVal) {
        if (newVal && newVal != 'all' || $a.model == 'id') {
          $scope.getList('',true);
        }
      },true);
    }
  };
});

App.directive('merchantsList', function (API) {
  return {
    template: '<ui-select search-enabled="true" ng-required="required" ng-class="{\'loading\': isListLoading}" on-select="onChange()" append-to-body="{{ appendToBody }}" search-enabled="false" ng-model="parent[model]"><ui-select-match placeholder="ابحث في المتاجر">{{ $select.selected.name }}</ui-select-match><ui-select-choices repeat="item.id as item in list" refresh="getList($select.search)" refresh-delay="300"><div ng-class="{\'font-weight-bold\': item.email}" ng-bind-html="item.name | highlight: $select.search"></div><div class="text-muted small text-truncate mt-1 d-flex align-items-center" ng-show="item.email"><i class="ic-email ml-2"></i>{{ item.email }}</div></ui-select-choices></ui-select>',
    scope: {
      allOption: '=',
      parent: '=',
      appendToBody: '=',
      required: '=',
      allOption: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      var allItem = {
        id: 'all',
        name: 'الكل',
        email: null
      };
      $scope.list = [];
      if($scope.allOption){
        $scope.list.push(allItem);
      }
      $scope.isListInitiated = false;
      $scope.getList = function (searchValue, isInit) {
        if (searchValue || isInit && !$scope.isListInitiated) {
          if (isInit && $scope.parent[$a.model] && $scope.parent[$a.model] != 'all') {
            $scope.parent[$a.model] = parseInt($scope.parent[$a.model]);
          }
          $scope.isListInitiated = true;
          $scope.isListLoading = true;
          let searchJson = {
            search: searchValue,
          };
          if (isInit && $scope.parent[$a.model]) {
            searchJson.user_id = $scope.parent[$a.model];
          }
          API.GET('helpers/list/merchants', searchJson).then(function (r) {
            $scope.isListLoading = false;
            $scope.list = r.data.data;
            if ($scope.allOption) {
              $scope.list.unshift(allItem);
            }
          }, function (r) {
            $scope.isListLoading = false;
            $scope.isListFailed = true;
          });
        }
      };

      $scope.$watch($scope.parent[$a.model], function(newVal, oldVal) {
        if (newVal && newVal != 'all' || $a.model == 'id') {
          $scope.getList('',true);
        }
      },true);
    }
  };
});

App.directive('adminsList', function (API) {
  return {
    template: '<ui-select search-enabled="true" ng-required="required" ng-click="getList(null,true)" ng-class="{\'loading\': isListLoading}" on-select="onChange()" append-to-body="{{ appendToBody }}" search-enabled="false" ng-model="parent[model]"><ui-select-match placeholder="ابحث في المدراء">{{ $select.selected.name }}</ui-select-match><ui-select-choices repeat="item.id as item in list" refresh="getList($select.search)" refresh-delay="300"><div ng-class="{\'font-weight-bold\': item.email}" ng-bind-html="item.name | highlight: $select.search"></div><div class="text-muted small text-truncate mt-1 d-flex align-items-center" ng-show="item.email"><i class="ic-email ml-2"></i>{{ item.email }}</div></ui-select-choices></ui-select>',
    scope: {
      allOption: '=',
      parent: '=',
      appendToBody: '=',
      required: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      var allItem = {
        id: 'all',
        name: 'الكل',
        email: null
      };
      $scope.list = [];
      if($a.allOption){
        $scope.list.push(allItem);
      }
      $scope.isListInitiated = false;
      $scope.getList = function (searchValue, isInit) {
        if (searchValue || isInit && !$scope.isListInitiated) {
          if (isInit && $scope.parent[$a.model] && $scope.parent[$a.model] != 'all') {
            $scope.parent[$a.model] = parseInt($scope.parent[$a.model]);
          }
          $scope.isListInitiated = true;
          $scope.isListLoading = true;
          let searchJson = {
            search: searchValue,
          };
          if (isInit && $scope.parent[$a.model]) {
            searchJson.admin_id = $scope.parent[$a.model];
          }
          API.GET('helpers/list/admins', searchJson).then(function (r) {
            $scope.isListLoading = false;
            $scope.list = r.data.data;
            if ($scope.allOption) {
              $scope.list.unshift(allItem);
            }
          }, function (r) {
            $scope.isListLoading = false;
            $scope.isListFailed = true;
          });
        }
      };

      $scope.$watch($scope.parent[$a.model], function(newVal, oldVal) {
        if (newVal && newVal != 'all' || $a.model == 'id') {
          $scope.getList('',true);
        }
      },true);
    }
  };
});

App.directive('leadsMerchantsCategoriesList', function (API,$rootScope) {
  return {
    template: '<ui-select search-enabled="false" ng-required="required" ng-class="{\'loading\': isListLoading}" on-select="onChange()" append-to-body="{{ appendToBody }}" search-enabled="false" ng-model="parent[model]"><ui-select-match placeholder="أبحث في التصنيفات">{{ $select.selected.name }}</ui-select-match><ui-select-choices repeat="item.name as item in $root.leadsMerchantsCategoriesList | filter: $select.search"><div ng-bind-html="item.name | highlight: $select.search"></div></ui-select-choices></ui-select>',
    scope: {
      allOption: '=',
      parent: '=',
      appendToBody: '=',
      required: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      var allItem = {
        name: 'الكل'
      };
      $scope.getList = function () {
        if (!$rootScope.leadsMerchantsCategoriesList) {
          $scope.isListLoading = true;
          API.GET('helpers/list/leads-merchants-categories').then(function (r) {
            $scope.isListLoading = false;
            $rootScope.leadsMerchantsCategoriesList = r.data.data;
            if ($scope.allOption) {
              $rootScope.leadsMerchantsCategoriesList.unshift(allItem);
            }
          }, function (r) {
            $scope.isListLoading = false;
            $scope.isListFailed = true;
          });
        }
      };

      $scope.getList(true);
    }
  };
});

App.directive('categoriesList', function (API) {
  return {
    template: `
    <ui-select search-enabled="true" ng-required="required" ng-class="{'loading': isListLoading}" on-select="onChange()" append-to-body="{{ appendToBody }}" ng-model="parent[model]">
      <ui-select-match placeholder="أبحث عن تصنيف">{{ $select.selected.name }}</ui-select-match>
      <ui-select-choices repeat="item.id as item in list | filter: $select.search" refresh="getList($select.search)" refresh-delay="300"><div ng-bind-html="item.name | highlight: $select.search"></div><div class="text-muted small mt-1 text-truncate" ng-bind="item.breadcrumbText"></div></ui-select-choices>
    </ui-select>`,
    scope: {
      allOption: '=',
      parent: '=',
      appendToBody: '=',
      required: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      var allItem = {
        id: 'all',
        name: 'الكل'
      };
      $scope.list = [];
      if($scope.allOption){
        $scope.list.push(allItem);
      }
      $scope.isListInitiated = false;
      $scope.getList = function (searchValue, isInit) {
        if (searchValue || isInit && !$scope.isListInitiated) {
          if (isInit && $scope.parent[$a.model] && $scope.parent[$a.model] != 'all') {
            $scope.parent[$a.model] = parseInt($scope.parent[$a.model]);
          }
          $scope.isListInitiated = true;
          $scope.isListLoading = true;
          let searchJson = {
            search: searchValue,
          };
          API.GET('helpers/list/categories', searchJson).then(function (r) {
            $scope.isListLoading = false;
            $scope.list = r.data.data;
            if ($scope.allOption) {
              $scope.list.unshift(allItem);
            }
          }, function (r) {
            $scope.isListLoading = false;
            $scope.isListFailed = true;
          });
        }
      };

      $scope.$watch('parent.'+$a.model,function(newVal){
        if(newVal && newVal != 'all'){
          $scope.getList(null,true);
        }
      });
    }
  };
});


App.directive('brandsList', function (API) {
  return {
    template: `
    <ui-select search-enabled="true" ng-required="required" ng-class="{'loading': isListLoading}" on-select="onChange()" append-to-body="{{ appendToBody }}" ng-model="parent[model]">
      <ui-select-match placeholder="ابحث العلامة التجارية">{{ $select.selected.name }}</ui-select-match>
      <ui-select-choices repeat="item.id as item in list | filter: $select.search" refresh="getList($select.search)" refresh-delay="300"><div ng-bind-html="item.name | highlight: $select.search"></div></ui-select-choices>
    </ui-select>`,
    scope: {
      allOption: '=',
      parent: '=',
      appendToBody: '=',
      required: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      var allItem = {
        id: 'all',
        name: 'الكل'
      };
      $scope.list = [];
      if($scope.allOption){
        $scope.list.push(allItem);
      }
      $scope.isListInitiated = false;
      $scope.getList = function (searchValue, isInit) {
        if (searchValue || isInit && !$scope.isListInitiated) {
          if (isInit && $scope.parent[$a.model] && $scope.parent[$a.model] != 'all') {
            $scope.parent[$a.model] = parseInt($scope.parent[$a.model]);
          }
          $scope.isListInitiated = true;
          $scope.isListLoading = true;
          let searchJson = {
            search: searchValue,
          };
          API.GET('helpers/list/brands', searchJson).then(function (r) {
            $scope.isListLoading = false;
            $scope.list = r.data.data;
            if ($scope.allOption) {
              $scope.list.unshift(allItem);
            }
          }, function (r) {
            $scope.isListLoading = false;
            $scope.isListFailed = true;
          });
        }
      };

      $scope.$watch('parent.'+$a.model,function(newVal){
        if(newVal && newVal != 'all'){
          $scope.getList(null,true);
        }
      });
    }
  };
});


App.directive('citiesList', function (API) {
  return {
    template: `
    <ui-select search-enabled="true" ng-required="required" ng-class="{'loading': isListLoading}" ng-click="getList(null,true)" on-select="onChange()" append-to-body="{{ appendToBody }}" ng-model="parent[model]">
      <ui-select-match placeholder="أختر المدينة">{{ $select.selected.name }}</ui-select-match>
      <ui-select-choices repeat="item.id as item in list | filter: $select.search"><div ng-bind-html="item.name | highlight: $select.search"></div></ui-select-choices>
    </ui-select>`,
    scope: {
      allOption: '=',
      parent: '=',
      appendToBody: '=',
      required: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      var allItem = {
        id: 'all',
        name: 'الكل'
      };
      $scope.list = [];
      if($scope.allOption){
        $scope.list.push(allItem);
      }
      $scope.isListInitiated = false;
      $scope.getList = function (searchValue, isInit) {
        if (searchValue || isInit && !$scope.isListInitiated) {
          if (isInit && $scope.parent[$a.model] && $scope.parent[$a.model] != 'all') {
            $scope.parent[$a.model] = parseInt($scope.parent[$a.model]);
          }
          $scope.isListInitiated = true;
          $scope.isListLoading = true;
          let searchJson = {
            search: searchValue,
          };
          API.GET('helpers/list/cities', searchJson).then(function (r) {
            $scope.isListLoading = false;
            $scope.list = r.data.data;
            if ($scope.allOption) {
              $scope.list.unshift(allItem);
            }
          }, function (r) {
            $scope.isListLoading = false;
            $scope.isListFailed = true;
          });
        }
      };

      $scope.$watch('parent.'+$a.model,function(newVal){
        if(newVal && newVal != 'all'){
          $scope.getList(null,true);
        }
      });
    }
  };
});

App.directive('provincesList', function (API) {
  return {
    template: `
    <ui-select search-enabled="true" ng-required="required" ng-class="{'loading': isListLoading}" on-select="onChange()" append-to-body="{{ appendToBody }}" ng-model="parent[model]">
      <ui-select-match placeholder="أختر المنطقة">{{ $select.selected.name }}</ui-select-match>
      <ui-select-choices repeat="item.name as item in list | filter: $select.search"><div ng-bind-html="item.name | highlight: $select.search"></div></ui-select-choices>
    </ui-select>`,
    scope: {
      allOption: '=',
      parent: '=',
      appendToBody: '=',
      required: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      var allItem = {
        key: 'all',
        name: 'الكل'
      };
      $scope.list = [{"name":"منطقة الباحة"},{"name":"منطقة الجوف"},{"name":"منطقة الحدود الشمالية"},{"name":"منطقة الرياض"},{"name":"منطقة الشرقية"},{"name":"منطقة القصيم"},{"name":"منطقة المدينة المنورة"},{"name":"منطقة تبوك"},{"name":"منطقة جازان"},{"name":"منطقة حائل"},{"name":"منطقة عسير"},{"name":"منطقة مكة المكرمة"},{"name":"منطقة نجران"}];
      if($scope.allOption){
        $scope.list.push(allItem);
      }
    }
  };
});


App.directive('townsList', function (API) {
  return {
    template: '<ui-select search-enabled="true" tooltip-append-to-body="true" uib-tooltip="{{ (isHasCity && (!city || city == \'all\')) ? \'اختر مدينة أولاً\' : \'\' }}" ng-disabled="!isHasCity || (!city || city == \'all\')" ng-required="required" ng-class="{\'loading\': isListLoading}" ng-click="getList(null,true)" on-select="onChange()" append-to-body="{{ appendToBody }}" ng-model="parent[model]"><ui-select-match placeholder="أختر الحي">{{ $select.selected.name }}</ui-select-match><ui-select-choices repeat="item.id as item in list" refresh="getList($select.search)" refresh-delay="300"><div ng-bind-html="item.name"></div></ui-select-choices></ui-select>',
    scope: {
      allOption: '=',
      parent: '=',
      isHasCity: '=',
      city: '=',
      appendToBody: '=',
      required: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      var allItem = {
        id: 'all',
        name: 'الكل'
      };
      $scope.list = [];
      if($scope.allOption){
        $scope.list.push(allItem);
      }
      $scope.isListInitiated = false;
      $scope.getList = function (searchValue, isInit) {
        if ((searchValue || isInit && !$scope.isListInitiated) && (!$scope.isHasCity || ($scope.city && $scope.city != 'all'))) {
          if (isInit && $scope.parent[$a.model] && $scope.parent[$a.model] != 'all') {
            $scope.parent[$a.model] = parseInt($scope.parent[$a.model]);
          }
          $scope.isListInitiated = true;
          $scope.isListLoading = true;
          let searchJson = {
            search: searchValue,
          };
          if($scope.city){
            searchJson.city_id = $scope.city;
          }
          API.GET('helpers/list/towns', searchJson).then(function (r) {
            $scope.isListLoading = false;
            $scope.list = r.data.data;
            if ($scope.allOption) {
              $scope.list.unshift(allItem);
            }
          }, function (r) {
            $scope.isListLoading = false;
            $scope.isListFailed = true;
          });
        }
      };

      $scope.$watch('city',function(newVal,oldVal){
        if(newVal && newVal != 'all' && oldVal && newVal != oldVal){
          $scope.isListInitiated = false;
          $scope.parent[$a.model] = null;
          $scope.getList(null,true);
        }
      });

      $scope.$watch('parent.'+$a.model,function(newVal){
        if(newVal && newVal != 'all'){
          $scope.getList(null,true);
        }
      });
    }
  };
});

App.directive('dateList', function (API) {
  return {
    template: `<div><ui-select ng-required="required" on-select="onChange()" append-to-body="{{ appendToBody }}" search-enabled="false" ng-model="parent[model]"><ui-select-match placeholder="أختر">{{ $select.selected.name }}</ui-select-match><ui-select-choices repeat="item.key as item in list"><div ng-bind-html="item.name"></div></ui-select-choices></ui-select></div>
    <div class="mt-3" ng-show="parent[model] == 'custom'">
    <div class="mb-2"><input type="text" class="form-control" date-input placeholder="تاريخ الابتداء" ng-model-options="{timezone: 'utc'}" ng-class="{'focus': isOpen['open_'+model+'_start_date']}" close-on-date-selection="true" uib-datepicker-popup="dd/MM/y" ng-click="isOpen['open_'+model+'_start_date'] = !isOpen['open_'+model+'_start_date']" ng-model="parent['custom_'+model+'_start_date']" is-open="isOpen['open_'+model+'_start_date']" /></div>
    <input type="text" class="form-control" date-input placeholder="تاريخ الانتهاء" ng-model-options="{timezone: 'utc'}" ng-class="{'focus': isOpen['open_'+model+'_end_date']}" close-on-date-selection="true" uib-datepicker-popup="dd/MM/y" ng-click="isOpen['open_'+model+'_end_date'] = !isOpen['open_'+model+'_end_date']" ng-model="parent['custom_'+model+'_end_date']" is-open="isOpen['open_'+model+'_end_date']" />
    </div>
    `,
    scope: {
      allOption: '=',
      isNext: '=',
      parent: '=',
      appendToBody: '=',
      required: '=',
      onChange: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.model = $a.model;
      if ($scope.isNext) {
        $scope.list = [{
          key: 'today',
          name: 'اليوم'
        },
        {
          key: 'tomorrow',
          name: 'غداً'
        }
        , {
          key: 'thisweek',
          name: 'هذا الاسبوع'
        }, {
          key: 'nextweek',
          name: 'الاسبوع القادم'
        }, {
          key: 'thismonth',
          name: 'هذا الشهر'
        }, {
          key: 'nextmonth',
          name: 'الشهر القادم'
        }, {
          key: 'thisyear',
          name: 'هذه السنة'
        }, {
          key: 'custom',
          name: 'تحديد بين تاريخين'
        }];
      }else {
        $scope.list = [{
          key: 'today',
          name: 'اليوم'
        }, {
          key: 'yesterday',
          name: 'أمس'
        }, {
          key: 'thisweek',
          name: 'هذا الاسبوع'
        }, {
          key: 'lastweek',
          name: 'الاسبوع الماضي'
        }, {
          key: 'thismonth',
          name: 'هذا الشهر'
        }, {
          key: 'lastmonth',
          name: 'الشهر الماضي'
        }, {
          key: 'thisyear',
          name: 'هذه السنة'
        }, {
          key: 'lastyear',
          name: 'السنة الماضية'
        }, {
          key: 'custom',
          name: 'تحديد بين تاريخين'
        }];
      }
      var allItem = {
        key: 'all',
        name: 'الكل'
      };
      if ($scope.allOption) {
        $scope.list.unshift(allItem);
      }
      $scope.$watch($scope.parent, function (newVal, oldVal) {
        if (newVal && newVal != 'all') {
        }
      },true);
      $scope.isListInitiated = false;
    }
  };
});

App.directive('uploadFile', function (Helpers) {
  return {
    template: `
      <ng-dropzone ng-if="true" ng-show="isEdit" class="dropzone" options="dropzone.dzOptions" callbacks="dropzone.dzCallbacks" methods="dropzone.dzMethods"></ng-dropzone>
      <div class="dropzone" ng-show="!isEdit">
        <div class="dz-preview">
        <div class="dz-image mx-auto" ng-if="isFile">
        <div class="img-icon d-flex justify-content-center align-items-center"><img src="${baseUrl}/assets/images/svg/file.svg" alt="" /></div>
      </div>
      <div class="dz-image" ng-if="!isFile">
      <img ng-src="{{ parent[full_path] }}" alt="" />
    </div>
    <div class="ltr mb-2 text-muted" ng-if="fileName" ng-bind="fileName"></div>
          <div class="mt-1">
            <a ng-click="change()" class="btn btn-light mr-1 btn-icon btn-sm"><i class="ic-edit"></i></a>
          </div>
        </div>
      </div>
    `,
    scope: {
      parent: '=',
      required: '=',
      onSuccess: '&'
    },
    link: function ($scope, $e, $a) {
      $scope.isFile = $a.isFile;
      $scope.full_path = $a.fullPath;
      $scope.fileName = '';
      $scope.model = $a.model;
      $scope.dropzone = {
          dzCallbacks: {
              'success' : function(file,xhr){
                  $scope.parent[$scope.model] = xhr.data.path;
                  $scope.parent[$scope.full_path] = xhr.data.full_path;
                  if($scope.isFile){
                    $scope.parent['filename'] = file.name;
                    $scope.fileName = file.name;
                  }
                  $scope.onSuccess(file,xhr);
              }
          },
          dzMethods: {},
          dzOptions: Helpers.prepareDropzoneOptions($a.path,
            '<div class="img-icon d-flex justify-content-center align-items-center"><img src="'+baseUrl+'/assets/images/svg/upload-file.svg" alt="" /></div><b class="img-upload">'+(($a.label) ? $a.label : 'أرفع صورة')+'</b>',
            "image/*,application/pdf,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",null
            )
      };

      $scope.change = function(){

        $scope.oldData = {
          image: angular.copy($scope.parent[$scope.model]),
          full_path: angular.copy($scope.parent[$scope.full_path])
        };
        $scope.dropzone.dzMethods.removeAllFiles(true);
        $scope.isEdit = true;
      };

      $scope.resetChange = function(){
        $scope.isEdit = false;
        $scope.parent[$scope.model] = angular.copy($scope.oldData.image);
        $scope.parent[$scope.full_path] = angular.copy($scope.oldData.full_path);
      };

      $scope.$watch('parent.'+$a.model,function(newVal){
        if(newVal){
          $scope.isEdit = false;
        }else {
          $scope.isEdit = true;
        }
      });
    }
  };
});



App.directive('switch', function () {
  return {
    restrict: 'AE',
    replace: true,
    link: function (s, e, a) {
      $(e).wrap('<label class="ui-switch"></label>').after('<span class="ui-switch-slider round"></span>');
    }
  };
});

App.directive('moneyInput', function($filter,$timeout) {
  return {
    scope: {
      model: '=ngModel'
    },
    require: 'ngModel',
    link: function(scope, el,$attr,ngModel) {

      scope.removeEmptyClass = function(){
        if($(el).hasClass('ng-empty')){
          $(el).removeClass('ng-empty');
        }
      };

      // 1: prevent non-numeric value
      $(el).on("keypress", function (evt) {
          if (evt.which < 48 || evt.which > 57)
          {
              evt.preventDefault();
          }
      })
      // 2: select all text on focus
      .focus(function(){
        $(this).on("click.a keyup.a", function(e){
            $(this).off("click.a keyup.a").select();
        });
      });
      // 3: reset model if undefined to zero
      scope.model = (scope.model) ? scope.model : 0;
      // 4: If model had changed outside the input we need to format input value
      scope.$watch('model',function(){
        if (!$(el).is(':focus')) {
          if(!scope.model){
            scope.model = 0;
          }
          el.val($filter('currency')(scope.model,'',0));
          scope.removeEmptyClass();
        }
      });
      
      // 5: On focus clear format
      el.bind('focus', function(){
        el.val(scope.model);
      });
      
      
      el.bind('input', function(){
        scope.model = el.val();
        scope.$apply();
      });
      
      //6: On blur format input
      el.bind('blur', function(){
        if(!scope.model){
          scope.model = 0;
        }
        el.val($filter('currency')(scope.model,'',0));
        scope.removeEmptyClass();
      });
    }
  };
});

App.directive('numericInput', function(Helpers) {
  return {
    require: 'ngModel',
    link: function(scope, el,$attr,ctrl) {
      ctrl.$parsers.push(function(val){
        if(val){
          var value = val + '';
          var digits = Helpers.cleanInputs.number(val);

          if (digits !== value) {
              ctrl.$setViewValue(digits);
              ctrl.$render();
          }
          return digits;
        }
        return null;
      });
    }
  };
});

App.directive('phoneInput', function(Helpers) {
  return {
    require: 'ngModel',
    link: function(scope, el,$attr,ctrl) {
      ctrl.$parsers.push(function(val){
        if(val){
          var value = val + '';
          var digits = Helpers.cleanInputs.phone(val);

          if (digits !== value) {
              ctrl.$setViewValue(digits);
              ctrl.$render();
          }
          return digits;
        }
        return null;
      });
    }
  };
});

App.directive('productApproval', function (API,Helpers,$uibModal) {
  return {
    restrict: 'AE',
    template: `
      <div>
        <button type="button" popover-trigger="'outsideClick'" popover-is-open="popoverIsOpen" popover-class="low-z-index" popover-placement="{{ popoverPlacement }}" popover-append-to-body="true" uib-popover-template="'productApprovalPopover.html'" class="badge badge-dot-circle badge-{{ approvalTypes[model.approval_type].badge }}"
        ></button>
        <script type="text/ng-template" id="productApprovalPopover.html">
          <a ng-repeat="productApprovalItem in [{key: 'pending',label: 'بإنتظار الموافقة',color: 'light'},{key: 'approved',label: 'الموافقة على المنتج',color: 'success'},{key: 'rejected',label: 'رفض المنتج',color: 'danger'}]"
          ng-show="productApprovalItem.key != model.approval_type" class="dropdown-item btn iconed" ng-disabled="isSaving && productApprovalItem.key == approval_type" ng-loading="isSaving && productApprovalItem.key == approval_type" ng-loading-position="center" ng-click="change(productApprovalItem.key)"><span class="circle bg-{{ productApprovalItem.color }}"></span>{{ productApprovalItem.label }}</a>
        </script>
      </div>
    `,
    replace: true,
    scope: {
      model: '='
    },
    link: function ($scope, $e, $a) {
        $scope.popoverPlacement = ($a.popoverPlacement) ? $a.popoverPlacement : 'top auto';
        $scope.approvalTypes = {
            pending: {
                badge: 'light',
                tooltip: 'بإنتظار الموافقة على المنتج'
            },
            approved: {
                badge: 'success',
                tooltip: 'تمت الموافقة على المنتج'
            },
            rejected: {
                badge: 'danger',
                tooltip: 'مرفوض بسبب: '
            }
        };

        $scope.sendApproval = function(){
          $scope.isSaving = true;
          API.POST('product/set-approval/'+$scope.model.id,{approval_type: $scope.approval_type,approval_reject_reason: $scope.approval_reject_reason}).then(function(){
            $scope.isSaving = false;
            $scope.model.approval_type = $scope.approval_type;
            if($scope.approval_type == 'rejected'){
              $scope.reject_modal.cancel();
            }
            $scope.popoverIsOpen = false;
          },function(){
            $scope.isSaving = false;
            Helpers.httpErrorOccurs();
          });
        };

        $scope.change = function(approvalType){
          $scope.approval_type = approvalType;
          if(approvalType == 'rejected'){
            $uibModal.open({
                backdrop: 'static',
                templateUrl: Helpers.getTemp('modals/product-reject-reason-modal'),
                size: 'sm',
                scope: $scope,
                controller: function ($uibModalInstance, $scope) {
                    $scope.reject_modal = {
                        cancel: function () {
                            $uibModalInstance.close();
                        },
                        save: function (validity) {
                            if (!Helpers.isValid(validity)) {
                                return false;
                            }
                            $scope.sendApproval();
                        }
                    };
                }
            });
          }else {
            $scope.sendApproval();
          }
        };
    }
  };
});


App.directive('fotorama', function ($timeout) {
  return {
    restrict: 'E',
    template: `
      <div class="fotorama"></div>
    `,
    replace: true,
    scope: {
      items: '=',
      options: '='
    },
    link: function(scope, element, attrs) {
			scope.items.forEach(function(item){
				$('<img href="'+ item.imageUrl + '">').appendTo(element);
			});
      $timeout(function(){
        $('.fotorama').fotorama().data('fotorama').setOptions(scope.options);
      },1);
	
    }
  };
});

App.directive('merchantInfoCard', function (merchantFactory) {
  return {
    template: `
            <div class="user-card row">
                <div class="col-auto">
                    <a class="user-card-icon" ng-click="showMerchantDetails()"><i class="ic-shop"></i></a>
                </div>
                <div class="col">
                    <a class="user-card-name" ng-click="showMerchantDetails()">
                        {{ data.name }}</a>
                    <div class="user-card-meta align-items-center d-flex">
                        <i class="icon ic-user"></i>
                        <span>{{ data.responsible_name }}</span>
                    </div>
                    <a class="user-card-meta align-items-center d-flex" href="tel:{{ data.phone }}">
                        <i class="icon ic-call"></i>
                        <span>{{ data.phone }}</span>
                    </a>
                    <a class="user-card-meta align-items-center d-flex" href="mailto:{{ data.email }}">
                        <i class="icon ic-email"></i>
                        <span>{{ data.email }}</span>
                    </a>
                    <div class="user-card-meta align-items-center d-flex" ng-show="data.address_label">
                        <i class="icon ic-map-marker"></i>
                        <span>{{ data.address_label }}</span>
                    </div>
                </div>
            </div>
    `,
    scope: {
      data: '='
    },
    link: function ($scope, $e, $a) {
      $scope.showMerchantDetails = function (){
        return merchantFactory.show($scope.data.id);
      };
    }
  };
});

App.directive('customerInfoCard', function (customerFactory) {
  return {
    template: `
            <div class="user-card row">
                <div class="col-auto">
                    <a class="user-card-icon" ng-click="showCustomerDetails()"><i class="ic-user"></i></a>
                </div>
                <div class="col">
                    <a class="user-card-name" ng-click="showCustomerDetails()">
                        {{ data.name }}</a>
                    <a class="user-card-meta align-items-center d-flex" href="tel:{{ data.phone }}" ng-show="data.phone">
                        <i class="icon ic-call"></i>
                        <span>{{ data.phone }}</span>
                    </a>
                    <a class="user-card-meta align-items-center d-flex" href="mailto:{{ data.email }}" ng-show="data.email">
                        <i class="icon ic-email"></i>
                        <span>{{ data.email }}</span>
                    </a>
                    <div class="user-card-meta align-items-center d-flex" ng-show="data.address_label">
                        <i class="icon ic-map-marker"></i>
                        <span>{{ data.address_label }}</span>
                    </div>
                </div>
            </div>
    `,
    scope: {
      data: '='
    },
    link: function ($scope, $e, $a) {
      $scope.showCustomerDetails = function (){
        return customerFactory.show($scope.data.id);
      };
    }
  };
});

App.directive('uploadCategory', function (uploadFactory) {
  return {
    template: `
          <div>
          <div class="upload-category-item d-flex align-items-center" ng-click="category.is_toggled = !category.is_toggled" ng-class="{'clickable': category.sub_categories.length,'main': category.parent_id == 0,'sub': category.parent_id != 0}">
            <i class="ic-folder-f"></i>
            <div class="title">{{ category.name }}<span ng-show="category.sub_categories.length" class="toggle" ng-bind="(!category.is_toggled) ? '+' : '-'"></span></div>
            <div class="options d-flex align-items-center">
                <a href="#/uploads?category_id={{ category.id }}" ng-if="category.parent_id != 0" class="btn btn-light-dark btn-sm d-flex align-items-center"><i class="ic-eye ml-2"></i>استعرض الملفات</a>
                <a ng-if="$root.hasPermission('supervisor')" ng-click="upload.category.add(category.id,category.sub_categories)" class="btn btn-light-dark btn-sm d-flex align-items-center"><i class="ic-plus ml-2"></i>أضف تصنيف فرعي</a>
                <div uib-dropdown class="dropdown" ng-if="$root.hasPermission('supervisor')">
                    <a class="btn btn-light-dark btn-sm dropdown-toggle" uib-dropdown-toggle><i class="ic-more"></i></a>
                    <ul class="dropdown-menu" uib-dropdown-menu>
                        <li><a class="dropdown-item iconed" ng-click="upload.category.edit(category)"><i class="ic-edit"></i>تعديل</a></li>
                        <li><a class="dropdown-item iconed" ng-click="upload.category.delete(category.id,parentCategory,categoryIndex)"><i class="ic-delete"></i>حذف</a></li>
                    </ul>
                </div>
            </div>
           </div>
            <!-- Start Sub Categories -->
            <div ng-if="category.is_toggled">
              <div ng-if="category.sub_categories.length">
                <div class="upload-category-sub" ng-class="(category.parent_id == 0) ? 'main-sub' : ''">
                  <div ng-repeat="(subCategoryIndex,subCategory) in category.sub_categories">
                    <upload-category category="subCategory" parent-category="category.sub_categories" category-index="subCategoryIndex" upload="upload"></upload-category>
                  </div>
                </div>
              </div>
            </div>

            <!-- End Sub Categories -->
          </div>
    `,
    scope: {
      category: '=',
      categoryIndex: '=',
      parentCategory: '=',
      upload: '='
    },
    link: function ($scope, $e, $a) {
      
    }
  };
});