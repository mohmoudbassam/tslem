var App = angular.module('App', ['ngResource', 'ngSanitize', 'ngFlash', 'ui.bootstrap', 'ngStorage', 'ui.router', 'ui.select', 'selectize', 'datatables','ui.sortable','thatisuday.dropzone']);
/* API */
App.factory('API', function ($http,$rootScope, $filter, $localStorage) {
  var api_factory = {
    is_web: false,
    without_api_prefix: ['user/login','user/me','refresh', 'flow-uploader/start-import'],
    // Prepare JSON Send
    JSON: function (type, path) {
      $rootScope.apiUrl = apiUrl;
      var apiHeaders = {
        'Content-Type': 'application/json',
        'origin': 'x-requested-with',
        'X-App-Locale': window.current_lang
      };
      if ($localStorage.auth && $localStorage.auth.token) {
        apiHeaders['Authorization'] = 'Bearer ' + $localStorage.auth.token;
      }
      var apiJson = {
        headers: apiHeaders,
        method: type
      };

      apiJson.url = $rootScope.apiUrl + '/' + ((api_factory.without_api_prefix.indexOf(path) == -1) ? 'admin/'+path : path);
      return apiJson
    },
    // API Get Method
    GET: function (path, data, ignore_bar) {
      var json = this.JSON('GET', path);
      if (!data) {
        var data = {};
      }
      if (data) {
        json.params = data;
      }
      if (ignore_bar) {
        json.ignoreLoadingBar = true;
      }

      var http = $http(json);
      return http;
    },
    // API Post Method
    POST: function (path, data, ignore_bar) {
      var json = this.JSON('POST', path);
      if (data) {
        json.data = data;
      } else {
        json.data = {};
      }
      if (ignore_bar) {
        json.ignoreLoadingBar = true;
      }
      return $http(json);
    },
    // API PUT Method
    PUT: function (path, data, ignore_bar) {

      // NOTE: here we just replaced the JSON Method from PUT to POST temporary to be suitable with the backend
      var json = this.JSON('PUT', path);
      if (data) {
        json.data = data;
      } else {
        json.data = {};
      }
      if (ignore_bar) {
        json.ignoreLoadingBar = true;
      }
      return $http(json);
    },
    // API DELETE Method
    DELETE: function (path, data, ignore_bar) {

      // NOTE: here we just replaced the JSON Method from DELETE to POST temporary to be suitable with the backend
      var json = this.JSON('DELETE', path);
      if (data) {
        json.data = data;
      } else {
        json.data = {};
      }
      if (ignore_bar) {
        json.ignoreLoadingBar = true;
      }
      return $http(json);
    }
  };
  return api_factory;
});

