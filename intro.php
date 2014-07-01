<?php session_start();
error_reporting(E_ALL ^ E_NOTICE);

// -------------------------------------------------------------------------------------------
//	Database info
// -------------------------------------------------------------------------------------------
define("DB_DSN", "mysql:host=localhost;dbname=piratebay");  				 		  // Connection string (codebox_unstopp_piratebaygame)
define("DB_USERNAME", "root");														 // Database username (codebox_pirate)
define("DB_PASSWORD", "root");                                           // Database password (unst0pplabs                                                

// -------------------------------------------------------------------------------------------
//	General adjustments
// -------------------------------------------------------------------------------------------
define("CLS_PATH", "class");  
include_once(CLS_PATH . "/user.php");

$view = array();
$view['content'] = "<div class='welcome_message'>Welcome back adventurer ! <div class='spacer'></div></div>";


// -------------------------------------------------------------------------------------------
//	Register function script
// -------------------------------------------------------------------------------------------

if(isset($_POST['registerbutton_submit'])) {
	
	$view['action'] = "register";
		
	$usr = new Users; // Create new instance of the class Users 
	$usr->storeData($_POST); // Store form values	
	
	$verify = $usr->verifyRegister($_POST); // Run verification for input data
	
	if($verify == "verified") {
		echo $usr->register($_POST);
		$view['content'] = 'Congratulations! You can now start your adventure.';
	} else {
		$view['content'] = $verify;
	}
	
}


// -------------------------------------------------------------------------------------------
//	LogIn function script
// -------------------------------------------------------------------------------------------

if(isset($_POST['loginbutton_submit'])) {
	
	$view['action'] = "login";

	$usr = new Users; //create a new instance of the Users class
	$usr->storeData($_POST); //like I said before we will use the function storeFormValues to store the form values 
	if($usr->userLogin()) {
		$view['content'] = "<div class='welcome_message'>Welcome back adventurer ! <div class='spacer'></div></div>";
		$_SESSION['auth'] = $usr->username;
	} else {
		$view['content'] = "login failed, ba cacatule <meta http-equiv='refresh' content='1; url=http://www.unstopp.com/game/#login'>";
	}
	
}


