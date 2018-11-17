<?php

define( 'root_page', '' );
require_once root_page . 'functions.php';


if( !IsLoggedIn() ) {
    PushMessage( "Пожалуйста, авторизуйтесь!" );
    RedirectTo( 'login.php' );
}

#global $flags;

# TODO посмотреть как на уровне PHP прописать флаги в операционной системе


generateSessionToken();

# TODO вставить при проверке флагов
#checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'login.php' );

DatabaseConnect();

$query = ("SELECT table_schema, table_name, create_time
				FROM information_schema.tables
				WHERE table_schema='{$_VulnWapp['db_database']}' AND table_name='users'
				LIMIT 1");
$result = @mysqli_query($GLOBALS["___mysqli_ston"],  $query );
if( mysqli_num_rows( $result ) != 1 ) {
    PushMessage( "В первый раз используете приложение?<br />Переход к установке - 'setup.php'." );
    RedirectTo( root_page . 'setup.php' );
}


$percent  = ("SELECT percent FROM users where active=true");
$current_user = ("SELECT user FROM users where active=true");

$resultPercent = @mysqli_query($GLOBALS["___mysqli_ston"], $percent);
$resultUser = @mysqli_query($GLOBALS["___mysqli_ston"], $current_user);

# TODO echo current_field - DONE

#$percent = ("SELECT percent FROM users WHERE current_user");

#$row = $result1->fetch_array(MYSQLI_ASSOC);
#printf ("%s (%s)\n", $row["percent"], $row["CountryCode"]);

#$percent =

#echo $GLOBALS['$sessionuser'];;

#ob_start();
#var_dump($result1->current_field);
#$result1 = ob_get_clean();

#$row = $resultUser->fetch_array(MYSQLI_BOTH);
#echo $row[0];

$outUser = mysqli_fetch_array($resultUser);
#echo $outUser['user'];
$outPercent = mysqli_fetch_array($resultPercent);
#echo $outPercent['percent'];


#$outPercent = var_export($resultPercent->current_field, true);
#$outUser = var_export($resultUser->current_field, true);

#print_r($outUser);



Header( 'Content-Type: text/html;charset=utf-8' );

# TODO имя пользователя в заголовке - DONE

# TODO действие на проверку - сравнение флага с имеющимися. Если да +20%, иначе - неверный флаг. Нужно прописать action? - YEP

# TODO Вставить флаги в код и проверять соответствие флагу

if( isset( $_POST[ 'Check' ] ) )
{

    if (  $outPercent['percent'] != '100') {

        # Защита от CSRF
        # checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'login.php' );

        $submitFlag = $_POST['key'];

        $winvalue = $outPercent['percent'] + 20;

        for ($i = 0; $i < 5; $i++) {
            if ($submitFlag == '123') {
                $insertpercent = "UPDATE `users` SET percent='$winvalue'  WHERE active=true";
                if (!mysqli_query($GLOBALS["___mysqli_ston"], $insertpercent)) {
                    PushMessage("Не удалось внести данные в таблицу<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
                }

            }
            echo getFlag($i);

        }

        $percentOld  = ("SELECT percent FROM users where active=true");
        $resultPercentOld = @mysqli_query($GLOBALS["___mysqli_ston"], $percentOld);
        $outPercentOld = mysqli_fetch_array($resultPercentOld);

        if ($outPercentOld['percent'] != $winvalue)
            PushMessage('Неверный флаг, попробуйте поискать ещё!');
        else PushMessage('Верно!');

       # ReloadPage();
    }
    else
    {
        PushMessage('Всё флаги найдены, вы можете  завершить работу!');
    }

}


$messagesHtml = messagesPopAllToHtml();



echo '

<!doctype html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<title>Личный профиль</title>
<link rel=\'dns-prefetch\' href=\'http://fonts.googleapis.com/\' />
<link rel=\'dns-prefetch\' href=\'http://s.w.org/\' />
<link rel="alternate" type="application/rss+xml" title=" &raquo; Feed" href="http://localhost/wordpress/feed/" />
<link rel="alternate" type="application/rss+xml" title=" &raquo; Comments Feed" href="http://localhost/wordpress/comments/feed/" />
		<script type="text/javascript">
			window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/11\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/11\/svg\/","svgExt":".svg","source":{"concatemoji":"http:\/\/localhost\/wordpress\/includes\/js\/wp-emoji-release.min.js?ver=4.9.8"}};
			!function(a,b,c){function d(a,b){var c=String.fromCharCode;l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,a),0,0);var d=k.toDataURL();l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,b),0,0);var e=k.toDataURL();return d===e}function e(a){var b;if(!l||!l.fillText)return!1;switch(l.textBaseline="top",l.font="600 32px Arial",a){case"flag":return!(b=d([55356,56826,55356,56819],[55356,56826,8203,55356,56819]))&&(b=d([55356,57332,56128,56423,56128,56418,56128,56421,56128,56430,56128,56423,56128,56447],[55356,57332,8203,56128,56423,8203,56128,56418,8203,56128,56421,8203,56128,56430,8203,56128,56423,8203,56128,56447]),!b);case"emoji":return b=d([55358,56760,9792,65039],[55358,56760,8203,9792,65039]),!b}return!1}function f(a){var c=b.createElement("script");c.src=a,c.defer=c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var g,h,i,j,k=b.createElement("canvas"),l=k.getContext&&k.getContext("2d");for(j=Array("flag","emoji"),c.supports={everything:!0,everythingExceptFlag:!0},i=0;i<j.length;i++)c.supports[j[i]]=e(j[i]),c.supports.everything=c.supports.everything&&c.supports[j[i]],"flag"!==j[i]&&(c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&c.supports[j[i]]);c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&!c.supports.flag,c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.everything||(h=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",h,!1),a.addEventListener("load",h,!1)):(a.attachEvent("onload",h),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),g=c.source||{},g.concatemoji?f(g.concatemoji):g.wpemoji&&g.twemoji&&(f(g.twemoji),f(g.wpemoji)))}(window,document,window._wpemojiSettings);
		</script>
		<style type="text/css">
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
<link rel=\'stylesheet\' id=\'elemento-font-css\'  href=\'https://fonts.googleapis.com/css?family=Libre+Franklin%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900&amp;ver=20151215\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'bootstrap-css\'  href=\'includes/themes/elemento/assets/css/bootstrap.min4a7d.css?ver=20151215\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'flexslider-css\'  href=\'includes/themes/elemento/assets/css/flexslider.min4a7d.css?ver=20151215\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'font-awesome-css\'  href=\'includes/plugins/elementor/assets/lib/font-awesome/css/font-awesome.min1849.css?ver=4.7.0\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elemento-style-css\'  href=\'includes/themes/elemento/style4b1d.css?ver=1.8\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elemento-responsive-css\'  href=\'includes/themes/elemento/assets/css/responsive5152.css?ver=1.0\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-icons-css\'  href=\'includes/plugins/elementor/assets/lib/eicons/css/elementor-icons.min9e95.css?ver=3.8.0\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-animations-css\'  href=\'includes/plugins/elementor/assets/lib/animations/animations.mindbc2.css?ver=2.2.6\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-frontend-css\'  href=\'includes/plugins/elementor/assets/css/frontend.mindbc2.css?ver=2.2.6\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-pro-css\'  href=\'includes/plugins/elementor-pro/assets/css/frontend.mincc91.css?ver=2.1.8\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-global-css\'  href=\'includes/uploads/elementor/css/globale8e6.css?ver=1540254196\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-post-44-css\'  href=\'includes/uploads/elementor/css/post-449f8e.css?ver=1540693971\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'google-fonts-1-css\'  href=\'https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;ver=4.9.8\' type=\'text/css\' media=\'all\' />
<script type=\'text/javascript\' src=\'includes/js/jquery/jqueryb8ff.js?ver=1.12.4\'></script>
<script type=\'text/javascript\' src=\'includes/js/jquery/jquery-migrate.min330a.js?ver=1.4.1\'></script>
<link rel=\'https://api.w.org/\' href=\'http://localhost/wordpress/wp-json/\' />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://localhost/wordpress/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://localhost/wordpress/includes/wlwmanifest.xml" /> 
<meta name="generator" content="WordPress 4.9.8" />
<link rel="canonical" href="index.html" />
<link rel=\'shortlink\' href=\'http://localhost/wordpress/?p=44\' />
<link rel="alternate" type="application/json+oembed" href="http://localhost/wordpress/wp-json/oembed/1.0/embed?url=http%3A%2F%2Flocalhost%2Fwordpress%2Fmy-profile%2F" />
<link rel="alternate" type="text/xml+oembed" href="http://localhost/wordpress/wp-json/oembed/1.0/embed?url=http%3A%2F%2Flocalhost%2Fwordpress%2Fmy-profile%2F&amp;format=xml" />
	<style>
		.header_height{ height:1000px;}
				
		body{
			font-family: \'Libre Franklin\',sans-serif;
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


<body class="page-template page-template-elementor_header_footer page page-id-44 full-width-layout elementor-default elementor-template-full-width elementor-page elementor-page-44" data-container="container-large">
<!--Mobile view ham menu-->
<div class="mobile-menu">
    <span></span>
    <span></span>
    <span></span>
</div>
<!--Ends-->

<div class="body-wrapp  ">

    <!--Header Component-->
    <header id="siteHeader" class="jr-site-header pd-a-15 absolute-header menu-inline">

        <div class="container-large">
            <div class="row align-flex-item-center full-width">
                <div class="col-md-3">
                    <div class="logo-holder">
                                                    <h1 class="site-title"><a href="http://localhost/wordpress/" rel="home"></a></h1>
                                                      
                                                </div>
                </div>
                <div class="col-md-9 text-align-right">
                                    <nav class="menu-main">
                                        </nav>
                </div>
            </div>
        </div>
    </header>
    
    <h3> '.$messagesHtml.'  </h3> 

	
		<div class="elementor elementor-44">
			<div class="elementor-inner">
				<div class="elementor-section-wrap">
							<section data-id="974f7a5" class="elementor-element elementor-element-974f7a5 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="8f8ab99" class="elementor-element elementor-element-8f8ab99 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="5c5110e" class="elementor-element elementor-element-5c5110e elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Личный профиль пользователя '.$outUser['user'].'
			
			 </h2>		</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id="d2c700a" class="elementor-element elementor-element-d2c700a elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="9935086" class="elementor-element elementor-element-9935086 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="d613905" class="elementor-element elementor-element-d613905 elementor-button-info elementor-align-right elementor-widget elementor-widget-button" data-element_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="logout.php" class="elementor-button-link elementor-button elementor-size-sm" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-icon elementor-align-icon-left">
				<i class="fa fa-rocket" aria-hidden="true"></i>
			</span>
						<span class="elementor-button-text">Выйти из системы</span>
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
				<section data-id="c913d2f" class="elementor-element elementor-element-c913d2f elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="00c9b8b" class="elementor-element elementor-element-00c9b8b elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
					
			<!--		
				<div data-id="e88096e" class="elementor-element elementor-button-align-stretch elementor-widget elementor-widget-form" data-element_type="form.default">
				-->
				
				<div data-id="ec2ab49" class="elementor-element elementor-element-ec2ab49 animated fadeInDown elementor-button-align-stretch elementor-invisible elementor-widget elementor-widget-login" data-settings="{&quot;_animation&quot;:&quot;fadeInDown&quot;}" data-element_type="login.default">
				
				<div class="elementor-widget-container">
				
				
				
				<!--
					<form class="elementor-form" method="post" name="SubmitKey" action=\"myprofile.php\ >
			<input type="hidden" name="post_id" value="44"/>
			<input type="hidden" name="form_id" value="e88096e"/>

			<div class="elementor-form-fields-wrapper elementor-labels-above">
								<div class="elementor-field-type-password elementor-field-group elementor-column elementor-field-group-message elementor-col-60 elementor-field-required">
					<label for="form-field-message" class="elementor-field-label">Ключ</label><input size="1"  name="checkKey" id="form-field-message" class="elementor-field elementor-size-md  elementor-field-textual" placeholder="Введите ключ" required="required" aria-required="true">				</div>
								<div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-60">
					<button type="submit" class="elementor-button elementor-size-sm" name="Check">
						<span >
																						<span class="elementor-button-text">Проверить</span>
													</span>
					</button>
				</div>
			</div>
		</form>
		-->
		
		<!-- Поглядеть ID, попробовать экранировать символы -->
		
		<form class="elementor-login elementor-form" method="post" action="myprofile.php">
			<!--<input type="hidden" name="post_id" value="44"/>
			<input type="hidden" name="form_id" value="e88096e"/> 
			<input type="hidden" name="redirect_to" value="myprofile.php"/> -->

			<div class="elementor-form-fields-wrapper">
								<div class="elementor-field-type-text elementor-field-group elementor-column elementor-col-60 elementor-field-required">
					
					<label for="form-field-message">Ключ</label>
					    <input size="1" type="text" name="key" id="form-field-message"  class="elementor-field elementor-size-md  elementor-field-textual" placeholder="Введите ключ" required="required" aria-required="true">			
					    	
					    	' . tokenField() . ' 
					    	
					    	</div>
								<div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-60">
					<button type="submit" class="elementor-button elementor-size-sm" name="Check">
						<span >
																						<span class="elementor-button-text">Проверить</span>
													</span>
					</button>
				</div>
			</div>
		</form>
		
		
		
		
		
				</div>
				</div>
				<div data-id="284b223" class="elementor-element elementor-element-284b223 elementor-button-warning elementor-widget elementor-widget-button" data-element_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="result.php" class="elementor-button-link elementor-button elementor-size-sm" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">Завершить работу и запросить оценку</span>
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
				<section data-id="74928da" class="elementor-element elementor-element-74928da elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="d270a21" class="elementor-element elementor-element-d270a21 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="6662023" class="elementor-element elementor-element-6662023 elementor-widget elementor-widget-progress" data-element_type="progress.default">
				<div class="elementor-widget-container">
						<span class="elementor-title">Найдено ключей</span>
		
		<div class="elementor-progress-wrapper" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="'.$outPercent['percent'].'" aria-valuetext="Прогресс">
			<div class="elementor-progress-bar" data-max="'.$outPercent['percent'].'">
				<span class="elementor-progress-text">Прогресс</span>
									<span class="elementor-progress-percentage">'.$outPercent['percent'].'%</span>
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
				<section data-id="f1f6d4c" class="elementor-element elementor-element-f1f6d4c elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="a4c0187" class="elementor-element elementor-element-a4c0187 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="99402e6" class="elementor-element elementor-element-99402e6 elementor-widget elementor-widget-divider" data-element_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator"></span>
		</div>
				</div>
				</div>
						</div>
			</div>
		</div> 
						</div>
			</div>
		</section>
				<section data-id="baead33" class="elementor-element elementor-element-baead33 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="5a84a6d" class="elementor-element elementor-element-5a84a6d elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="8ee9b46" class="elementor-element elementor-element-8ee9b46 elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Доступные цели</h2>		</div>
				</div>
				
				<div data-id="603d171" class="elementor-element elementor-element-603d171 elementor--h-position-center elementor--v-position-middle elementor-widget elementor-widget-slides" data-element_type="slides.default">
				
				<div class="elementor-widget-container">
				
				
					<div class="elementor-slides-wrapper elementor-slick-slider" dir="ltr">
			<div class="elementor-slides slick-arrows-inside slick-dots-inside" data-slider_options="{&quot;slidesToShow&quot;:1,&quot;autoplaySpeed&quot;:5000,&quot;autoplay&quot;:true,&quot;infinite&quot;:true,&quot;pauseOnHover&quot;:true,&quot;speed&quot;:500,&quot;arrows&quot;:true,&quot;dots&quot;:true,&quot;rtl&quot;:false}" data-animation="fadeInUp">
			
			<!--
				<div class="elementor-repeater-item-9d88450 slick-slide"><div class="slick-slide-bg"></div><div  class="slick-slide-inner"><div class="elementor-slide-content"><div class="elementor-slide-heading">Форум</div><div class="elementor-slide-description">123</div><div  class="elementor-button elementor-slide-button elementor-size-sm">Click Here</div></div></div></div>
				
				-->
				
				<div class="elementor-repeater-item-3ba86c9 slick-slide"><div class="slick-slide-bg"></div><div  class="slick-slide-inner"><div class="elementor-slide-content"><div class="elementor-slide-heading">Ресторан</div><div class="elementor-slide-description">Добро пожаловать в лучший ресторан города! <br/> <br/> 1) В этот ресторан не попасть так просто. Бронировать столик нужно за 2 недели. Попробуйе забронировать столик на сегодняшний вечер! <br> 2) Разработчики, тестируя сайт, оставили где-то  план развития комании на месяц! Найдите его. <br/> 3) Найти имя директора компании. <br/> 4) У шеф-повара есть личная станица на этом сайте. Попробуйте найти её! <br/> 5) VIP столики могут резервировать только несколько привелегированных людей.. Попробуйте сделать резерв! </div>