/* Helpers */
App.factory('Helpers', function ($cacheFactory, Flash, $rootScope,$localStorage) {
  var helpersFactory = {
    /**
     * Clean input
     **/
    cleanInputs: {
      phone: function (item) {
        if (item) {
          item = item.replace(/\D/g, '');
          if (item.charAt(0) == '5') {
            item = '05';
          } else if (item.charAt(1) && item.charAt(1) != '5') {
            item = item.toString().substr(2);
          } else if (item.toString().charAt(0) != '0') {
            item = item.toString().substr(1);
          }
        }
        return item;
      },
      number: function (item) {
        if (item) {
          item = item.replace(/\D/g, '');
        }
        return item;
      }
    },
        /**
     * Add some red colors on invalid fields
     * @param boolean validity of form
     * @return boolean
     **/
    isValid: function (validity) {
      if (!validity) {
        $('form').addClass('invalid-form');
        return false;
      } else {
        $('form').removeClass('invalid-form');
        return true;
      }
    },

    /**
     * Prepare path of template
     * @param string part of path
     * @return string
     **/
    getTemp: function (path) {
      return baseUrl + '/assets/templates/' + path + '.html?v=' + assets_ver;
    },
    /**
     * Cache system to store and retrieve data
     * @return confirm
     **/
    Cache: function () {
      return $cacheFactory.get('helpers-cache') || $cacheFactory('helpers-cache');
    },
    /**
     * Format file size
     * @return mixed
     **/
    formatFilesize: function (size) {
      var i = Math.floor(Math.log(size) / Math.log(1024));
      return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'KB', 'MB', 'GB', 'TB'][i];
    },
    /**
     * Confirm delete message
     * @return confirm
     **/
    confirmDelete: function (path) {
      return confirm('هل أنت متأكد من عملية الحذف؟');
    },
    /**
     * Page Wrap Laoding
     * @return
     **/
    pageWrapLoading: function (isShow, title,isNoOpacity) {
      var loadingTitle = (title) ? title : 'جاري التحميل';
      if (!$('#page_wrap_loading').length) {
        $('body').append('<div id="page_wrap_loading"><div class="page-wrap-loading d-flex justify-content-center align-items-center" style="display: none;"><div><div class="circle-loader"></div><div class="page-wrap-loading-title">' + loadingTitle + '</div></div></div></div>');
        if (isShow) {
          $('#page_wrap_loading').fadeIn();
        } else {
          $('#page_wrap_loading').fadeOut();
        }
        if (isNoOpacity) {
           $('#page_wrap_loading').addClass('no-opacity');
          }else {
            $('#page_wrap_loading').removeClass('no-opacity');
        }
      } else {
        $('.page-wrap-loading-title').text(loadingTitle);
        if (isShow) {
          $('#page_wrap_loading').fadeIn();
        } else {
          $('#page_wrap_loading').fadeOut();
        }
        if (isNoOpacity) {
          $('#page_wrap_loading').addClass('no-opacity');
        } else {
          $('#page_wrap_loading').removeClass('no-opacity');
        }
      }
    },
    /**
     * Http errors occurs
     * @return Flash
     **/
    httpErrorOccurs: function () {
      return Flash.create('danger', 'لقد حدث خطأ في الإتصال, يرجى إعادة المحاولة');
    },
    /**
     * Most used flash messages
     * 
     * @param message
     * @return Flash
     **/
    flashMessage: function (message) {
      var flash_color = (['invalid_fields'].indexOf(message) > -1) ? 'danger' : 'success',
        flash_msg = '';
      switch (message) {
        case 'invalid_fields':
          flash_msg = 'يرجى منك التحقق من جميع الحقول';
          break;
      }
      if (flash_msg) {
        return Flash.create(flash_color, flash_msg);
      }
    },
    /**
     * Echart attributes
     * @return string
     **/
    echartAttributes: function (key) {
      let layoutColorPalette = {
        extraCss: {
        light: 'box-shadow: 0 3px 15px rgba(0, 0, 0, 0.2);background: #fff;padding: 10px 15px;',
        dark: '#344152'
        },
        fontFamily: {
        light: 'Janna LT,sana-serif',
        dark: '#344152'
        },
        chartFontWeight: {
        light: 'bold',
        dark: 'bold'
        },
        chartBarHoverBg: {
        light: '#EEE',
        dark: '#344152'
        },
        chartClearTextColor: {
        light: '#000',
        dark: '#FFF'
        },
        chartWrapperBackground: {
        light: '#FFF',
        dark: '#26303e'
        },
        chartAxisLabelColor: {
        light: '#74787d',
        dark: '#d1d9de'
        },
        chartAxisLabelBorderColor: {
        light: '#CCCDD6',
        dark: '#344152'
        }
      };
      if (layoutColorPalette[key]) {
        return layoutColorPalette[key].light;
      }else {
        return '';
      }
    },

    tdItem: function(value){
      return (!value) ? '<div class="text-muted">غير معرف</div>' : value;
    },
    /**
     * Prepare dropzone options
     * 
     **/
    prepareDropzoneOptions: function(path,uploadMessage,acceptedFiles,crop){
        var r = {
          url: $rootScope.apiUrl+'/admin/uploader/'+path,
          headers: {
              'Authorization': 'Bearer ' + $localStorage.auth.token
          },
          maxFiles: 1,
          paramName : 'file',
          acceptedFiles : ((!acceptedFiles) ? 'image/jpeg, images/jpg, image/png, image/svg+xml' : acceptedFiles),
          dictDefaultMessage: uploadMessage,
          init: function() {
            // if (path) {
            //   var thisDropzone = this;
            //   var mockFile = {};
            //   thisDropzone.emit("addedfile", mockFile);
            //   thisDropzone.emit("success", mockFile);
            //   thisDropzone.emit("thumbnail", mockFile, baseUrl+'/uploads/images/'+path);
            //   thisDropzone.emit("complete",mockFile);
            // }
          }
        };

        if (crop) {
          r.transformFile = function(file,done){
            $scope.cropDataUrl = file;
            $timeout(function(){

                var myDropZone = crop.methods.getDropzone();
                $uibModal.open({
                  backdrop  : 'static',
                  templateUrl: Helpers.getTemp('modals/crop-modal'),
                  scope: $scope,
                  keyboard: false,
                  controller: function($uibModalInstance,$location,$scope,$http,Flash,$route,$window){
                    $timeout(function(){
                      var image = document.querySelector('#crop_image');
                      $scope.cropper = new Cropper(image, {
                        aspectRatio: 1/1.3,
                        zoomable: false
                      });
                    },1);
                    $scope.crop_modal = {
                      src: file.dataURL,
                      is_cropper_loaded: false,
                      cancel: function() {
                        API.is_web = false;
                        $uibModalInstance.close();
                      },
                      save: function() {
                        var canvasOptions = {};
                        if (crop.width) {
                          canvasOptions.width = crop.width;
                          canvasOptions.height = crop.height;
                        }
                        var canvas = $scope.cropper.getCroppedCanvas(canvasOptions);
                        canvas.toBlob(function(blob) {

                          // Update the image thumbnail with the new image data
                          myDropZone.createThumbnail(
                            blob,
                            myDropZone.options.thumbnailWidth,
                            myDropZone.options.thumbnailHeight,
                            myDropZone.options.thumbnailMethod,
                            false,
                            function(dataURL) {

                              // Update the Dropzone file thumbnail
                              myDropZone.emit('thumbnail', file, dataURL);

                              // Return modified file to dropzone
                              done(blob);
                            }
                          );

                        });
                        $scope.crop_modal.cancel();
                      }
                    };
                  }

                });

            },100);
          };
        }

        return r;
      }
  }
  return helpersFactory;
});

