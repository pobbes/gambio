<?php

/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
 */


/* PREREQUREMENTS. Following files must be included before using this one
 *     /includes/yoochoose/functions.php
 */


/**
 * main function for getting recommendations
 *
 * @param <string> $scenario: the scenario name to provide recommendations from
 * @param <int> $context_id: an optional context item's id
 * @param <int> $max: max number of recommendations to be returned
 * @return <array> list of generic recommendation objects
 */
function recommend($scenario='also_purchased', $context_id=0, $max=4) {
    if ( ! (defined('YOOCHOOSE_ACTIVE') && YOOCHOOSE_ACTIVE)) { // sorry, register first!
        return;
    }
    
    global $breadcrumb;
    
    $category_path = getCurrentPath($breadcrumb);

    $user_id = getUserId();
    $reco_url = (getRecoServerUrl() . 
            "/ebl/recommendation/" . YOOCHOOSE_ID . '/' . $user_id . '/' . $scenario . '.json'.
            '?itemId=' . $context_id . "&numrecs=".($max * 2).'&categorypath='.$category_path);
    
    try {
        $json_result = load_json_url_ex($reco_url);
    
        just_log_recommendation(E_NOTICE, "Requesting recommendations from: ".$reco_url);
    
        $recommendations = $json_result->recommendationResponseList;
    
        just_log_recommendation(E_NOTICE, "Received " . count($recommendations) . " recommendations for user [$user_id] and item [$context_id] (before fsk18 filter).");
    
        return $recommendations;
    } catch (IOException $e) {
    	just_log_recommendation(E_ERROR, "IOError getting recommendations for user [$user_id] and item [$context_id].", $e);
    } catch (JSONException $e) {
        just_log_recommendation(E_ERROR, "JSONException getting recommendations for user [$user_id] and item [$context_id].", $e);
    } 
}



/**
 * user function for getting recommendations as gambio product objects
 *
 * @param <string> $scenario: the scenario name to provide recommendations from
 * @param <int> $context_id: an optional context item's id
 * @param <int> $max: max number of recommendations to be returned
 * @return <array> list of recommended gambio product objects
 */
function recommendItems($scenario='also_purchased', $context_id=0, $max=4) {
    if ( ! (defined('YOOCHOOSE_ACTIVE') && YOOCHOOSE_ACTIVE)) { // sorry, register first!
        return;
    }
    $recommendedItems = array();
    foreach (recommend($scenario, $context_id, $max) as $recommendation) {
        $recommendedItems[] = new product($recommendation->itemId);
        if (count($recommendedData) >= $max) {
        	break;
        }
    }

    return $recommendedItems;
}


/**
 * user function for getting recommendations as gambio data arrays
 *
 * @param <string> $scenario: the scenario name to provide recommendations from
 * @param <int> $context_id: an optional context item's id
 * @param <int> $max: max number of recommendations to be returned
 * @return <array> list of recommended gambio data arrays
 */
function recommendData($scenario='also_purchased', $context_id=0, $max=4) {
    if ( ! (defined('YOOCHOOSE_ACTIVE') && YOOCHOOSE_ACTIVE)) { // sorry, register first!
        return;
    }
    $recommendedData = array();
    if ($recomendedObjects = recommend($scenario, $context_id, $max)) {
	    foreach ( $recomendedObjects as $recommendation) {
	        $p = new product($recommendation->itemId);
	        if (!$p->isProduct()) {
	            $orfsk18 = $_SESSION['customers_status']['customers_fsk18_display']?'':' (or FSK18)';
	        	just_log_recommendation(E_WARNING, "Recommended product id [{$recommendation->itemId}] is not exists$orfsk18. Context ID is [$context_id].");
	        	continue;
            }
	        $data = $p->buildDataArray($p->data);
            $link=$data['PRODUCTS_LINK'];
            if (strpos($link,'?')>0) {
                $data['PRODUCTS_LINK'] = $link . '&ycr';
            } else {
                $data['PRODUCTS_LINK'] = $link . '?ycr';
            }
            $recommendedData[] = $data;
	        if (count($recommendedData) >= $max) {break;}
	    }
    }
    return $recommendedData;
}


function getUserId() {
    return empty($_SESSION['customer_id']) ? $_COOKIE['XTCsid'] : $_SESSION['customer_id'];
}
?>