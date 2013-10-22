/* social_share_plugin.js <?php
#   --------------------------------------------------------------
#   social_share_plugin.js 2012-09-24 tb@gambio
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
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(5($){$.x.j=5(){e c=$(6),2=$(k).7(\'y\').3(/[&]*z(=|\\/)[a-A-B-9,-]+/g,\'\');2=2.3(/\\?&/g,\'?\');2=2.3(/\\?$/g,\'\');e d=f(2),l=f(8.m.C+$("#n .D E").7(\'F\')),o=f(8.m.G+\' - \'+$.H($("#n .I J").h()+\'  \'));$.K(c,5(){$(6).L("M",5(){p(6)});N 6});5 p(a){e b="",1="";q($(a).4().O("i")){$(a).4().P("i");b=\'8.r.\'+$(a).4().7(\'s\')+\'.Q\';$(a).4().t(".u").h(v(b))}R{$(a).4().S("i");1=\'8.r.\'+$(a).4().7(\'s\')+\'.T\';1=v(1);1=1.3(\'#U#\',o);1=1.3(\'#V#\',l);1=1.3(\'#k#\',2);1=1.3(\'#W#\',d);$(a).4().t(".u").h(1)}}}})(X);$(Y).Z(5(){q($(".w").10>0){$(".w").j()}});',62,63,'|t_code|v_location|replace|parent|function|this|attr|js_options||||||var|encodeURIComponent||html|switch_on|social_share_plugin|location|v_product_image|global|product_info|v_product_text|update_view|if|social_share|id|find|social_share_content|eval|social_share_image|fn|href|XTCsid|zA|Z0|shop_root|info_image_box|img|src|shop_name|trim|info|h1|each|bind|click|return|hasClass|removeClass|image|else|addClass|code|text|product_image|location_encoded|jQuery|document|ready|length'.split('|'),0,{}));
/*<?php
}
else
{
?>*/
(function($){
    $.fn.social_share_plugin = function(){         

        var self = $(this);
        var v_location = $(location).attr('href').replace(/[&]*XTCsid(=|\/)[a-zA-Z0-9,-]+/g, '');
        v_location = v_location.replace(/\?&/g, '?');
        v_location = v_location.replace(/\?$/g, '');        
        var v_location_encoded = encodeURIComponent(v_location);
        var v_product_image = encodeURIComponent(js_options.global.shop_root + $("#product_info .info_image_box img").attr('src'));
        var v_product_text = encodeURIComponent(js_options.global.shop_name + ' - ' + $.trim($("#product_info .info h1").html() + '  '));
        
        $.each(self, function(){
            $(this).bind("click", function(){
                update_view(this);
            });
            return this;
        });
        
        function update_view(p_element){
            var t_image = "";
            var t_code = "";

            if($(p_element).parent().hasClass("switch_on")){
                $(p_element).parent().removeClass("switch_on");

                t_image = 'js_options.social_share.'+$(p_element).parent().attr('id')+'.image';
                $(p_element).parent().find(".social_share_content").html(eval(t_image));
            }else{
                $(p_element).parent().addClass("switch_on");

                t_code = 'js_options.social_share.'+$(p_element).parent().attr('id')+'.code';
                t_code = eval(t_code);
                t_code = t_code.replace('#text#', v_product_text);
                t_code = t_code.replace('#product_image#', v_product_image);
                t_code = t_code.replace('#location#', v_location);
                t_code = t_code.replace('#location_encoded#', v_location_encoded);
                $(p_element).parent().find(".social_share_content").html(t_code);
            }
        }
         
    };  
})(jQuery);

$(document).ready(function()
{
	if($(".social_share_image").length > 0){
		$(".social_share_image").social_share_plugin();
	}
});
/*<?php
}
?>*/