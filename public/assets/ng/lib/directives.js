/*!
	directives.js: is a file requires all directives belongs to us.
  afterInitPage
  moneyInput
  Switch Checkbox
  Include Replace
  maskInput
*/
App.directive('afterInitPage', function(API, Helpers) {
  return {
    restrict: 'AE',
    link: function($scope,$e,$a) {
      if ($a.afterInitPage == 'hide') {
        $e.addClass('d-none');
      }else {
        $e.removeClass('d-none');
      }
    }
  };
});

/* Money Input */
App.directive('moneyInput', function($filter,$timeout) {
  return {
    scope: {
      model: '=ngModel'
    },
    link: function(scope, el) {
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
          el.val($filter('currency')(scope.model,'',0));
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
        el.val($filter('currency')(scope.model,'',0));
      });
    }
  };
});
/* Switch Checkbox */
App.directive('switch', function() {
  return {
    restrict: 'AE',
    replace: true,
    link: function(s, e, a) {
      $(e).wrap('<label class="switch"></label>').after('<span class="slider round"><i class="ic-check"></i></span>');
    }
  };
});

/* Include Replace */
App.directive('includeReplace', function() {
  return {
    require: 'ngInclude',
    restrict: 'A',
    /* optional */
    link: function(scope, el, attrs) {
      el.replaceWith(el.children());
    }
  };
});

/* Mask Input */
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
