<?php
/* --------------------------------------------------------------
   LoadUrl.php 2012-11-14 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

class LoadUrl
{
	// an url
	var $v_url;

	/*
	 * load the url
	 */
	function load_url($p_url, $p_header_array = array(), $p_iframe_params = '', $p_ssl_verifypeer = null, $p_ssl_verifyhost = null, $p_ssl_version = null)
	{
		// link to news server
		$this->v_url = $p_url;
		
		$t_iframe = false;
		
		// check what to use - curl, stream or, last chance, iframe
		if(function_exists('curl_init')) {
			$data = $this->use_curl($p_header_array, $p_ssl_verifypeer, $p_ssl_verifyhost, $p_ssl_version);
		} else {
			$data = $this->use_stream($p_header_array);

			if($data === false)
			{
				$t_iframe = true;
				$data = $this->use_iframe($p_iframe_params);
			}
		}
		
		return $data;
	}

	/*
	 * get url by curl
	 */
	function use_curl($p_header_array = array(), $p_ssl_verifypeer = null, $p_ssl_verifyhost = null, $p_ssl_version = null) {
		// init curl
		$ch = curl_init();
		// set curl options
		curl_setopt($ch, CURLOPT_URL, $this->v_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		
		if(substr((string)$this->v_url, 0, 5) == 'https')
		{
			if($p_ssl_verifypeer !== null)
			{
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, (bool)$p_ssl_verifypeer);
			}
			
			if($p_ssl_verifyhost !== null)
			{
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, (bool)$p_ssl_verifyhost);
			}
			
			if($p_ssl_version !== null)
			{
				curl_setopt($ch, CURLOPT_SSLVERSION, (int)$p_ssl_version);
			}
		}		
		
		if(!empty($p_header_array) && is_array($p_header_array))
		{
			foreach($p_header_array AS $t_header_data)
			{
				curl_setopt($ch, CURLOPT_HTTPHEADER, array($t_header_data));
			}
		}
		// execute curl
		$data = curl_exec($ch);
		// if curl error, return false
		if(curl_errno($ch)) {
			$data = false;
		}
		// close curl
		curl_close($ch);

		return $data;
	}

	/*
	 * get url by stream
	 */
	function use_stream($p_header_array = array()) {
		// set options
		$options = array(
			'http' => array(
			'method' => 'POST',
			'header' => "Content-type: application/x-www-form-urlencoded\r\n"));

		// get content
		$request	= stream_context_create($options);
		$response	= @file_get_contents($this->v_url, false, $request);

		$data = false;
		if($response) {
			$data = $response;
		}

		return $data;
	}

	/*
	 * get url in iframe
	 */
	function use_iframe($p_iframe_params) 
	{
		$c_iframe_params = 'width="100%" height="1000px" scrolling="yes" frameborder="0"';
		if(!empty($p_iframe_params))
		{
			$c_iframe_params = (string)$p_iframe_params;
		}		
		
		$data = '<iframe src="' . $this->v_url . '" ' . $c_iframe_params . '></iframe>';
		return $data;
	}
}