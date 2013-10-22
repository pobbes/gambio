            <?php
            include('includes/header.inc.php');
            include ('includes/db_functions.inc.php');

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

            <?php include('includes/footer.inc.php'); ?>