/*
	Includes:
	RegisterCtrl
	LoginCtrl
*/

/* Register Ctrl */
App.controller('RegisterCtrl',function($scope,$timeout,API,Helpers,Flash){
	/* 1: Prepare Notes */
	$scope.notes = {
		personal_image: '<div class="text-primary mb-1">مهم بخصوص الصورة الشخصية</div><ul class="list-unstyled terms-items mb-0"><li>التقيد بإرفاق صورة شخصية رسمية.</li><li>لن يتم قبول أي صورة غير رسمية وسيتم إستبعادك من الفرز المبدئي للتوظيف.</li><li>أن تكون الخلفية بيضاء وتبدأ الصورة من الرقبة دون الكتفين.</li><li>الصورة يتم إلتقاطها من الأمام للوجه.</li></ul>',
		sa_id_image: '<div class="text-primary mb-1">مهم بخصوص صورة بطاقة الهوية</div><ul class="list-unstyled terms-items mb-0"><li>يجب أن تكون الصورة واضحة لبطاقتك الشخصية ( الهوية السعودية / الإقامة ).</li><li>يجب اقتصاص صورة البطاقة بشكل واضح.</li><li>لن يتم قبول أي صورة غير واضحة الأرقام والبيانات.</li></ul>',
		iban_image: '<div class="text-primary mb-1">مهم بخصوص صورة الأيبان</div><ul class="list-unstyled terms-items mb-0"><li>يجب أن يكون رقم الأيبان والبيانات كاملة وواضحة.</li><li>يجب ان تكون صورة الايبان معتمده من البنك بختم واضح أو من التطبيق الالكتروني.</li><li>لن يتم قبول أي صورة غير واضحة الأرقام والبيانات.</li></ul>',
		cv_image: '<div class="text-primary mb-1">مهم بخصوص السيرة الذاتية</div><ul class="list-unstyled terms-items mb-0"><li>يرجى منك رفع أما صورة أو ملف PDF للسيرة الذاتية.</li></ul>'
	};

	/* 2: Prepare Upload */

	$scope.prepareDzOptions = function(no_img,path){
		let acceptedFiles = 'image/jpeg, images/jpg, image/png';
		if(path != 'images'){
			acceptedFiles += ', application/pdf'
		}
		return {
			url: baseUrl+'/api/web/upload',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			maxFiles: 1,
			paramName : 'file',
			acceptedFiles : acceptedFiles,
			dictDefaultMessage : '<div class="img-icon d-flex justify-content-center align-items-center"><img src="'+baseUrl+'/assets/images/svgs/'+no_img+'.svg" alt="" /></div><b class="img-upload">'+((path != 'images') ? 'أرفع الملف' : 'أرفع صورة')+'</b>',
			init: function() {
				this.on("maxfilesexceeded", function(file) {
					  this.removeAllFiles();
					  this.addFile(file);
				});
		  	}   
		};
	};

	$scope.prepareDzCallbacks = function(parent,model,extra_data){
		return {
			'success' : function(file,xhr){
				if (parent) {
					$scope[parent][model] = xhr.path;
				}else {
					$scope[model] = xhr.path;
				}
			},
			'sending' : function(file, xhr, formData){
				if (extra_data) {
					angular.forEach(extra_data,function(v,k){
						formData.append(k,v);
					});
				}
			}

		};
	};

	$scope.dzPerOptions = $scope.prepareDzOptions('no-avatar','images');
	$scope.dzIdOptions = $scope.prepareDzOptions('no-id','images');
	$scope.dzIbanOptions = $scope.prepareDzOptions('no-iban','images');
	$scope.dzCvOptions = $scope.prepareDzOptions('no-iban','cv');

	$scope.dzPerCallbacks = $scope.prepareDzCallbacks('register','image_of_personal');
	$scope.dzIdCallbacks = $scope.prepareDzCallbacks('register','image_of_sa_id');
	$scope.dzIbanCallbacks = $scope.prepareDzCallbacks('register','image_of_iban');
	$scope.dzCvCallbacks = $scope.prepareDzCallbacks('register','image_of_cv',{type: 'cv'});

	/* 3: Prepare Fields */
	$scope.register = {
		blood_type: '',
		question_previous_experiences: {},
		question_previous_experiences_jobs: {}
	};
	$scope.cleanInputs = {
		name: function(i,e){
			// console.log($scope.register[i]);
			$scope.register[i] = $scope.register[i].replace(/[^\u0600-\u06FF\s]/gi, '');
		},
		sa_id: function(i){
			// $('#'+i).val(parseInt($('#'+i).val()));
			// if (['1','2','3','4'].indexOf($('#'+i).val().toString().charAt(0)) == -1) {
			// 	$('#'+i).val(parseInt($('#'+i).val().toString().substr(1)));
			// }
		},
		phone: function(i){
			$scope.register[i] = $scope.register[i].replace(/\s/g, '');
			if ($scope.register[i].charAt(0) == '5') {
				$scope.register[i] = '05';
			}
			else if ($scope.register[i].charAt(1) && $scope.register[i].charAt(1) != '5') {
				$scope.register[i] = $scope.register[i].toString().substr(2);
			}
			else if ($scope.register[i].toString().charAt(0) != '0') {
				$scope.register[i] = $scope.register[i].toString().substr(1);
			}
		}
	};
	$scope.maskOptions = {
		email: {translation: {'Z': {pattern: /[0-9a-zA-Z\@\.]/, recursive: true}}},
		name: {translation: {'Z': {pattern: /[a-zA-Z ]/, recursive: true}}}
	};
	$scope.CustomValidation = function(type,input){
		if(type == 'sa_id'){
			return !input || input.length < 10;
		}
		if(type == 'languages'){
			return !(($scope.register.question_language_arabic) || ($scope.register.question_language_urdu) || ($scope.register.question_language_arabic && $scope.register.question_language_english));
		}
		if(type == 'birthday'){
			var minHijriDay = 15,
					minHijriMonth = 11,
					minHijriYear = parseInt($scope.hijri.years[$scope.hijri.years.length-1]);
			return !(parseInt($scope.hijri_birthday_year) < minHijriYear || (parseInt($scope.hijri_birthday_month) < minHijriMonth || (parseInt($scope.hijri_birthday_month) == minHijriMonth && parseInt($scope.hijri_birthday_day) <= minHijriDay)));
		}
	};
	$scope.list_of_banks = [
		{key: 'Al Rajhi Bank',name: 'مصرف الراجحي'},{key: 'Al Riyad Bank',name: 'بنك الرياض'},{key: 'Alarabi Bank',name: 'البنك العربي'},{key: 'Alawwal Bank',name: 'البنك الأول (الهولندي قديماً)'},{key: 'Alfransi Bank',name: 'البنك الفرنسي'},{key: 'Alinma Bank',name: 'بنك الانماء'},{key: 'Bank Albilad',name: 'بنك البلاد'},{key: 'Bank AlJazira',name: 'بنك الجزيرة'},{key: 'Meem',name: 'بنك ميم'},{key: 'National Commercial Bank',name: 'البنك الأهلي NCB'},{key: 'SABB',name: 'البنك السعودي البريطاني SABB'},{key: 'SAIB',name: 'البنك السعودي للإستثمار SAIB'},{key: 'SAMBA',name: 'البنك السعودي الأمريكي SAMBA'}
	];
	$scope.list_of_nationalities=['Saudi','Afghan','Albanian','Algerian','American','Andorran','Angolan','Antiguans','Argentinean','Armenian','Australian','Austrian','Azerbaijani','Bahamian','Bahraini','Bangladeshi','Barbadian','Barbudans','Batswana','Belarusian','Belgian','Belizean','Beninese','Bhutanese','Bolivian','Bosnian','Brazilian','British','Bruneian','Bulgarian','Burkinabe','Burmese','Burundian','Cambodian','Cameroonian','Canadian','Cape Verdean','Central African','Chadian','Chilean','Chinese','Colombian','Comoran','Congolese','Costa Rican','Croatian','Cuban','Cypriot','Czech','Danish','Djibouti','Dominican','Dutch','East Timorese','Ecuadorean','Egyptian','Emirian','Equatorial Guinean','Eritrean','Estonian','Ethiopian','Fijian','Filipino','Finnish','French','Gabonese','Gambian','Georgian','German','Ghanaian','Greek','Grenadian','Guatemalan','Guinea-Bissauan','Guinean','Guyanese','Haitian','Herzegovinian','Honduran','Hungarian','I-Kiribati','Icelander','Indian','Indonesian','Iranian','Iraqi','Irish','Italian','Ivorian','Jamaican','Japanese','Jordanian','Kazakhstani','Kenyan','Kittian and Nevisian','Kuwaiti','Kyrgyz','Laotian','Latvian','Lebanese','Liberian','Libyan','Liechtensteiner','Lithuanian','Luxembourger','Macedonian','Malagasy','Malawian','Malaysian','Maldivan','Malian','Maltese','Marshallese','Mauritanian','Mauritian','Mexican','Micronesian','Moldovan','Monacan','Mongolian','Moroccan','Mosotho','Motswana','Mozambican','Namibian','Nauruan','Nepalese','New Zealander','Nicaraguan','Nigerian','Nigerien','North Korean','Northern Irish','Norwegian','Omani','Pakistani','Palauan','Palestinian','Panamanian','Papua New Guinean','Paraguayan','Peruvian','Polish','Portuguese','Qatari','Romanian','Russian','Rwandan','Saint Lucian','Salvadoran','Samoan','San Marinese','Sao Tomean','Scottish','Senegalese','Serbian','Seychellois','Sierra Leonean','Singaporean','Slovakian','Slovenian','Solomon Islander','Somali','South African','South Korean','Spanish','Sri Lankan','Sudanese','Surinamer','Swazi','Swedish','Swiss','Syrian','Taiwanese','Tajik','Tanzanian','Thai','Togolese','Tongan','Trinidadian/Tobagonian','Tunisian','Turkish','Tuvaluan','Ugandan','Ukrainian','Uruguayan','Uzbekistani','Venezuelan','Vietnamese','Welsh','Yemenite','Zambian','Zimbabwean'];
	$scope.list_of_qualifications = ['دكتوراه','ماجستير','بكالوريوس','دبلوم','ثانوي','متوسط','إبتدائي','بدون'];
	$scope.list_of_specializations = ['الهندسة','الإدارة','القانون','علوم وهندسة الحاسب','المحاسبة','لغات','التعليم','بدون'];
	$scope.list_blood_types = ['AB+','AB-','A+','A-','B+','B-','O+','O-'];
	/* Perpare Hijri Date */
	$scope.hijri = {
		days: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],
		years: [],
		months: []
	};
	var hijriMonths = ['المحرّم', 'صفر', 'ربيع الأول', 'ربيع الثاني', 'جمادى الاول', 'جمادى الآخر', 'رجب', 'شعبان', 'رمضان', 'شوّال', 'ذو القعدة', 'ذو الحجة'];
	var curHijri = parseInt(window.curHijri);
	var minYearsHijri = curHijri-10;
	for (var year = (minYearsHijri-60); year <= minYearsHijri; year++) {
		$scope.hijri.years.push(year);
	}
	angular.forEach(hijriMonths,function(month_v,month_k){
		$scope.hijri.months.push({key: (month_k+1),label: month_v});
	});
	/* End Perpare Hijri Date */
	$scope.list_of_yes_no = [{key: 'Yes',label: 'نعم'},{key: 'No',label: 'لا'}];
	$scope.list_of_cities = [
		{key: 'Tabuk',label: 'تبوك'},{key: 'Riyadh',label: 'الرياض'},{key: 'At Taif',label: 'الطائف'},{key: 'Makkah',label: 'مكة المكرمة'},{key: 'Hail',label: 'حائل'},{key: 'Buraydah',label: 'بريدة'},{key: 'Al Hufuf',label: 'الهفوف'},{key: 'Ad Dammam',label: 'الدمام'},{key: 'Al Madinah Al Munawwarah',label: 'المدينة المنورة'},{key: 'Abha',label: 'ابها'},{key: 'Jazan',label: 'جازان'},{key: 'Jeddah',label: 'جدة'},{key: 'Al Majmaah',label: 'المجمعة'},{key: 'Al Khubar',label: 'الخبر'},{key: 'Hafar Al Batin',label: 'حفر الباطن'},{key: 'Khamis Mushayt',label: 'خميس مشيط'},{key: 'Ahad Rifaydah',label: 'احد رفيده'},{key: 'Al Qatif',label: 'القطيف'},{key: 'Unayzah',label: 'عنيزة'},{key: 'Qaryat Al Ulya',label: 'قرية العليا'},{key: 'Al Jubail',label: 'الجبيل'},{key: 'An Nuayriyah',label: 'النعيرية'},{key: 'Dhahran',label: 'الظهران'},{key: 'Al Wajh',label: 'الوجه'},{key: 'Buqayq',label: 'بقيق'},{key: 'Az Zulfi',label: 'الزلفي'},{key: 'Khaybar',label: 'خيبر'},{key: 'Al Ghat',label: 'الغاط'},{key: 'Umluj',label: 'املج'},{key: 'Rabigh',label: 'رابغ'},{key: 'Afif',label: 'عفيف'},{key: 'Thadiq',label: 'ثادق'},{key: 'Sayhat',label: 'سيهات'},{key: 'Tarut',label: 'تاروت'},{key: 'Yanbu',label: 'ينبع'},{key: 'Shaqra',label: 'شقراء'},{key: 'Ad Duwadimi',label: 'الدوادمي'},{key: 'Ad Diriyah',label: 'الدرعية'},{key: 'Quwayiyah',label: 'القويعية'},{key: 'Al Muzahimiyah',label: 'المزاحمية'},{key: 'Badr',label: 'بدر'},{key: 'Al Kharj',label: 'الخرج'},{key: 'Ad Dilam',label: 'الدلم'},{key: 'Ash Shinan',label: 'الشنان'},{key: 'Al Khurmah',label: 'الخرمة'},{key: 'Al Jumum',label: 'الجموم'},{key: 'Al Majardah',label: 'المجاردة'},{key: 'As Sulayyil',label: 'السليل'},{key: 'Tathilith',label: 'تثليث'},{key: 'Bishah',label: 'بيشة'},{key: 'Al Baha',label: 'الباحة'},{key: 'Al Qunfidhah',label: 'القنفذة'},{key: 'Muhayil',label: 'محايل'},{key: 'Thuwal',label: 'ثول'},{key: 'Duba',label: 'ضبا'},{key: 'Turbah',label: 'تربه'},{key: 'Safwa',label: 'صفوى'},{key: 'Inak',label: 'عنك'},{key: 'Turaif',label: 'طريف'},{key: 'Arar',label: 'عرعر'},{key: 'Al Qurayyat',label: 'القريات'},{key: 'Sakaka',label: 'سكاكا'},{key: 'Rafha',label: 'رفحاء'},{key: 'Dawmat Al Jandal',label: 'دومة الجندل'},{key: 'Ar Rass',label: 'الرس'},{key: 'Al Midhnab',label: 'المذنب'},{key: 'Al Khafji',label: 'الخفجي'},{key: 'Riyad Al Khabra',label: 'رياض الخبراء'},{key: 'Al Badai',label: 'البدائع'},{key: 'Ras Tannurah',label: 'رأس تنورة'},{key: 'Al Bukayriyah',label: 'البكيرية'},{key: 'Ash Shimasiyah',label: 'الشماسية'},{key: 'Al Hariq',label: 'الحريق'},{key: 'Hawtat Bani Tamim',label: 'حوطة بني تميم'},{key: 'Layla',label: 'ليلى'},{key: 'Billasmar',label: 'بللسمر'},{key: 'Sharurah',label: 'شرورة'},{key: 'Najran',label: 'نجران'},{key: 'Sabya',label: 'صبيا'},{key: 'Abu Arish',label: 'ابو عريش'},{key: 'Samtah',label: 'صامطة'},{key: 'Ahad Al Musarihah',label: 'احد المسارحة'},{key: 'King Abdullah Economic City',label: 'مدينة الملك عبدالله الاقتصادية'}
	];


	$scope.current_tab = 'form';



	$scope.sendRegister = function(validity){
		$scope.is_send_clicked = true;
		if (!Helpers.isValid(validity)) {
			Flash.create('danger','يرجى منك ملئ جميع الحقول المطلوبة');
			return false;
		}else if(!$scope.register.image_of_personal || !$scope.register.image_of_sa_id || !$scope.register.image_of_iban){
			Flash.create('danger','يرجى منك رفع جميع الصور المطلوبة');
			return false;
		}else if($scope.register.sa_id.length < 10 || $scope.register.bank_sa_id_of_iban_owner.length < 10){
			Flash.create('danger','يرجى التحقق من بطاقة الهوية ان تساوي 10 أرقام');
			return false;
		}else if($scope.register.email != $scope.confirm_email_address){
			Flash.create('danger','البريد الألكتروني غير متطابق');
			return false;
		}else if($scope.register.phone != $scope.register.confirm_phone){
			Flash.create('danger','رقم الجوال غير متطابق');
			return false;
		}else if($scope.register.password != $scope.confirm_password){
			Flash.create('danger','كلمة السر غير متطابقة');
			return false;
		}else if($scope.CustomValidation('languages',null)){
			Flash.create('danger','يرجى التأكد من حقل اللغات جيداً');
			return false;
		}
		// else if($scope.CustomValidation('birthday',null)){
		// 	Flash.create('danger','عذراً عمرك أقل من 18 سنة, يرجى منك قراءة شروط التقديم اولاً');
		// 	return false;
		// }
		else {
			$scope.isLoading = true;
		}
		API.is_web = true;
		// Fix some fields before send

		var send_data = angular.copy($scope.register);
		send_data.sa_id = send_data.sa_id+'';
		send_data.bank_sa_id_of_iban_owner = send_data.bank_sa_id_of_iban_owner+'';
		send_data.birthday_hijri = $scope.hijri_birthday_day+'/'+$scope.hijri_birthday_month+'/'+$scope.hijri_birthday_year;
		API.POST('auth/register',send_data).then(function(d){
			$scope.isLoading = false;
			if(d && d.data && d.data.message){
				switch (d.data.message) {
					case 'user_created':
					window.location.href = baseUrl+'/panel';
					break;
					case 'invalid_fields':
					$('form').addClass('invalid-form');
					angular.forEach(d.data.errors,function(errorValue,errorKey){
						let errorDetails = '<div class="text-danger mt-1">'+errorValue.join(', ')+'</div>';
						if(errorKey == 'bank_iban'){
							$('#'+errorKey).closest('.form-group').append(errorDetails);
						}else {
							$('#'+errorKey).after(errorDetails);
						}
					});
					Flash.create('danger','يرجى التأكد من البيانات المدخلة جيداً');
					break;
					case 'sa_id_already_exists':
					Flash.create('danger','رقم بطاقة الهوية متواجد مسبقاً');
					break;
					default:
					Flash.create('danger',d.data.message_string);
					break;
				}
			}else {
				Flash.create('danger','حدث خطأ, يرجى إعادة المحاولة - رمز الخطأ 102');
			}
		},function(d){
			Flash.create('danger','حدث خطأ, يرجى إعادة المحاولة - رمز الخطأ 103');
		});

	};



});

/* Login Ctrl */
App.controller('LoginCtrl',function($scope,$timeout,API,Helpers,Flash){
	$scope.login = {};
	$scope.sendLogin = function(validity){
		$scope.is_send_clicked = true;
		if ($scope.isLoading) {
			return false;
		}
		$scope.invalid_login = false;
		if (!Helpers.isValid(validity)) {
			return false;
		}else {
			$scope.isLoading = true;
		}
		// Save form
		API.is_web = true;
		API.POST('auth/login',$scope.login).then(function(d){
			$scope.isLoading = false;
			if (d.data.message == 'invalid_fields') {
				$scope.form_errors = d.data.errors;
			}else{
				if (d.data.message == 'logged_in') {
					window.location.href = baseUrl+'/panel';
				}else {
					$scope.invalid_login = true;
				}
			}
		});
	};

});