/* AuthFactory */
App.factory('AuthFactory', function ($localStorage,$rootScope,$location,$uibModal,Helpers, $http, API) {
  var factory = {

    /**
     * Get user info by token
     * @param string token
     **/
    getInfo: function (token,callback) {
      if (token && !$localStorage.auth) {
        $localStorage.auth  = {
          token: token
        };
      }
      Helpers.pageWrapLoading(true, null, true);
      
      API.GET('user/me').then(function (d) {
        $rootScope.auth ={
          user: d.data
        };
        if (angular.isFunction(callback)) {
          callback();
        }
        Helpers.pageWrapLoading(false, null, true);
      }).catch(function (response) {
        Helpers.pageWrapLoading(false, null, true);
        factory.logout();
      });
    },
    /**
     * Logout user
     **/
    logout: function (callback) {
      delete $localStorage.auth;
      $http.defaults.headers.common.Authorization = '';
      $location.url('/login');
    },
    /**
     * My account modal
     * @param object options, we use it to pass any additional data to this function
     * @return string
     **/
    myAccount: function () {
      $uibModal.open({
        backdrop: 'static',
        templateUrl: Helpers.getTemp('auth/my-account-modal'),
        size: 'sm',
        controller: function ($uibModalInstance, $rootScope, $scope, Flash, Helpers, $filter) {
          $scope.my_account_modal = {
            cancel: function () {
              $uibModalInstance.close();
            },
            cleanInputs: {
              phone: function () {
                $scope.my_account_modal.data.contact_office = Helpers.cleanInputs.phone($scope.my_account_modal.data.contact_office);
              },
              mobile: function () {
                $scope.my_account_modal.data.contact_home = Helpers.cleanInputs.number($scope.my_account_modal.data.contact_home);
              }
            },
            onSave: function (Form, isNew) {
              $scope.my_account_modal.isSendClicked = true;
              if (!Helpers.isValid(Form.$valid)) {
                Helpers.flashMessage('invalid_fields');
                return false;
              }
              $scope.my_account_modal.isSending = true;
              API.PUT('update-info', $scope.my_account_modal.data).then(function (d) {
                $scope.my_account_modal.isSending = false;
                $scope.my_account_modal.cancel();
                $rootScope.auth.user = angular.extend($rootScope.auth.user, $scope.my_account_modal.data);
              }).catch(function(error){
                $scope.my_account_modal.isSending = false;
                if (error.data.message == 'email_already_exists') {
                  Flash.create('danger', 'البريد الألكتروني موجود مسبقاً');
                }else {
                  Helpers.httpErrorOccurs();
                }
              });

            },
            init: function () {
              $scope.my_account_modal.data = angular.copy($rootScope.auth.user);

              
            }
          };
          $scope.my_account_modal.init();
        }
      });
    }
  }
  return factory;
});


