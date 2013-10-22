<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de"> 

<head>
<title>test</title> 

<meta http-equiv="Content-Language" content="de" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
    
    
<link href='http://fonts.googleapis.com/css?family=Share:400,400italic,700,700italic' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700,400italic,500italic,700italic' rel='stylesheet' type='text/css' />

<link href="css/style.css" rel="stylesheet" type="text/css" />
    
</head>
<body>
    
<div class="container">
    <div class="login-container shadow">
        
        <h1>Vorschau</h1>
        
        <ul>
            <?php 

            include('includes/db_functions.inc.php');
    
            showFinalSlides();
            ?>

        </ul>        
        
    </div>    
</div>
    
</body>
</html>