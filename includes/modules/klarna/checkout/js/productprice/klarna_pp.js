/* --------------------------------------------------------------
Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]
--------------------------------------------------------------
*/
if (typeof jQuery.prototype.closest == "undefined") {
    jQuery.prototype.closest = jQuery.prototype.parents;
}

KlarnaProductInfo = function(info) {
    for(key in info) {
        this[key] = info[key];
    }
};

KlarnaProductInfo.prototype.initPartPaymentBox = function() {
    ppBoxInMotion = false;
    jQuery('.klarna_PPBox_pull,.klarna_PPBox_top').unbind('click').click(function () {
        var kBox = jQuery(this).closest('.klarna_PPBox');
        if(!ppBoxInMotion) {
            ppBoxInMotion = true;
            kBox.find('.klarna_PPBox_bottom').slideToggle('fast', function() {
                if(kBox.find('.nlBanner').length) {
                    var bannerPosition = kBox.find('.nlBanner').offset();
                    bannerPosition.top += kBox.find('.klarna_PPBox_bottom:visible').height();
                    bannerPosition.top -= kBox.find('.klarna_PPBox_bottom').not(':visible').height();
                    kBox.find('.nlBanner').offset(bannerPosition);
                }
                ppBoxInMotion = false;
            });
        }
    });
}

KlarnaProductInfo.prototype.update = function() {
    data = {
        action: 'updateProductPrice',
        country: this.countryCode,
        sum: this.sum,
        type: 'part'
    }
    var init = this.initPartPaymentBox;
    jQuery.ajax({
        type: "GET",
        url: this.ajax_path,
        data: data,
        success: function(response){
            var ppBox = jQuery('div[class="klarna_PPBox"]');
            var newInner = jQuery(response).find('div[class="klarna_PPBox_inner"]');
            ppBox.find('div[class="klarna_PPBox_inner"]').replaceWith(newInner);
            init();
        }
    });
}

window.klarnaPP = new function() {
    if (typeof klarna_product != 'undefined') {
        this.product = new KlarnaProductInfo(klarna_product);
    }
}

jQuery(document).ready(function () {
    klarnaPP.product.initPartPaymentBox();
});
