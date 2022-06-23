L.drawLocal = {
    draw: {
        toolbar: {
            actions: {
                title: 'ازالة الرسم',
                text: 'ازالة'
            },
            finish: {
                title: 'انتهاء الرسم',
                text: 'انتهاء'
            },
            undo: {
                title: 'حذف آخر نقطة مرسومة',
                text: 'حذف آخر نقطة'
            },
            buttons: {
                polyline: 'ارسم خط متعدد الخطوط',
                polygon: 'ارسم مضلع',
                rectangle: 'ارسم مستطيلاً',
                circle: 'أرسم دائرة',
                marker: 'ارسم علامة',
                circlemarker: 'ارسم علامة دائرة'
            }
        },
        handlers: {
            circle: {
                tooltip: {
                    start: 'انقر واسحب لرسم الدائرة.'
                },
                radius: 'نصف القطر'
            },
            circlemarker: {
                tooltip: {
                    start: 'انقر على الخريطة لوضع علامة دائرية'
                }
            },
            marker: {
                tooltip: {
                    start: 'انقر على الخريطة لوضع العلامة.'
                }
            },
            polygon: {
                tooltip: {
                    start: 'أنقر لبدء رسم شكلاً.',
                    cont: 'أنقر للإستمرار في رسم الشكل.',
                    end: 'أنقر على أول نقطة لإنهاء هذا الشكل.'
                }
            },
            polyline: {
                error: '<strong>خطأ:</strong> لا يمكن أن تعبر حواف الشكل!',
                tooltip: {
                    start: 'أنقر لبدء رسم خط.',
                    cont: 'أنقر للإستمرار في رسم الخط',
                    end: 'أنقر على آخر نقطة لإنهاء هذا الخط'
                }
            },
            rectangle: {
                tooltip: {
                    start: 'انقر واسحب لرسم المستطيل.'
                }
            },
            simpleshape: {
                tooltip: {
                    end: 'أترك الماوس لإنهاء الشكل.'
                }
            }
        }
    },
    edit: {
        toolbar: {
            actions: {
                save: {
                    title: 'حفظ التغييرات',
                    text: 'حفظ'
                },
                cancel: {
                    title: 'إلغاء التعديل وتجاهل جميع التغييرات',
                    text: 'إلغاء'
                },
                clearAll: {
                    title: 'تصفير جميع الطبقات',
                    text: 'تصفير الكل'
                }
            },
            buttons: {
                edit: 'تعديل الطبقات',
                editDisabled: 'لا توجد طبقات ليتم تعديلها',
                remove: 'حذف الطبقات',
                removeDisabled: 'لا توجد طبقات ليتم حذفها'
            }
        },
        handlers: {
            edit: {
                tooltip: {
                    text: 'أسحب المقبض أو العلامة لتعديل الشكل',
                    subtext: 'انقر فوق "إلغاء" للتراجع عن التغييرات.'
                }
            },
            remove: {
                tooltip: {
                    text: 'انقر فوق الشكل لإزالته'
                }
            }
        }
    }
};