<?php
/* --------------------------------------------------------------
Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]
--------------------------------------------------------------
*/
require_once ('class.KlarnaAPI.php');

class KlarnaProductPrice {
    private $api;
    private $path;
    private $webroot;
    private $logo;
    private $terms_link;
    private $eid;
    private $checkout;
    private $dpoint;

    public function __construct ($api, $eid, $path, $webroot, $checkout = null) {
        if (! $api instanceof Klarna) {
            throw new KlarnaApiException("api must be an instance of Klarna");
        }

        $this->terms_link = "#"; //replaced by NL to a different document
        $this->api = $api;
        $this->path = $path;
        $this->eid = $eid;
        $this->webroot = $webroot;
        if ($checkout !== null) {
            $this->checkout = $checkout;
        }
        $this->logo = null;
        $this->dpoint = null;
    }

    public function __setLogo($logo) {
        $this->logo = $logo;
    }

    public function __setDecimalPoint($dpoint) {
        $this->dpoint = $dpoint;
    }

    public function show($price, $currency, $country, $lang = null, $page = null, $setupValues = null) {
        if (!is_numeric ($country)) {
            $country = KlarnaCountry::fromCode ($country);
        } else {
            $country = intval ($country);
        }
        if ($price > 250 && (strtolower($country) == 'nl' ||
                                strtolower($country) == 'nld' ||
                                $country == KlarnaCountry::NL)) {
            return;
        }

        // we will always use the language for the country to get the correct
        // terms and conditions aswell as the correct name for 'Klarna Konto'
        $lang = KlarnaLanguage::getCode ($this -> api ->
            getLanguageForCountry ($country));

        if( $page === null || ($page != KlarnaFlags::PRODUCT_PAGE && $page != KlarnaFlags::CHECKOUT_PAGE)) {
            $page = KlarnaFlags::PRODUCT_PAGE;
        }

        if ( !$this->api->checkCountryCurrency($country, $currency)) {
            return false;
        }

        $types = array(KlarnaPClass::CAMPAIGN,
                    KlarnaPClass::ACCOUNT,
                    KlarnaPClass::FIXED);
        if ($this->checkout === null) {
            $this->checkout = new KlarnaAPI ($country, $lang, 'part', $price, $page, $this->api, $types, $this->path);
            $this->checkout->addSetupValue ('web_root', $this->webroot);
            $this->checkout->addSetupValue ('path_img', $this->webroot);
            $this->checkout->addSetupValue ('path_js', $this->webroot);
            $this->checkout->addSetupValue ('path_css', $this->webroot);
            if ($country  == KlarnaCountry::DE) {
                $this->checkout->addSetupValue ('asterisk', '*');
            }
            $this->checkout -> setCurrency($currency);
        }

        if (is_array($setupValues)) {
            foreach($setupValues as $name => $value) {
                $this->checkout->addSetupValue($name, $value);
            }
        }

        if ($price > 0 && count ($this->checkout->aPClasses) > 0) {
            $monthlyCost = array();
            $minRequired = array();

            $sMonthDefault = null;

            $sTableHtml = "";
            foreach ($this->checkout->aPClasses as $pclass) {
                if ($sMonthDefault === null || $pclass['monthlyCost'] < $sMonthDefault) {
                    if ($this->dpoint != null) {
                        $sMonthDefault = str_replace('.', $this->dpoint, $pclass['monthlyCost']);
                    } else {
                        $sMonthDefault = $pclass['monthlyCost'];
                    }
                }

                if ($pclass['pclass']->getType() == KlarnaPClass::ACCOUNT) {
                    $pp_title = $this->checkout->fetchFromLanguagePack('PPBOX_account', $lang, '/');
                } else {
                    $pp_title = $pclass['pclass']->getMonths() . " " . $this->checkout->fetchFromLanguagePack('PPBOX_th_month', $lang, '/');
                }
                $pp_price = $pclass['monthlyCost'];
                if ($this->dpoint != null) {
                    $pp_price = str_replace('.', $this->dpoint, $pp_price);
                }
                $sTableHtml .= $this->checkout->retrieveHTML(null, array('pp_title' => html_entity_decode ($pp_title), 'pp_price' => $pp_price), $this->path . 'html/pp_box_template.html');
            }
            $notice = (($page == KlarnaFlags::CHECKOUT_PAGE || $this->logo=="short") ? "notice_nl_cart.jpg" : "notice_nl.jpg");
            $aInputValues    = array();
            $aInputValues['defaultMonth']   = $sMonthDefault;
            $aInputValues['monthTable']     = $sTableHtml;
            $aInputValues['eid']            = $this->eid;
            $aInputValues['country']        = KlarnaCountry::getCode ($country);
            $aInputValues['nlBanner']       = (($country == KlarnaCountry::NL) ? '<div class="nlBanner"><img src="'.$this->webroot.'checkout/'.$notice.'" /></div>' : "");

            return $this->checkout->retrieveHTML($aInputValues, null, $this->path . 'html/productPrice/layout.html');
        }
    }
}

