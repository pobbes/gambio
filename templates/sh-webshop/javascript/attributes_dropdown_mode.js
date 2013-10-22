/* <?php
#   --------------------------------------------------------------
#   attributes_dropdown_mode.js 2012-03-27 tb@gambio
#   Gambio GmbH
#   http://www.gambio.de
#   Copyright (c) 2012 Gambio GmbH
#   Released under the GNU General Public License (Version 2)
#   [http://www.gnu.org/licenses/gpl-2.0.html]
#   --------------------------------------------------------------
?>*/
/*<?php
if($GLOBALS['coo_debugger']->is_enabled('uncompressed_js') == false)
{
?>*/
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(4($){$.1A.1j=4(o){5 p=1k,11=y z(),12=y z(),U=1l;3((13==0&&1B==L)||13==2){U=L}$.8(1m,4(a,b){5 c=y z();1n(5 i=0;i<=b.M.I-1;i++){c.v(b.M[i].1o)}11.v(\',\'+c.14()+\',\')});$.8(1m,4(a,b){3(U&&b.1C>0){5 c=y z();1n(5 i=0;i<=b.M.I-1;i++){c.v(b.M[i].1o)}12.v(\',\'+c.14()+\',\')}});3($.A.V){3($.A.W=="7.0"){5 q=y z();$.8($(p).r("w"),4(c,d){q[c]=y z();$.8($(d).r("u"),4(a,b){q[c][$(b).B()]=$(b).1S()})})}}$(p).r("w").1D("1E",4(){1p(1k)});1p($("D.1T",p));4 1p(h){3(o=="X"){$("u",p).C("J","J");$("u[N=0]",p).1q("J")}s{$(h).E().O(\'1F\').P(\'Q\',\'1G\');$(h).E().O(\'6\').P(\'Q\',\'1G\');$(".K").r("1F:1H(0)").P("Q","15");$(".K").r("6:1H(0)").P("Q","15");$(h).E().O(\'6\').r("w").B(0);$(h).E().O(\'6\').r("u").C("J","J");$("u[N=0]",p).1q("J")}5 i=y z();$.8($(p).r("w"),4(a,b){i.v($(b).B())});5 j=\',\'+i.14()+\',\';3($.A.V){3($.A.W=="7.0"){3(o=="X"){$(p).r("w").16()}s{$(h).E().O("6").r("w").16()}5 k=$(p).r("w");$.8(k,4(c,d){3($(d).r("u").I==0){$.8(q[c],4(a,b){3(b!=1U){$(d).1V($("<u N=\'"+a+"\'>"+b+"</u>"))}});$(d).B(i[c])}})}}5 l=j.1I(/,0/g,\',[0-9]+\'),R=y z();3(U){$.8(12,4(a,b){5 c=b.17((l));3(c!=18){R.v(c[0])}})}s{$.8(11,4(a,b){5 c=b.17((l));3(c!=18){R.v(c[0])}})}$.8(i,4(d,e){5 f=i.1W(0);$.8(i,4(a,b){3(e==b&&b!=0){f[a]=\'([0-9]+)\'}s 3(b==0){f[a]=\'[0-9]+\'}});3(f[d]!=\'[0-9]+\'){5 g=f.14();3(U){$.8(12,4(a,b){5 c=b.17((g));3(c!=18){R.v(c[1])}})}s{$.8(11,4(a,b){5 c=b.17((g));3(c!=18){R.v(c[1])}})}}});3($.A.V){3($.A.W=="7.0"){5 m=y z()}}$.8(R,4(c,d){5 e=d.1J(\',\');$.8(e,4(a,b){3($.A.V){3($.A.W=="7.0"){m.v(1r(b))}}$("u[N="+b+"]",p).1q("J")})});3($.A.V){3($.A.W=="7.0"){5 n;3(o=="X"){n=$(p).r("u")}s{n=$(h).E().O("6").r("u")}$.8(n,4(a,b){3($.1K(1r($(b).B()),m)==-1&&1r($(b).B())!=0){$("u[N="+$(b).B()+"]",p).1X()}})}}3(o!="X"){3($(h).B()!=0){$(h).E().Y().P(\'Q\',\'15\');$(h).E().Y().Y().P(\'Q\',\'15\');$(h).E().Y().Y().r(\'w\').B(0)}}}}})(1L);(4($){$.1A.1M=4(){5 g=1k,1s=$("6.19 D.1a").t(),1t=$("6.x F").C("S"),1b=$("6.x D.1c").t(),1u=$("#1d").t(),G=$("6.1e").t();$(g).r("w").1D("1E",4(){3($(g).r("w[N=0]").I==0){5 d=y z(),1f="",Z="",1g="",10="",1h="",H="",1v=1l;$.8($(g).r("w"),4(a,b){d.v($(b).B())});$("#1w").1i();$("#1x").1i();$.8(1m,4(a,b){5 c=L;1n(5 i=0;i<=b.M.I-1;i++){3($.1K(b.M[i].1o,d)==-1){c=1l}}3(c){1v=L;1f=b.1Y;3((13==0&&1B==L)||13==2){Z=b.1C;3(Z==0){$("#1w").1N()}}3(1Z==1){1g=b.20;10=b.21}1h=b.22;3(b.23=="L"){3(b.T==\'\'&&G==\'-\'){H=G}s 3(b.T==\'\'){H=G}s 3(G==\'-\'){H=b.T}s{H=G+\'-\'+b.T}}s{3(b.T!=""){H=b.T}s{H=G}}}});3(!1v){$("#1x").1N()}3(1f!=""){5 e=$("<F></F>").C("S","24/25/26/"+1f);$("#1y").t(e)}s{$("#1y").16()}3(Z!=""){$("6.19 D.1a").t(Z)}s{$("6.19 D.1a").t(1s)}3(1g!=""){5 f=$("6.x F").C("S"),1z=f.1J("/"),1O=f.1I(1z[1z.I-1],1g);$("6.x F").C("S",1O);$("6.x F").C("1P",10)}s{$("6.x F").C("S",1t);$("6.x F").C("1P",1b)}3(10!=""){$("6.x D.1c").t(10)}s{$("6.x D.1c").t(1b)}3(1h!=""){$("#1d").t(1h)}s{$("#1d").t(1u)}3(H!=""){$("6.1e").t(H)}s{$("6.1e").t(G)}}s{$("#1w").1i();$("#1x").1i();$("#1y").16();$("6.19 D.1a").t(1s);$("6.x F").C("S",1t);$("6.x D.1c").t(1b);$("#1d").t(1u);$("6.1e").t(G)}})}})(1L);$(27).28(4(){3($(".K.1Q").I==1){$(".K.1Q").1j("X")}3($(".K.1R").I==1){$(".K.1R").1j("29")}$(".K").1M()});',62,134,'|||if|function|var|dd||each|||||||||||||||||||find|else|html|option|push|select|shipping_time|new|Array|browser|val|attr|span|parent|img|t_default_products_model|t_products_model|length|disabled|details_attributes_dropdown|true|COMBIS_VALUES|value|nextAll|css|visibility|t_match_array|src|combi_model|v_active_stock_check|msie|version|mode_1|next|t_combi_quantity|t_shipping_time_value|v_combis_exists_array|v_combis_available_array|use_properties_combis_quantity|toString|visible|empty|match|null|products_quantity|products_quantity_value|t_default_shipping_time_value|products_shipping_time_value|gm_calc_weight|products_model|t_combi_image|t_shipping_time_image|t_combi_weight|hide|attributes_dropdown_mode|this|false|properties_combis_json|for|properties_values_id|changeValues|removeAttr|parseInt|t_default_combi_quantity_value|t_default_shipping_time_image|t_default_combi_weight|t_combi_exists|properties_not_available_error|properties_not_exist_error|gm_attribute_images|t_image_path_split|fn|properties_stock_check|combi_quantity|bind|change|dt|hidden|eq|replace|split|inArray|jQuery|attributes_check|show|t_new_image_path|alt|dropdown_mode_1|dropdown_mode_2|text|select_fake|undefined|append|slice|remove|combi_image|use_properties_combis_shipping_time|combi_shipping_status_image|combi_shipping_status_name|combi_weight|append_products_model|images|product_images|properties_combis_images|document|ready|mode_2'.split('|'),0,{}));
/*<?php
}
else
{
?>*/ 
(function($){
    $.fn.attributes_dropdown_mode = function(p_dropdown_mode){
		var self = this;
		var v_combis_exists_array = new Array();
		var v_combis_available_array = new Array();
        var v_active_stock_check = false;
        
        if((use_properties_combis_quantity == 0 && properties_stock_check == true) || use_properties_combis_quantity == 2){
            v_active_stock_check = true;
        }
		
		$.each(properties_combis_json, function(t_properties_combis_key, t_properties_combis_value){
            var $t_combis_values_array = new Array();
            for(var i = 0; i <= t_properties_combis_value.COMBIS_VALUES.length-1; i++){
                $t_combis_values_array.push(t_properties_combis_value.COMBIS_VALUES[i].properties_values_id);
            }
            v_combis_exists_array.push(','+$t_combis_values_array.toString()+',');
		});
        
        $.each(properties_combis_json, function(t_properties_combis_key, t_properties_combis_value){
			if(v_active_stock_check && t_properties_combis_value.combi_quantity > 0){
				var $t_combis_values_array = new Array();
				for(var i = 0; i <= t_properties_combis_value.COMBIS_VALUES.length-1; i++){
					$t_combis_values_array.push(t_properties_combis_value.COMBIS_VALUES[i].properties_values_id);
				}
				v_combis_available_array.push(','+$t_combis_values_array.toString()+',');
			}
		});
		
		if($.browser.msie){
			if($.browser.version == "7.0"){
				var v_option_values_origin = new Array();
				$.each($(self).find("select"), function(t_select_key, t_select_value){
					v_option_values_origin[t_select_key] = new Array();
					$.each($(t_select_value).find("option"), function(t_option_key, t_option_value){
						v_option_values_origin[t_select_key][$(t_option_value).val()] = $(t_option_value).text();
					});
				});
			}
		}
                
        $(self).find("select").bind("change", function(){
            changeValues(this);
        });

        changeValues($("span.select_fake", self));

		function changeValues(t_actual_select){
			if(p_dropdown_mode == "mode_1"){
                $("option", self).attr("disabled", "disabled");
                $("option[value=0]", self).removeAttr("disabled");
			}else{
				$(t_actual_select).parent().nextAll('dt').css('visibility', 'hidden');
				$(t_actual_select).parent().nextAll('dd').css('visibility', 'hidden');
				$(".details_attributes_dropdown").find("dt:eq(0)").css("visibility", "visible");
				$(".details_attributes_dropdown").find("dd:eq(0)").css("visibility", "visible");
				$(t_actual_select).parent().nextAll('dd').find("select").val(0);
                $(t_actual_select).parent().nextAll('dd').find("option").attr("disabled", "disabled");
                $("option[value=0]", self).removeAttr("disabled"); 
			}
			
			var t_select_values_array = new Array();

			$.each($(self).find("select"), function(key1, value1){
				t_select_values_array.push($(value1).val());
			});

			var t_select_values_string = ','+t_select_values_array.toString()+',';
			
			if($.browser.msie){
				if($.browser.version == "7.0"){
					if(p_dropdown_mode == "mode_1"){
						$(self).find("select").empty();
					}else{
						$(t_actual_select).parent().nextAll("dd").find("select").empty();
					}
					var selects = $(self).find("select");
					$.each(selects, function(select_key, select_value){
						if($(select_value).find("option").length == 0){
							$.each(v_option_values_origin[select_key], function(t_option_origin_key, t_option_origin_value){
								if(t_option_origin_value != undefined){
									$(select_value).append($("<option value='"+t_option_origin_key+"'>"+t_option_origin_value+"</option>"));
								}
							});
							$(select_value).val(t_select_values_array[select_key]);
						}
					});
				}
			}

			// PREPARE FOR REGEX #1
			var t_reg1_select_values_string = t_select_values_string.replace(/,0/g, ',[0-9]+');
			
			var t_match_array = new Array();
			
            if(v_active_stock_check){
                $.each(v_combis_available_array, function(combis_key, combis_value){
                    var t_matches = combis_value.match((t_reg1_select_values_string));
                    if(t_matches != null){
                        t_match_array.push(t_matches[0]);
                    }
                });
            }else{
                $.each(v_combis_exists_array, function(combis_key, combis_value){
                    var t_matches = combis_value.match((t_reg1_select_values_string));
                    if(t_matches != null){
                        t_match_array.push(t_matches[0]);
                    }
                });
            }
			
			// PREPARE FOR REGEX #2
			$.each(t_select_values_array, function(select_value_key, select_value_value){
				var t_tmp_select_values_array = t_select_values_array.slice(0);
				$.each(t_select_values_array, function(select_value_key2, select_value_value2){
					if(select_value_value == select_value_value2 && select_value_value2 != 0){
						t_tmp_select_values_array[select_value_key2] = '([0-9]+)';
					}else if(select_value_value2 == 0){
						t_tmp_select_values_array[select_value_key2] = '[0-9]+';
					}
				});
				
				if(t_tmp_select_values_array[select_value_key] != '[0-9]+'){
					var t_reg2_select_values_string = t_tmp_select_values_array.toString();
                    
                    if(v_active_stock_check){
                        $.each(v_combis_available_array, function(combis_key, combis_value){
                            var t_matches = combis_value.match((t_reg2_select_values_string));
                            if(t_matches != null){
                                t_match_array.push(t_matches[1]);
                            }
                        });
                    }else{
                        $.each(v_combis_exists_array, function(combis_key, combis_value){
                            var t_matches = combis_value.match((t_reg2_select_values_string));
                            if(t_matches != null){
                                t_match_array.push(t_matches[1]);
                            }
                        });
                    }   
				}
			});

			if($.browser.msie){
				if($.browser.version == "7.0"){
					var t_valid_options_array = new Array();
				}
			}
                        
         
            $.each(t_match_array, function(match_key, match_value){
                var t_properties_id_array = match_value.split(',');
                $.each(t_properties_id_array, function(properties_id_key, properties_id_value){
                    if($.browser.msie){
                        if($.browser.version == "7.0"){
                            t_valid_options_array.push(parseInt(properties_id_value));
                        }
                    }
                    $("option[value="+properties_id_value+"]", self).removeAttr("disabled");
                });
            });

            if($.browser.msie){
                if($.browser.version == "7.0"){
                    var t_options;
                    if(p_dropdown_mode == "mode_1"){
                            t_options = $(self).find("option");
                    }else{
                            t_options = $(t_actual_select).parent().nextAll("dd").find("option");
                    }
                    $.each(t_options, function(option_key, option_value){
                        if($.inArray(parseInt($(option_value).val()), t_valid_options_array) == -1 && parseInt($(option_value).val()) != 0){
                            $("option[value="+$(option_value).val()+"]", self).remove();
                        }
                    });
                }
            }
            

			if(p_dropdown_mode != "mode_1"){
				if($(t_actual_select).val() != 0){
					$(t_actual_select).parent().next().css('visibility', 'visible');
					$(t_actual_select).parent().next().next().css('visibility', 'visible');
					$(t_actual_select).parent().next().next().find('select').val(0);
				}
			}
		}
	};  
})(jQuery);

(function($){
    $.fn.attributes_check = function(){  
		var self = this;
		var t_default_combi_quantity_value = $("dd.products_quantity span.products_quantity_value").html();
		var t_default_shipping_time_image = $("dd.shipping_time img").attr("src");
		var t_default_shipping_time_value = $("dd.shipping_time span.products_shipping_time_value").html();
		var t_default_combi_weight = $("#gm_calc_weight").html();
		var t_default_products_model = $("dd.products_model").html();
		        		
		$(self).find("select").bind("change", function(){
			
			if($(self).find("select[value=0]").length == 0){
				var t_select_values_array = new Array();
				
				var t_combi_image = "";
				var t_combi_quantity = "";
				var t_shipping_time_image = "";
				var t_shipping_time_value = "";
				var t_combi_weight = "";
				var t_products_model = "";
                var t_combi_exists = false;
				
				$.each($(self).find("select"), function(key1, value1){
					t_select_values_array.push($(value1).val());
				});
				
				$("#properties_not_available_error").hide();
                $("#properties_not_exist_error").hide();
				
				$.each(properties_combis_json, function(t_properties_combis_key, t_properties_combis_value){
					
                    var $t_actual_combi_status = true;

                    for(var i = 0; i <= t_properties_combis_value.COMBIS_VALUES.length-1; i++){	
                        if($.inArray(t_properties_combis_value.COMBIS_VALUES[i].properties_values_id, t_select_values_array) == -1){
                            $t_actual_combi_status = false;
                        }
                    }

                    if($t_actual_combi_status){
                        
                        t_combi_exists = true;

                        t_combi_image = t_properties_combis_value.combi_image;
                        if((use_properties_combis_quantity == 0 && properties_stock_check == true)|| use_properties_combis_quantity == 2){
                            t_combi_quantity = t_properties_combis_value.combi_quantity;   
                            if(t_combi_quantity == 0){
                                    $("#properties_not_available_error").show();
                            }                                                   
                        }
                        if(use_properties_combis_shipping_time == 1){
                            t_shipping_time_image = t_properties_combis_value.combi_shipping_status_image;
                            t_shipping_time_value = t_properties_combis_value.combi_shipping_status_name;                                                
                        }		

                        t_combi_weight = t_properties_combis_value.combi_weight;

                        if(t_properties_combis_value.append_products_model == "true"){
                            if(t_properties_combis_value.combi_model == '' && t_default_products_model == '-'){
                                t_products_model = t_default_products_model;
                            }else if(t_properties_combis_value.combi_model == ''){
                                t_products_model = t_default_products_model;
                            }else if(t_default_products_model == '-'){
                                t_products_model = t_properties_combis_value.combi_model;
                            }else{
                                t_products_model = t_default_products_model + '-' + t_properties_combis_value.combi_model;
                            }
                        }else{
                            if(t_properties_combis_value.combi_model != ""){
                                t_products_model = t_properties_combis_value.combi_model;
                            }else{
                                t_products_model = t_default_products_model;
                            }
                        }				
					}
				});
                
                if(!t_combi_exists){
                    $("#properties_not_exist_error").show();
                }
				
				if(t_combi_image != ""){
					var t_image = $("<img></img>").attr("src", "images/product_images/properties_combis_images/"+t_combi_image);
					$("#gm_attribute_images").html(t_image);
				}else{
					$("#gm_attribute_images").empty();
				}
				
                if(t_combi_quantity != ""){
					$("dd.products_quantity span.products_quantity_value").html(t_combi_quantity);
				}else{
                    $("dd.products_quantity span.products_quantity_value").html(t_default_combi_quantity_value);
                }
				
				if(t_shipping_time_image != ""){
					var t_image_path = $("dd.shipping_time img").attr("src");
					var t_image_path_split = t_image_path.split("/");
					var t_new_image_path = t_image_path.replace(t_image_path_split[t_image_path_split.length-1], t_shipping_time_image);
					$("dd.shipping_time img").attr("src", t_new_image_path);
					$("dd.shipping_time img").attr("alt", t_shipping_time_value);
				}else{
					$("dd.shipping_time img").attr("src", t_default_shipping_time_image);
					$("dd.shipping_time img").attr("alt", t_default_shipping_time_value);
				}
				
				if(t_shipping_time_value != ""){
					$("dd.shipping_time span.products_shipping_time_value").html(t_shipping_time_value);
				}else{
					$("dd.shipping_time span.products_shipping_time_value").html(t_default_shipping_time_value);
				}
				
				if(t_combi_weight != ""){
					$("#gm_calc_weight").html(t_combi_weight);
				}else{
                    $("#gm_calc_weight").html(t_default_combi_weight);
                }
				
				if(t_products_model != ""){
					$("dd.products_model").html(t_products_model);
				}else{
					$("dd.products_model").html(t_default_products_model);
				}
				
			}else{
				$("#properties_not_available_error").hide();
                $("#properties_not_exist_error").hide();
				$("#gm_attribute_images").empty();
				$("dd.products_quantity span.products_quantity_value").html(t_default_combi_quantity_value);
				$("dd.shipping_time img").attr("src", t_default_shipping_time_image);
				$("dd.shipping_time span.products_shipping_time_value").html(t_default_shipping_time_value);
				$("#gm_calc_weight").html(t_default_combi_weight);
				$("dd.products_model").html(t_default_products_model);
			}
		});
	};  
})(jQuery);

$(document).ready(function()
{
	if($(".details_attributes_dropdown.dropdown_mode_1").length == 1){
		$(".details_attributes_dropdown.dropdown_mode_1").attributes_dropdown_mode("mode_1");
	}
	
	if($(".details_attributes_dropdown.dropdown_mode_2").length == 1){
		$(".details_attributes_dropdown.dropdown_mode_2").attributes_dropdown_mode("mode_2");
	}
	
	$(".details_attributes_dropdown").attributes_check();
});

/*<?php
}
?>*/