/* Start Config */
App.config(function ($stateProvider, $locationProvider, $urlRouterProvider, $interpolateProvider, uiSelectConfig) {

  uiSelectConfig.theme = 'bootstrap';
  $interpolateProvider.startSymbol('{{');
  $interpolateProvider.endSymbol('}}');
  // Templates path
  var templates_path = baseUrl + '/assets/templates/';

  $locationProvider.hashPrefix('');

  // General Routes
  $stateProvider
    .state('login', {
      url: '/login',
      templateUrl: templates_path + 'auth/login.html?v=' + assets_ver,
      controller: 'LoginCtrl',
      controllerAs: 'vm'
    });
    // Routes
    $stateProvider.state('dashboard', {
        url: '/dashboard?date&sdate&edate&town_id&city_id',
        templateUrl: templates_path + 'pages/dashboard.html?v=' + assets_ver,
        controller: 'DashboardCtrl',
        controllerAs: 'vm'
    }).state('engineers', {
      url: '/engineers?created_date&created_date_sdate&created_date_edate&user_role_id',
      templateUrl: templates_path + 'pages/engineers.html?v=' + assets_ver,
      controller: 'DatatableCtrl',
      controllerAs: 'vm'
    }).state('uploads', {
      url: '/uploads?created_date&created_date_sdate&created_date_edate&created_by_id&category_id',
      templateUrl: templates_path + 'pages/uploads.html?v=' + assets_ver,
      controller: 'DatatableCtrl',
      controllerAs: 'vm'
    }).state('setting', {
      url: '/setting/:settingType?type&created_date&created_date_sdate&created_date_edate&user_id&parent_id',
      templateUrl: templates_path + 'pages/setting-type.html?v=' + assets_ver,
      controller: 'DatatableCtrl',
      controllerAs: 'vm'
    });
  $urlRouterProvider.otherwise("/engineers");

});

/* Start Run */
App.run(function ($locale,$rootScope, $http, $location, $localStorage, AuthFactory) {
  // Change comma to dot in currency
  $locale.NUMBER_FORMATS.DECIMAL_SEP = '.';

  // keep user logged in after page refresh
  if ($localStorage.auth) {
    AuthFactory.getInfo($localStorage.auth.token);
  }

  // redirect to login page if not logged in and trying to access a restricted page
  $rootScope.$on('$locationChangeStart', function () {
    var authPages = ['/login', '/reset-password'];
    var isAuthPage = authPages.indexOf($location.path()) === -1;
    if (isAuthPage) {
      if (!$localStorage.auth) {
        $location.path('/login');
      }
      $rootScope.isAuthPage = false;
    } else {
      if ($localStorage.auth) {
        $location.path('/home');
      }
      $rootScope.isAuthPage = true;
    }
  });
});



/* Some jQuery Codes */
$(function () {
  /* Navbar Toggle */
  var toggleNavbar = false;
  $(document).mouseup(function (e) {
    setTimeout(function () {
      if ($('.ui-select-choices').is(':visible') && $('.ui-select-choices').has('.active')) {
        $('.ui-select-choices-row').hover(function () {
          var p = $(this).closest('.ui-select-choices');
          if (!p.find('active').is($(this))) {
            p.find('.active').removeClass('active');
          }
        });
      }
    }, 1);

    if ($('body').hasClass('sidebar-toggled')) {
      $('body').removeClass('sidebar-toggled');
    } else {
      if ($('.sidebar-toggle').is(e.target) || $('.sidebar-toggle i').is(e.target)) {
        if ($('body').hasClass('sidebar-toggled')) {
          $('body').removeClass('sidebar-toggled');
        } else {
          $('body').addClass('sidebar-toggled');
        }
        toggleNavbar = !toggleNavbar;
      }
    }

  });


});

/* Main Ctrl */
App.controller('MainCtrl', function ($scope,$rootScope,AuthFactory,settingFactory , $filter) {
  $rootScope.baseUrl = baseUrl;
  $rootScope.baseApiUrl = baseApiUrl;
  $rootScope.list = {};
  $rootScope.currentYear = $filter('date')(new Date, 'yyyy');
  $scope.auth = {
    myAccount: function () { 
      return AuthFactory.myAccount();
    },
    logout: function(){
      return AuthFactory.logout();
    }
  };

  $scope.setting = {
    open: function(){
      return settingFactory.open();
    }
  };

  $rootScope.hasPermission = function(perm){
    if($rootScope.auth && $rootScope.auth.user){
      if($rootScope.auth.user.data.is_supervisor){
        return true;
      }
      else if(angular.isObject($rootScope.auth.user.data.permissions)){
        if($rootScope.auth.user.data.permissions[perm]){
          return true;
        }else {
          return false;
        }
      }else {
        return false;
      }
    }
  };

  /* Sidebar */
  $('.sidebar .has-submenu > a').click(function () {
    $(this).parent().toggleClass('active');
  });
  /* End Sidebar */

});


/**
 * Delay any function for specific time to reduce the number of requests to the API
 * @param function callback
 * @param integer ms timeout
 **/
var delay = (function () {
  var timer = 0;
  return function (callback, ms) {
    clearTimeout(timer);
    timer = setTimeout(callback, ms);
  };
})();