<a href="pages/vulnerabilities/restaraunt/restaraunt.php" class="elementor-button elementor-slide-button elementor-size-sm">Перейти!</a>
<a href="pages/cheats/restarauntCheat.html" class="elementor-button elementor-slide-button elementor-size-sm">Подсказки</a>
</div>
</div>
</div>

<!--

<div class="elementor-repeater-item-a579d4d slick-slide"><div class="slick-slide-bg"></div><div  class="slick-slide-inner"><div class="elementor-slide-content"><div class="elementor-slide-heading">Сайт университета</div><div class="elementor-slide-description">123</div><div  class="elementor-button elementor-slide-button elementor-size-sm">Click Here</div></div></div></div>	
		
		
		-->
		
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
						</div>
			</div>
		</div>
		  
   </div>  

    <!--Footer component-->
    <section id="footer" class="jr-site-footer"><!--Now active fixed footer-->
       <!--  <div class="container-large">

' . tokenField() . '                            
                
        </div>
 -->
        <div class="copyright-bottom">
        Copyright Pavlukhin Dmitry. All rights reserved.  
        <span> | </span>     
        Powered by <a target="_blank" rel="designer" href="mailto:pavluhin_dima@mail.ru">Pavlukhin Dmitry</a>     
        </div>
    </section>
    <!--Ends-->
      
