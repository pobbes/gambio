<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
?>

<div style="padding: 20px 40px 40px 40px;" class="yoo-image2-large">

<h2>FAQ</h2>


<a name="styleedit"></a>
<p class="question" style="margin-right: 300px; margin-top: 1.5em;" >
1. Why it is not possible to activate or deactivate the side boxes with recommendations? 
Checkbox is disabled.
</p>
<p style="margin-right: 300px;">
Recommendations side boxes can be activated or deactivated over the Web-Interface only
if the StyleEdit plug-in is installed. See the Gambio installation manual for more information.  
Without the StyleEdit plugin is is still possible to control the side boxes manually over the 
file <code>template_settings.php</code> in your template folder on the web server.
</p>


<a name="firewall"></a>

<p class="question" style="margin-right: 300px;">
2. I have a connectivity problems with YOOCHOOSE Servers. The license key or statistik cannot be loaded.
<p>
Your Web Server must have an access to two of our Servers over the HTTP protokol (Port 80):
Recommendation Server (<?php echo YOOCHOOSE_RECO_SERVER_DEFAULT; ?>) and Configuration Server
(<?php echo YOOCHOOSE_REG_SERVER_DEFAULT; ?>). Please check your Firewall configuration.
You can test your configuration <a href="yoochoose.php?page=check">here</a>.
</p>

</div>