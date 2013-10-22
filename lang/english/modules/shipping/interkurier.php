<?php
/* -----------------------------------------------------------------------------------------
  Interkurier Shipping Method
  Copyright Web-Work24.de
  
   ---------------------------------------------------------------------------------------*/
   




define('MODULE_SHIPPING_INTERKURIER_TEXT_TITLE', 'Interkurier Express ');
define('MODULE_SHIPPING_INTERKURIER_TEXT_DESCRIPTION', 'Interkurier Express - shippingmodules'); //Interkurier Express - Versandmodul
define('MODULE_SHIPPING_INTERKURIER_TEXT_WAY', 'Interkurier shippingcosts (Express)'); //Interkurier Versandkosten (Express)
define('MODULE_SHIPPING_INTERKURIER_TEXT_UNITS', ' '); //Gewichtsabhängig
define('MODULE_SHIPPING_INTERKURIER_INVALID_ZONE', 'It is unfortunately no shipping into this country possible');
define('MODULE_SHIPPING_INTERKURIER_UNDEFINED_RATE', 'shipping cost cannot be calculated');
define('MODULE_SHIPPING_INTERKURIER_NOTIFICATION_TITLE','Automatic customer notification');
define('MODULE_SHIPPING_INTERKURIER_NOTIFICATION_DESC','Customer notification on modification of the status "express dispatch approved"');
define('MODULE_SHIPPING_INTERKURIER_FETCH_FIRM_TITLE','Package fetching address: <br>Firm name');
define('MODULE_SHIPPING_INTERKURIER_FETCH_FIRM_DESC','Indicate to your firm names');
define('MODULE_SHIPPING_INTERKURIER_FETCH_NAME_TITLE','Pre-surname');
define('MODULE_SHIPPING_INTERKURIER_FETCH_NAME_DESC','Indicate to your pre and surnames');
define('MODULE_SHIPPING_INTERKURIER_FETCH_PHONE_TITLE','Phonenumber');
define('MODULE_SHIPPING_INTERKURIER_FETCH_PHONE_DESC','Indicate your telephone number');
define('MODULE_SHIPPING_INTERKURIER_FETCH_EMAIL_TITLE','email');
define('MODULE_SHIPPING_INTERKURIER_FETCH_EMAIL_DESC','Indicate your email');
define('MODULE_SHIPPING_INTERKURIER_FETCH_STREET_TITLE','Street / Number');
define('MODULE_SHIPPING_INTERKURIER_FETCH_STREET_DESC','Indicate your street');
define('MODULE_SHIPPING_INTERKURIER_FETCH_POSTCODE_TITLE','postcode');
define('MODULE_SHIPPING_INTERKURIER_FETCH_POSTCODE_DESC','Indicate your postcode');
define('MODULE_SHIPPING_INTERKURIER_FETCH_CITY_TITLE','city');
define('MODULE_SHIPPING_INTERKURIER_FETCH_CITY_DESC','Indicate your city');
define('MODULE_SHIPPING_INTERKURIER_FETCH_COUNTRY_TITLE','country');
define('MODULE_SHIPPING_INTERKURIER_FETCH_COUNTRY_DESC','Indicate your country');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_FIRM_TITLE','Bill address: <br>Firm name');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_FIRM_DESC','Indicate to your firm names');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_NAME_TITLE','Pre-surname');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_NAME_DESC','Indicate to your pre and surnames');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_PHONE_TITLE','Phonenumber');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_PHONE_DESC','Indicate your telephone number');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_EMAIL_TITLE','email');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_EMAIL_DESC','Indicate your email');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_STREET_TITLE','Street / Number');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_STREET_DESC','Indicate your street');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_POSTCODE_TITLE','postcode');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_POSTCODE_DESC','Indicate your postcode');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_CITY_TITLE','city');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_CITY_DESC','Indicate your city');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_COUNTRY_TITLE','country');
define('MODULE_SHIPPING_INTERKURIER_INVOICE_COUNTRY_DESC','Indicate your country');





