 $(function () {
            //数据可以动态生成，格式自己定义，cha对应china-zh.js中省份的简称
            var dataStatus = [{ cha: 'HKG', name: '香港', des: '<br/>无活动点',tel:'TAXI Find Us' },
                             { cha: 'HAI', name: '海南', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'YUN', name: '云南', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'BEJ', name: '北京', des: '<br/>2个活动点' ,tel:'TAXI Find Us' },
                             { cha: 'TAJ', name: '天津', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'XIN', name: '新疆', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'TIB', name: '西藏', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'QIH', name: '青海', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'GAN', name: '甘肃', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'NMG', name: '内蒙古', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'NXA', name: '宁夏', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'SHX', name: '山西', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'LIA', name: '辽宁', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'JIL', name: '吉林', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'HLJ', name: '黑龙江', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'HEB', name: '河北', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'SHD', name: '山东', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'HEN', name: '河南', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'SHA', name: '陕西', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'SCH', name: '四川', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'CHQ', name: '重庆', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'HUB', name: '湖北', des: '<br/>1个活动点' ,tel:'TAXI Find Us' },
                             { cha: 'ANH', name: '安徽', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'JSU', name: '江苏', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'SHH', name: '上海', des: '<br/>1个活动点' ,tel:'TAXI Find Us' },
                             { cha: 'ZHJ', name: '浙江', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'FUJ', name: '福建', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'TAI', name: '台湾', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'JXI', name: '江西', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'HUN', name: '湖南', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'GUI', name: '贵州', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'GXI', name: '广西', des: '<br/>无活动点' ,tel:'TAXI Find Us' }, 
                             { cha: 'GUD', name: '广东', des: '<br/>无活动点',tel:'TAXI Find Us' }];
			
			var beijing = [{ cha: 'BJSQ', name: '北京市区', des: '<br/>无活动点',tel:'TAXI Find Us' },
                             { cha: 'CHANGPING', name: '昌平区', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'DAXING', name: '大兴区', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'FANGSHAN', name: '房山县', des: '<br/>2个活动点' ,tel:'TAXI Find Us' },
                             { cha: 'HUAIROU', name: '怀柔区', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'MENTOUGOU', name: '门头沟区', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'MIYUN', name: '密云县', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'PINGGU', name: '平谷县', des: '<br/>无活动点',tel:'TAXI Find Us'  },
                             { cha: 'SHUNYI', name: '顺义区', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'TONGZHOU', name: '通州区', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                             { cha: 'YANQING', name: '延庆县', des: '<br/>无活动点' ,tel:'TAXI Find Us' },
                          ];
			
            $('#container').vectorMap({ map: 'china_zh',
                color: "#B4B4B4", //地图颜色
                onLabelShow: function (event, label, code) {//动态显示内容
                    $.each(dataStatus, function (i, items) {
                        if (code == items.cha) {
                            label.html(items.name + items.des +"<br/>"+ items.tel);
                        }
                    });
                }
				
            })
			
			$('#container1').vectorMap({ map: 'beijing-zh',
                color: "#B4B4B4", //地图颜色
                onLabelShow: function (event, label, code) {//动态显示内容
                    $.each(beijing, function (i, items) {
                        if (code == items.cha) {
                            label.html(items.name + items.des +"<br/>"+ items.tel);
                        }
                    });
                }
				
            })
			
            $.each(dataStatus, function (i, items) {
                if (items.des.indexOf('个') != -1) {//动态设定颜色，此处用了自定义简单的判断
                    var josnStr = "{" + items.cha + ":'#00FF00'}";
                    $('#container').vectorMap('set', 'colors', eval('(' + josnStr + ')'));
                }
            });
            $('.jvectormap-zoomin').click(); //放大
        });