<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de"> 

    <head>
        <title>Admin Center - Login</title> 
        
        <meta http-equiv="Content-Language" content="de" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="imagetoolbar" content="no" />
            
            
        <link href='http://fonts.googleapis.com/css?family=Share:400,400italic,700,700italic' rel='stylesheet' type='text/css' />
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700,400italic,500italic,700italic' rel='stylesheet' type='text/css' />
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.css" rel="stylesheet">
        
        <link href="css/style.css" rel="stylesheet" type="text/css" />
            
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
            
        <script type="text/javascript" src="js/js.js"></script>
        
    </head>
        
    <body>            

<?php
            if(isset($_POST['admin_login'])) { //sofern Login gedrueckt
                                
                if(empty($_POST['admin_email']) OR empty($_POST['admin_pass'])) { // Pruefen ob alle Felder ausgefuellt
                    $message = 'Bitte geben Sie ihre Email ein ... <br />'; $error = "1"; // Fehler
                }        
                    
                $log_email = $_POST['admin_email'];
                $log_pass = $_POST['admin_pass'];
                    
                login($log_email, $log_pass);
            }   
            ?>

            <div class="login-container shadow">
                <div id="sign-in">
                        
                    <h1 class="page-heading">LOGIN</h1> 
            
                    <form id="sign-in-form" class="form-horizontal form-small" data-submit="ajax" action="" method="post">
            
                        <div class="alert alert-error hide">
                            <h4 class="alert-heading">Authentication Failed</h4>
                            <p></p>
                        </div>
            
                        <div class="control-group">
                                
                            <label class="control-label" for="email">Email</label>
            
                            <div class="controls">
                                <input id="email" type="text" data-validate="required" value="" name="admin_email">
                                <p class="help">Please enter a valid email address</p>
                            </div>
                                    
                        </div>
            
                        <div class="control-group">
                                
                            <label class="control-label" for="password">Password</label>
            
                            <div class="controls">
                                <input id="password" type="password" data-validate="required" value="" name="admin_pass">
                                <p class="help">Please enter a valid password</p>
                            </div>
            
                        </div>
                        
                        <input class="btn btn-blue normal" value="Sign In" type="submit" name="admin_login" />
            
                    </form>        
                        
                </div>
            </div> 