define('MODULE_SHIPPING_INTERKURIER_STATUS_TITLE' , 'Interkurier Express');
define('MODULE_SHIPPING_INTERKURIER_STATUS_DESC' , 'Do you want to offer the dispatch by intercourier?');
define('MODULE_SHIPPING_INTERKURIER_HANDLING_TITLE' , 'Addition');
define('MODULE_SHIPPING_INTERKURIER_HANDLING_DESC' , 'Processing addition for this mode of shipment in euros');
define('MODULE_SHIPPING_INTERKURIER_TAX_CLASS_TITLE' , 'tax');
define('MODULE_SHIPPING_INTERKURIER_TAX_CLASS_DESC' , 'Select the VAT. for this mode of shipment out.');
define('MODULE_SHIPPING_INTERKURIER_ZONE_TITLE' , 'Shipping zone');
define('MODULE_SHIPPING_INTERKURIER_ZONE_DESC' , 'If you select a zone, this mode of shipment is offered only in this zone.');
define('MODULE_SHIPPING_INTERKURIER_SORT_ORDER_TITLE' , 'The sequence of the display');
define('MODULE_SHIPPING_INTERKURIER_SORT_ORDER_DESC' , 'Lowest one is first displayed.');
define('MODULE_SHIPPING_INTERKURIER_ALLOWED_TITLE' , 'Individual dispatch zones');
define('MODULE_SHIPPING_INTERKURIER_ALLOWED_DESC' , 'Indicate separately the zones, into which a dispatch should be possible, e.g.: AT, DE');




define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_1_TITLE' , 'countries for zone 1');
define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_1_DESC' , 'Comma separate ISO contractions for zone 1:');
define('MODULE_SHIPPING_INTERKURIER_COST_1_TITLE' , 'charge zones 1');
define('MODULE_SHIPPING_INTERKURIER_COST_1_DESC' , 'shipping cost zone 1');

define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_2_TITLE' , 'countries for zone 2');
define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_2_DESC' , 'Comma separate ISO contractions for zone 2:');
define('MODULE_SHIPPING_INTERKURIER_COST_2_TITLE' , 'charge zones 2');
define('MODULE_SHIPPING_INTERKURIER_COST_2_DESC' , 'shipping cost zone 2');

define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_3_TITLE' , 'countries for zone 3');
define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_3_DESC' , 'Comma separate ISO contractions for zone 3:');
define('MODULE_SHIPPING_INTERKURIER_COST_3_TITLE' , 'charge zones 3');
define('MODULE_SHIPPING_INTERKURIER_COST_3_DESC' , 'shipping cost zone 3');

define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_4_TITLE' , 'countries for zone 4');
define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_4_DESC' , 'Comma separate ISO contractions for zone 4:');
define('MODULE_SHIPPING_INTERKURIER_COST_4_TITLE' , 'charge zones 4');
define('MODULE_SHIPPING_INTERKURIER_COST_4_DESC' , 'shipping cost zone 4');

define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_5_TITLE' , 'countries for zone 5');
define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_5_DESC' , 'Comma separate ISO contractions for zone 5:');
define('MODULE_SHIPPING_INTERKURIER_COST_5_TITLE' , 'charge zones 5');
define('MODULE_SHIPPING_INTERKURIER_COST_5_DESC' , 'shipping cost zone 5');

define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_6_TITLE' , 'countries for zone 6');
define('MODULE_SHIPPING_INTERKURIER_COUNTRIES_6_DESC' , 'Comma separate ISO contractions for zone 6:');
define('MODULE_SHIPPING_INTERKURIER_COST_6_TITLE' , 'charge zones 6');
define('MODULE_SHIPPING_INTERKURIER_COST_6_DESC' , 'shipping cost zone 6');




?>