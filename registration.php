<?php

##
## Регистрация пользователя
##

define( 'root_page', '' );
require_once root_page . 'functions.php';

DatabaseConnect();

if( isset( $_POST[ 'Login' ] ) ) {



    # Защита от CSRF
    checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'login.php' );

    $user = $_POST[ 'username' ];
    $user = stripslashes( $user );
    $user = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $user ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

    $pass = $_POST[ 'password' ];
    $pass = stripslashes( $pass );
    $pass = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $pass ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
    $pass = md5( $pass );

    $query = ("SELECT table_schema, table_name, create_time
				FROM information_schema.tables
				WHERE table_schema='{$_VulnWapp['db_database']}' AND table_name='users'
				LIMIT 1");
    $result = @mysqli_query($GLOBALS["___mysqli_ston"],  $query );
    if( mysqli_num_rows( $result ) != 1 ) {
        PushMessage( "В первый раз используете приложение?<br />Переход к установке - 'setup.php'." );
        RedirectTo( root_page . 'setup.php' );
    }

    $id = ("SELECT max(user_id) FROM users");
    $id++;

    $avatarUrl  = 'includes/users/';

    #$password = MD5($pass);

    $insert = "INSERT INTO users VALUES
				('{$id}','{$user}','{$user}','{$user}','{$pass}','{$avatarUrl}boy.png', NOW(), '0','0', false);";
    if( !mysqli_query($GLOBALS["___mysqli_ston"],  $insert ) ) {
        PushMessage( "Не удалось внести данные в таблицу пользователей<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
        ReloadPage();


    }
    PushMessage( "Успешная регистрация" );
    RedirectTo( root_page . 'login.php' );




    /*
    $query  = "SELECT * FROM `users` WHERE user='$user' AND password='$pass';";
    $result = @mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '.<br />Попробуйте <a href="setup.php">переустановить приложение!</a>.</pre>' );
    if( $result && mysqli_num_rows( $result ) == 1 ) {    # Успешная авторизация
        PushMessage( "Вы авторизованы как '{$user}'" );
        Login( $user );
        RedirectTo( root_page . 'index.php' );
    }

    # Неверные данные
    PushMessage( 'Неверные авторизационные данные!' );
    RedirectTo( 'login.php' );

    */
}

$messagesHtml = messagesPopAllToHtml();

Header( 'Cache-Control: no-cache, must-revalidate');
Header( 'Content-Type: text/html;charset=utf-8' );
#Header( 'Expires: Tue, 23 Jun 2009 12:00:00 GMT' );     // Date in the past ??

# Защита от CSRF
generateSessionToken();

# TODO выбор аватара, больше даных о пользователе


echo "

<!doctype html>
<html lang=\"en-US\">

<meta http-equiv=\"content-type\" content=\"text/html;charset=UTF-8\" />
<head>
    <meta charset=\"UTF-8\">
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
	<link rel=\"profile\" href=\"http://gmpg.org/xfn/11\">
	<title>Регистрация</title>
<link rel='dns-prefetch' href='http://fonts.googleapis.com/' />
<link rel='dns-prefetch' href='http://s.w.org/' />
<link rel=\"alternate\" type=\"application/rss+xml\" title=\" &raquo; Feed\" href=\"feed/index.html\" />
<link rel=\"alternate\" type=\"application/rss+xml\" title=\" &raquo; Comments Feed\" href=\"comments/feed/index.html\" />
<link rel=\"alternate\" type=\"application/rss+xml\" title=\" &raquo; Приветствие Comments Feed\" href=\"sample-page/feed/index.html\" />
		<script type=\"text/javascript\">
			window._wpemojiSettings = {\"baseUrl\":\"https:\/\/s.w.org\/images\/core\/emoji\/11\/72x72\/\",\"ext\":\".png\",\"svgUrl\":\"https:\/\/s.w.org\/images\/core\/emoji\/11\/svg\/\",\"svgExt\":\".svg\",\"source\":{\"concatemoji\":\"http:\/\/localhost\/wordpress\/includes\/js\/wp-emoji-release.min.js?ver=4.9.8\"}};
			!function(a,b,c){function d(a,b){var c=String.fromCharCode;l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,a),0,0);var d=k.toDataURL();l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,b),0,0);var e=k.toDataURL();return d===e}function e(a){var b;if(!l||!l.fillText)return!1;switch(l.textBaseline=\"top\",l.font=\"600 32px Arial\",a){case\"flag\":return!(b=d([55356,56826,55356,56819],[55356,56826,8203,55356,56819]))&&(b=d([55356,57332,56128,56423,56128,56418,56128,56421,56128,56430,56128,56423,56128,56447],[55356,57332,8203,56128,56423,8203,56128,56418,8203,56128,56421,8203,56128,56430,8203,56128,56423,8203,56128,56447]),!b);case\"emoji\":return b=d([55358,56760,9792,65039],[55358,56760,8203,9792,65039]),!b}return!1}function f(a){var c=b.createElement(\"script\");c.src=a,c.defer=c.type=\"text/javascript\",b.getElementsByTagName(\"head\")[0].appendChild(c)}var g,h,i,j,k=b.createElement(\"canvas\"),l=k.getContext&&k.getContext(\"2d\");for(j=Array(\"flag\",\"emoji\"),c.supports={everything:!0,everythingExceptFlag:!0},i=0;i<j.length;i++)c.supports[j[i]]=e(j[i]),c.supports.everything=c.supports.everything&&c.supports[j[i]],\"flag\"!==j[i]&&(c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&c.supports[j[i]]);c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&!c.supports.flag,c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.everything||(h=function(){c.readyCallback()},b.addEventListener?(b.addEventListener(\"DOMContentLoaded\",h,!1),a.addEventListener(\"load\",h,!1)):(a.attachEvent(\"onload\",h),b.attachEvent(\"onreadystatechange\",function(){\"complete\"===b.readyState&&c.readyCallback()})),g=c.source||{},g.concatemoji?f(g.concatemoji):g.wpemoji&&g.twemoji&&(f(g.twemoji),f(g.wpemoji)))}(window,document,window._wpemojiSettings);
		</script>
		<style type=\"text/css\">
img.wp-smiley,
img.emoji {
	display: inline !important;
	border: none !important;
	box-shadow: none !important;
	height: 1em !important;
	width: 1em !important;
	margin: 0 .07em !important;
	vertical-align: -0.1em !important;
	background: none !important;
	padding: 0 !important;
}
</style>
<link rel='stylesheet' id='elemento-font-css'  href='https://fonts.googleapis.com/css?family=Libre+Franklin%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900&amp;ver=20151215' type='text/css' media='all' />
<link rel='stylesheet' id='bootstrap-css'  href='includes/themes/elemento/assets/css/bootstrap.min4a7d.css?ver=20151215' type='text/css' media='all' />
<link rel='stylesheet' id='flexslider-css'  href='includes/themes/elemento/assets/css/flexslider.min4a7d.css?ver=20151215' type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome-css'  href='includes/plugins/elementor/assets/lib/font-awesome/css/font-awesome.min1849.css?ver=4.7.0' type='text/css' media='all' />
<link rel='stylesheet' id='elemento-style-css'  href='includes/themes/elemento/style4b1d.css?ver=1.8' type='text/css' media='all' />
<link rel='stylesheet' id='elemento-responsive-css'  href='includes/themes/elemento/assets/css/responsive5152.css?ver=1.0' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-css'  href='includes/plugins/elementor/assets/lib/eicons/css/elementor-icons.min9e95.css?ver=3.8.0' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-animations-css'  href='includes/plugins/elementor/assets/lib/animations/animations.mindbc2.css?ver=2.2.6' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-frontend-css'  href='includes/plugins/elementor/assets/css/frontend.mindbc2.css?ver=2.2.6' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-pro-css'  href='includes/plugins/elementor-pro/assets/css/frontend.mincc91.css?ver=2.1.8' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-global-css'  href='includes/uploads/elementor/css/globale8e6.css?ver=1540254196' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-2-css'  href='includes/uploads/elementor/css/post-2b8b2.css?ver=1540340819' type='text/css' media='all' />
<link rel='stylesheet' id='google-fonts-1-css'  href='https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;ver=4.9.8' type='text/css' media='all' />
<script type='text/javascript' src='includes/js/jquery/jqueryb8ff.js?ver=1.12.4'></script>
<script type='text/javascript' src='includes/js/jquery/jquery-migrate.min330a.js?ver=1.4.1'></script>
<link rel='https://api.w.org/' href='wp-json/index.html' />
<link rel=\"EditURI\" type=\"application/rsd+xml\" title=\"RSD\" href=\"xmlrpc0db0.php?rsd\" />
<link rel=\"wlwmanifest\" type=\"application/wlwmanifest+xml\" href=\"includes/wlwmanifest.xml\" /> 
<meta name=\"generator\" content=\"WordPress 4.9.8\" />
<link rel=\"canonical\" href=\"index.html\" />
<link rel='shortlink' href='index.html' />
<link rel=\"alternate\" type=\"application/json+oembed\" href=\"wp-json/oembed/1.0/embed68f4.json?url=http%3A%2F%2Flocalhost%2Fwordpress%2F\" />
<link rel=\"alternate\" type=\"text/xml+oembed\" href=\"wp-json/oembed/1.0/embedd248?url=http%3A%2F%2Flocalhost%2Fwordpress%2F&amp;format=xml\" />
<link rel=\"pingback\" href=\"xmlrpc.php\">	<style>
		.header_height{ height:1000px;}
				
		body{
			font-family: 'Libre Franklin',sans-serif;
			font-size: 14px;
			color: #353535;
		}
		body a{ color:#ED564B;}
		body a:hover{ color:#4257f2;}
		.site-title a{font-size: 32px;}
		.site-description{font-size: 14px;}
		nav.menu-main li a{font-size: 14px;}
		h1{font-size: 60px; }
		h2{font-size: 46px; }
		h3{font-size: 26px; }
		h4{font-size: 20px; }
		h5{font-size: 16px; }
		h6{font-size: 12px; }
		header.sticky-header.scrolled,
		.no-banner header.jr-site-header
		{background-color:  #1f2024!important; }

		h1.site-title{font-size: 32px;margin:0 0 5px 0; }
		nav.menu-main ul>li>a{color:#fff}
		nav.menu-main ul li a:hover{color:#d65050;}    
		nav.menu-main ul li .sub-menu>li>a{color:rgba(0,0,0,0.6);}
		nav.menu-main ul li .sub-menu{background-color:#fff;}

		
		.is-sidebar{
			background-color:  rgba(0,0,0,0);
			color:  #353535;
		}
		
		.jr-site-footer a{
			color:#fff;
		}

		.jr-site-footer .copyright-bottom{
			background-color: #3d3d3d;
			color:#efefef;
		}


		nav ul li:hover,
		nav ul li.active-page,
		nav ul > li.current-menu-item {
			background-color: #4257f2;
		}

		nav ul li:hover a,
		nav ul li.active-page a,
		nav ul > li.current-menu-item a {
			text-decoration: none;
			color: white;
		}

		.single-post .post-title, h1.page-title{font-size:  34px;}

		@media (max-width: 1020px){
			.mobile-menu span {

				background-color: #fff;

			}
		}




	</style>
	</head>


<body class=\"home page-template page-template-elementor_header_footer page page-id-2 full-width-layout elementor-default elementor-template-full-width elementor-page elementor-page-2\" data-container=\"container-large\">
<!--Mobile view ham menu-->
<div class=\"mobile-menu\">
    <span></span>
    <span></span>
    <span></span>
</div>
<!--Ends-->

<div class=\"body-wrapp  \">

    <!--Header Component-->
    <header id=\"siteHeader\" class=\"jr-site-header pd-a-15 absolute-header menu-inline\">

        <div class=\"container-large\">
            <div class=\"row align-flex-item-center full-width\">
                <div class=\"col-md-3\">
                    <div class=\"logo-holder\">
                                                    <h1 class=\"site-title\"><a href=\"index.html\" rel=\"home\"></a></h1>
                                                     
                                                </div>
                </div>
                <div class=\"col-md-9 text-align-right\">
                                    <nav class=\"menu-main\">                    
</ul></div>                    </nav>
                </div>
            </div>
        </div>
    </header>

<br />  
  
	<h3> {$messagesHtml}  </h3> 
	
	
	
	
	
		<div class=\"elementor elementor-2\">
			<div class=\"elementor-inner\">
				<div class=\"elementor-section-wrap\">
							<section data-id=\"180c9ed\" class=\"elementor-element elementor-element-180c9ed elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section\" data-element_type=\"section\">
						<div class=\"elementor-container elementor-column-gap-default\">
				<div class=\"elementor-row\">
				<div data-id=\"ea4de13\" class=\"elementor-element elementor-element-ea4de13 elementor-column elementor-col-100 elementor-top-column\" data-element_type=\"column\">
			<div class=\"elementor-column-wrap elementor-element-populated\">
					<div class=\"elementor-widget-wrap\">
				<div data-id=\"0accb27\" class=\"elementor-element elementor-element-0accb27 elementor-widget elementor-widget-spacer\" data-element_type=\"spacer.default\">
				<div class=\"elementor-widget-container\">
					<div class=\"elementor-spacer\">
			<div class=\"elementor-spacer-inner\"></div>
		</div>
				</div>
				</div>
				<div data-id=\"4e792cd\" class=\"elementor-element elementor-element-4e792cd elementor-widget elementor-widget-heading\" data-element_type=\"heading.default\">
				<div class=\"elementor-widget-container\">
			<h2 class=\"elementor-heading-title elementor-size-default\">Регистрация
			</h2>		</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id=\"9443f4d\" class=\"elementor-element elementor-element-9443f4d elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section\" data-element_type=\"section\">
						<div class=\"elementor-container elementor-column-gap-narrow\">
				<div class=\"elementor-row\">
				<div data-id=\"ad6ef84\" class=\"elementor-element elementor-element-ad6ef84 elementor-column elementor-col-100 elementor-top-column\" data-element_type=\"column\">
			<div class=\"elementor-column-wrap elementor-element-populated\">
					<div class=\"elementor-widget-wrap\">
				<div data-id=\"ec2ab49\" class=\"elementor-element elementor-element-ec2ab49 animated fadeInDown elementor-button-align-stretch elementor-invisible elementor-widget elementor-widget-login\" data-settings=\"{&quot;_animation&quot;:&quot;fadeInDown&quot;}\" data-element_type=\"login.default\">
				<div class=\"elementor-widget-container\">
				
				
				
					<form class=\"elementor-login elementor-form\" method=\"post\" action=\"registration.php\">
			<input type=\"hidden\" name=\"redirect_to\" value=\"login.php/\">
			<div class=\"elementor-form-fields-wrapper\">
				<div class=\"elementor-field-type-text elementor-field-group elementor-column elementor-col-100 elementor-field-required\">
					<label for=\"user\"></label><input size=\"1\" type=\"text\" name=\"username\" id=\"user\" placeholder=\"Имя пользователя\" class=\"elementor-field elementor-field-textual elementor-size-lg\">				</div>
				<div class=\"elementor-field-type-text elementor-field-group elementor-column elementor-col-100 elementor-field-required\">
					<label ></label><input size=\"1\" type=\"password\" name=\"password\" id=\"password\" placeholder=\"Пароль\" AUTOCOMPLETE=\"off\" class=\"elementor-field elementor-field-textual elementor-size-lg\">
									
									 " . tokenField() . "    
									</div>
			
			
				<!-- BUTTONS -->
								
				<div class=\"elementor-field-group elementor-column elementor-field-type-submit elementor-col-100\">
					<button type=\"submit\" class=\"elementor-size-sm elementor-button\" name=\"Login\">
															<span class=\"elementor-button-text\">Зарегистрироваться</span>
												</button>
				</div>

							</div>
		</form>
				</div>
				</div>
                
               
                    
                <div data-id=\"2b5e9a6\" class=\"elementor-element elementor-element-2b5e9a6 elementor-align-right elementor-widget elementor-widget-button\" data-element_type=\"button.default\">    
                
                
				
				
				</div>
				<div data-id=\"2fec8ec\" class=\"elementor-element elementor-element-2fec8ec elementor-align-left elementor-widget elementor-widget-button\" data-element_type=\"button.default\">
				
				
				
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id=\"488de9a\" class=\"elementor-element elementor-element-488de9a elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section\" data-element_type=\"section\">
						<div class=\"elementor-container elementor-column-gap-default\">
				<div class=\"elementor-row\">
				<div data-id=\"85d1b9d\" class=\"elementor-element elementor-element-85d1b9d elementor-column elementor-col-100 elementor-top-column\" data-element_type=\"column\">
			<div class=\"elementor-column-wrap elementor-element-populated\">
					<div class=\"elementor-widget-wrap\">
				<div data-id=\"c75d6d1\" class=\"elementor-element elementor-element-c75d6d1 elementor-view-default elementor-widget elementor-widget-icon\" data-element_type=\"icon.default\">
				<div class=\"elementor-widget-container\">
					<div class=\"elementor-icon-wrapper\">
			<div class=\"elementor-icon\">
				<i class=\"fa fa-user-circle\" aria-hidden=\"true\"></i>
			</div>
		</div>
				</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id=\"4bddb34\" class=\"elementor-element elementor-element-4bddb34 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section\" data-element_type=\"section\">
						<div class=\"elementor-container elementor-column-gap-default\">
				<div class=\"elementor-row\">
				<div data-id=\"c670920\" class=\"elementor-element elementor-element-c670920 elementor-column elementor-col-100 elementor-top-column\" data-element_type=\"column\">
			<div class=\"elementor-column-wrap elementor-element-populated\">
					<div class=\"elementor-widget-wrap\">
				<div data-id=\"64d1202\" class=\"elementor-element elementor-element-64d1202 elementor-button-warning elementor-align-center elementor-widget elementor-widget-button\" data-element_type=\"button.default\">
				
				<div class=\"elementor-widget-container\">
					<div class=\"elementor-button-wrapper\">
			<a href=\"login.php\" class=\"elementor-button-link elementor-button elementor-size-md\" role=\"button\">
						<span class=\"elementor-button-content-wrapper\">
						<span class=\"elementor-button-text\">Отмена</span>
		</span>
					</a>
		</div>
				</div>
				
				
				
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
		
		
		
		
				<section data-id=\"e1a08c7\" class=\"elementor-element elementor-element-e1a08c7 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section\" data-element_type=\"section\">
						<div class=\"elementor-container elementor-column-gap-default\">
				<div class=\"elementor-row\">
				<div data-id=\"8eb1c73\" class=\"elementor-element elementor-element-8eb1c73 elementor-column elementor-col-100 elementor-top-column\" data-element_type=\"column\">
			<div class=\"elementor-column-wrap elementor-element-populated\">
					<div class=\"elementor-widget-wrap\">
				<div data-id=\"eb4b9c4\" class=\"elementor-element elementor-element-eb4b9c4 elementor-widget elementor-widget-spacer\" data-element_type=\"spacer.default\">
				<div class=\"elementor-widget-container\">
					<div class=\"elementor-spacer\">
			<div class=\"elementor-spacer-inner\"></div>
		</div>
				</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
						</div>
			</div>
		</div>
		  
   </div>  
   
   <br />

	

	<br />

    <!--Footer component-->
    <section id=\"footer\" class=\"jr-site-footer\"><!--Now active fixed footer-->
      
        <div class=\"copyright-bottom\">
        Copyright Pavlukhin Dmitry. All rights reserved.  
        <span> | </span>     
        Powered by <a target=\"_blank\" rel=\"designer\" href=\"mailto:pavluhin_dima@mail.ru\">Pavlukhin Dmitry</a>  
        </div>
    </section>
    
    <!--Ends-->
      
      
      
<script type='text/javascript' src='includes/themes/elemento/assets/js/bootstrap.min4a7d.js?ver=20151215'></script>
<script type='text/javascript' src='includes/themes/elemento/assets/js/flexslider.min4a7d.js?ver=20151215'></script>
<script type='text/javascript' src='includes/themes/elemento/assets/js/skip-link-focus-fix4a7d.js?ver=20151215'></script>
<script type='text/javascript' src='includes/themes/elemento/assets/js/scriptsf269.js?ver=1.0.1'></script>
<script type='text/javascript' src='includes/js/wp-embed.min5010.js?ver=4.9.8'></script>
<script type='text/javascript' src='includes/plugins/elementor-pro/assets/lib/sticky/jquery.sticky.mincc91.js?ver=2.1.8'></script>
<script type='text/javascript'>

</script>
<script type='text/javascript' src='includes/plugins/elementor-pro/assets/js/frontend.mincc91.js?ver=2.1.8'></script>
<script type='text/javascript' src='includes/js/jquery/ui/position.mine899.js?ver=1.11.4'></script>
<script type='text/javascript' src='includes/plugins/elementor/assets/lib/dialog/dialog.min268f.js?ver=4.5.0'></script>
<script type='text/javascript' src='includes/plugins/elementor/assets/lib/waypoints/waypoints.min05da.js?ver=4.0.2'></script>
<script type='text/javascript' src='includes/plugins/elementor/assets/lib/swiper/swiper.jquery.mincb20.js?ver=4.4.3'></script>
<script type='text/javascript'>

<!-- TEST! MAY AFFECT FUNCTION -->

/* <![CDATA[ */
var elementorFrontendConfig = {\"isEditMode\":\"\",\"is_rtl\":\"\",\"breakpoints\":{\"xs\":0,\"sm\":480,\"md\":768,\"lg\":1025,\"xl\":1440,\"xxl\":1600},\"version\":\"2.2.6\",\"urls\":{\"assets\":\"http:\/\/localhost\/wordpress\/includes\/plugins\/elementor\/assets\/\"},\"settings\":{\"page\":[],\"general\":{\"elementor_global_image_lightbox\":\"yes\",\"elementor_enable_lightbox_in_editor\":\"yes\"}},\"post\":{\"id\":2,\"title\":\"\u041f\u0440\u0438\u0432\u0435\u0442\u0441\u0442\u0432\u0438\u0435\",\"excerpt\":\"\"}};
/* ]]> */
</script>


<script type='text/javascript' src='includes/plugins/elementor/assets/js/frontend.mindbc2.js?ver=2.2.6'></script>

</body>

</html>









";





?>