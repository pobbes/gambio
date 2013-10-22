 <?php   
    ob_start ("ob_gzhandler");  

    header("Content-type: text/css; charset: UTF-8");  
    header("Cache-Control: must-revalidate");  

    # 60 * 60 sec = 1h; 24 * 14 = 14days
    $offset = 60 * 60 * 24 * 14 ;  

    $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";  

    header($ExpStr);  

    $tsstring = gmdate('D, d M Y H:i:s ', $timestamp) . 'GMT';
    $etag = md5($language . $timestamp);
    
    $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false;
    $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : false;
    if ((($if_none_match && $if_none_match == $etag) || (!$if_none_match)) &&
        ($if_modified_since && $if_modified_since == $tsstring))
    {
        header('HTTP/1.1 304 Not Modified');
        exit();
    }
    else
    {
        header("Last-Modified: $tsstring");
        header("ETag: \"{$etag}\"");
    }

?>  