<script type=\'text/javascript\' src=\'includes/themes/elemento/assets/js/bootstrap.min4a7d.js?ver=20151215\'></script>
<script type=\'text/javascript\' src=\'includes/themes/elemento/assets/js/flexslider.min4a7d.js?ver=20151215\'></script>
<script type=\'text/javascript\' src=\'includes/themes/elemento/assets/js/skip-link-focus-fix4a7d.js?ver=20151215\'></script>
<script type=\'text/javascript\' src=\'includes/themes/elemento/assets/js/scriptsf269.js?ver=1.0.1\'></script>
<script type=\'text/javascript\' src=\'includes/js/wp-embed.min5010.js?ver=4.9.8\'></script>
<script type=\'text/javascript\' src=\'includes/js/imagesloaded.min55a0.js?ver=3.2.0\'></script>
<script type=\'text/javascript\' src=\'includes/plugins/elementor/assets/lib/slick/slick.minc245.js?ver=1.8.1\'></script>
<script type=\'text/javascript\' src=\'includes/plugins/elementor-pro/assets/lib/sticky/jquery.sticky.mincc91.js?ver=2.1.8\'></script>
<script type=\'text/javascript\'>
/* <![CDATA[ */
var ElementorProFrontendConfig = {"ajaxurl":"http:\/\/localhost\/wordpress\/wp-admin\/admin-ajax.php","nonce":"9e9bb5a335","shareButtonsNetworks":{"facebook":{"title":"Facebook","has_counter":true},"twitter":{"title":"Twitter"},"google":{"title":"Google+","has_counter":true},"linkedin":{"title":"LinkedIn","has_counter":true},"pinterest":{"title":"Pinterest","has_counter":true},"reddit":{"title":"Reddit","has_counter":true},"vk":{"title":"VK","has_counter":true},"odnoklassniki":{"title":"OK","has_counter":true},"tumblr":{"title":"Tumblr"},"delicious":{"title":"Delicious"},"digg":{"title":"Digg"},"skype":{"title":"Skype"},"stumbleupon":{"title":"StumbleUpon","has_counter":true},"telegram":{"title":"Telegram"},"pocket":{"title":"Pocket","has_counter":true},"xing":{"title":"XING","has_counter":true},"whatsapp":{"title":"WhatsApp"},"email":{"title":"Email"},"print":{"title":"Print"}},"facebook_sdk":{"lang":"en_US","app_id":""}};
/* ]]> */
</script>
<script type=\'text/javascript\' src=\'includes/plugins/elementor-pro/assets/js/frontend.mincc91.js?ver=2.1.8\'></script>
<script type=\'text/javascript\' src=\'includes/js/jquery/ui/position.mine899.js?ver=1.11.4\'></script>
<script type=\'text/javascript\' src=\'includes/plugins/elementor/assets/lib/dialog/dialog.min268f.js?ver=4.5.0\'></script>
<script type=\'text/javascript\' src=\'includes/plugins/elementor/assets/lib/waypoints/waypoints.min05da.js?ver=4.0.2\'></script>
<script type=\'text/javascript\' src=\'includes/plugins/elementor/assets/lib/swiper/swiper.jquery.mincb20.js?ver=4.4.3\'></script>
<script type=\'text/javascript\'>
/* <![CDATA[ */
var elementorFrontendConfig = {"isEditMode":"","is_rtl":"","breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"version":"2.2.6","urls":{"assets":"http:\/\/localhost\/wordpress\/includes\/plugins\/elementor\/assets\/"},"settings":{"page":[],"general":{"elementor_global_image_lightbox":"yes","elementor_enable_lightbox_in_editor":"yes"}},"post":{"id":44,"title":"\u041b\u0438\u0447\u043d\u044b\u0439 \u043f\u0440\u043e\u0444\u0438\u043b\u044c","excerpt":""}};
/* ]]> */
</script>
<script type=\'text/javascript\' src=\'includes/plugins/elementor/assets/js/frontend.mindbc2.js?ver=2.2.6\'></script>

</body>

</html>




';

#  '#.$VulnWappSession['username']; echo ' -->

?>