// -------------------------------------------------------------------------------------------
//	LogOut function script
// -------------------------------------------------------------------------------------------
if(isset($_POST["logout"])) {
	$_SESSION['auth'] = NULL;
	$auth = NULL;
	$view['content'] = NULL;
	$view['action'] = "logout";
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>crap goes here</title>
<link rel="stylesheet" type="text/css" href="css/style_intro.css" />
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type='text/javascript' src="js/script_intro.js"></script>
<script type='text/javascript' src="js/tooltipsy.min.js"></script>
</head>

<body>
<!-- <img id="loader" src="img/ajax-loader.gif" alt="loading" /> -->
<!-- <img src="http://lorempixel.com/1680/1050/" style="display:none" /> -->

<div class="spacer"></div><div class="spacer"></div><div class="spacer"></div>
<div id="logo"><!-- Logo --></div>
<div class="spacer"></div><div class="spacer"></div><div class="spacer"></div>

<div id="form_wrap">
  <a id="trigger_register" href="#register"><div id="tab_register"></div><div id="tab_shadow_register" class="tab_shadow"></div></a>
  <a id="trigger_login" href="#login"><div id="tab_login"></div><div id="tab_shadow_login" class="tab_shadow"></div></a>
  <a id="trigger_descr" href="#welcome"><div id="tab_description"></div><div id="tab_shadow_description" class="tab_shadow"></div></a>
  <div id="form">
  
  	<?php echo $_SESSION['auth']; ?>
  
  	<!-- Register form -->
  	<div id="register_box">           
    	<?php if(($view['action'] != "register") && (!$_SESSION['auth'])) : ?>
    
    	<form method="post">
    	<img src="img/register_box_top.png" />
        <div id="register_box_text">
            <table id="inputtable">
            <tr>
            <td style="text-align:right"><label for="usn">username</label></td>
            <td>&nbsp; &nbsp;</td>
            <td><input type="text" name="username" class="registerinput" maxlength="15" /></td>
            <td><img src="img/i.png" class="tip" title="Your in-game nickname (between 4-15 'Aa-Zz' chars)" /></td>
            </tr>
            <tr>
            <td style="text-align:right"><label for="psswd">password</label></td>
            <td>&nbsp; &nbsp;</td>
            <td><input type="password" name="password" class="registerinput" /></td>
            <td><img src="img/i.png" class="tip" title="Protect your account with a password (min. 6 chars)" /></td>
            </tr>
            <tr>
            <td style="text-align:right"><label for="vpsswrd">re-password</label></td>
            <td>&nbsp; &nbsp;</td>
            <td><input type="password" name="repassword" class="registerinput" /></td>
            <td><img src="img/i.png" class="tip" title="Verify the account password" /></td>
            </tr>
            <tr>
            <td style="text-align:right"><label for="email">e-mail</label></td>
            <td>&nbsp; &nbsp;</td>
            <td><input type="text" name="email" class="registerinput" /></td>
            <td><img src="img/i.png" class="tip" title="Help us keep in touch with you. Use an email" /></td>
            </tr>
            <tr>
            <td style="text-align:right">unique code</td>
            <td>&nbsp; &nbsp;</td>
            <td><input type="text" name="ucode" class="registerinput" maxlength="6" /></td>
            <td><img src="img/i.png" class="tip" title="Choose a security code for your account in case of trouble &nbsp; &nbsp; &nbsp; &nbsp; (6 digits)" /></td>
            </tr>
            <tr>
            <td style="text-align:right">world</td>
            <td>&nbsp; &nbsp;</td>
            <td>
            <select class="selectsv" name="server">
            <option class="mountain_sv" value="0">mountain &nbsp; </option>
            <option class="island_sv" value="1">island &nbsp; </option>
            <option class="forest_sv" value="2">forest &nbsp; </option>
            </select>
            </td>
            <td><img src="img/i.png" class="tip" title="Choose your spawn location" /></td>
            </tr>
            </table>
        </div>
        <div id="registerbutton_wrapper"><div id="registerbutton">
        <input type="submit" id="registerbutton_submit" name="registerbutton_submit" value="" />
        </div></div>
        </form>
        
        <?php else : echo $view['content']; ?>
        
        <div class="spacer"></div><a href="http://www.unstopp.com/game/">Got it. Take me back</a>
        
		<?php endif ?>     
        
        
        <?php if($_SESSION['auth']) : ?>
        
        You are already logged-in. Please log out before creating another account.
        
        <?php endif ?>   
  	</div>
    
    <!-- Login form -->
    <div id="login_box">
    	<?php if(($view['action'] != "login") && ($view['action'] != "logout") && (!$_SESSION['auth'])) : ?>
        
        <form method="post">
    	<img src="img/login_box_top.png" />
        <div id="login_box_text">
            <table id="inputtable">
            <tr>
            <td style="text-align:right">username</td>
            <td>&nbsp; &nbsp;</td>
            <td><input type="text" name="username" class="logininput" /></td> 
            </tr>
            <tr>
            <td style="text-align:right">password</td>
            <td>&nbsp; &nbsp;</td>
            <td><input type="password" name="password" class="logininput" /></td>
            </tr>
            <tr><td style="height:20px"><!--Spacer--></td></tr>
            <tr>
            <td style="text-align:right">world</td>
            <td>&nbsp; &nbsp;</td>
            <td>
            <select class="selectsv" name="server">
            <option class="mountain_sv" value="0">mountain &nbsp; </option>
            <option class="island_sv" value="1">island &nbsp; </option>
            <option class="forest_sv" value="2">forest &nbsp; </option>
            </select></td>
            </tr>
            </table>
            </table>
        </div>
        <div class="spacer"></div>
        <div id="loginbutton_wrapper"><div id="loginbutton">
        <input type="submit" id="loginbutton_submit" name="loginbutton_submit" value="" />
        </div></div>
        </form>
        
        <?php else : echo $view['content']; ?>
              
		<?php endif ?>
        
        
        <?php if($_SESSION['auth']) : ?>
        
        Your username is: <?php echo $_SESSION['auth']; ?>
        
        <form name="login_form" enctype="multipart/form-data" method="post">
        <input type="submit" name="logout" value="Logout" id="buton_logout" />
        </form>
        
        <?php endif ?>
        
        
        <?php if($view['action'] == "logout") : ?>
        
        You have been logged out.
        <meta http-equiv='refresh' content='1; url=http://www.unstopp.com/game/'>
        
        <?php endif ?>
    </div>
    
    <!-- Description box -->
    <div id="descr_box">
    	<img src="img/descr_box_top.png" />
        <div id="descr_box_text">"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur." <br /><br /> Check out this item sneak peak right <a href="img/itemsholder.png" />here</a>.</div>
        <div id="descr_box_bottom"><img src="img/descr_box_bottom.png" /></div> 
    </div>
    
  </div>
</div>

<!-- Footer -->
<div id="footer">
Copyright &copy; <b>Piratebay</b>. 2012-2013 <br /> <span style="font-size:11px">powered by <a class="footer" href="http://www.codebox.ro/"><b>codebox</b></a></span>
</div>


<!-- Load images in background -->
<img src="img/playbutton_h.png" style="display:none" />
<img src="img/registerbutton_h.png" style="display:none" />

<!-- Background sound 
<audio autoplay loop>
  <source src="sounds/intro_ocean_2[1].wav" type="audio/wav" />
  <source src="sounds/intro_ocean_2[1].mp3" type="audio/mpeg" />
</audio> -->

</body>
</html>