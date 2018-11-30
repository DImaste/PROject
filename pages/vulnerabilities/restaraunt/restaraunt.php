<?php

##
## Уязвимый сайт ресторана
##

define( 'root_page', '' );
require_once root_page . '../../../functions.php';


if( !IsLoggedIn() ) {
    PushMessage( "Пожалуйста, авторизуйтесь!" );
    RedirectTo( 'login.php' );
}


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



for ($i = 0; $i < 5; $i++) {

    $Increment = $i+1;
    $queryFlags = ("SELECT flag FROM flags where id='{$Increment}'");
    $resultFlags = @mysqli_query($GLOBALS["___mysqli_ston"], $queryFlags);
    $outFlags = mysqli_fetch_array($resultFlags);
    $Checkflags[$i]= $outFlags['flag'];

    #echo $Checkflags [$i];
    #echo '<br/>';
}

#----------------------------

if (isset($_GET['page']) && ($_GET['page'])=="chief"){
    $chiefPage = file_get_contents('chief.php');
    echo($Checkflags[3]);
    echo($chiefPage)  ;

    exit();
}


file_put_contents('temp/plan.txt', '');
file_put_contents('temp/plan.txt', 'Riarden Restaraunt develpoing plan.    
 ------------------------------------------------------  
      If you want to talk with Riarden, leave him a message in Chiefs feedback form. Just put the Message "ToGRearden"   
 ------------------------------------------------------ 

          We are planning to be the best. 
          '.$Checkflags[1].'
          Have a good day! 
          ');



$reserve_default="weeks";

setcookie("reserve", $reserve_default);

if( isset( $_POST[ 'Reserve' ] ) ) {

    if ($_COOKIE['reserve']=="tonight" && $_POST['Guest_name']!="JOHNGALT")
    {
        echo '<script>alert("Поздравляем столик зарезервирован на сегодняшний вечер!    " +
        "'.$Checkflags[0].'")</script>
        ';
    }

    if ($_COOKIE['reserve']=="weeks" && $_POST['Guest_name']!="JOHNGALT")
    {
        echo '<script>alert("Поздравляем столик зарезервирован через две недели!")</script>';
    }

    if ($_POST['Guest_name']=="JOHNGALT")
    {
        echo '<script>alert("Джон, добрый день! Ваш VIP столик свободен! Ждём вас в любое время!    " +
        "'.$Checkflags[4].'")</script>
        ';

    }



}

#TODO Home button, Алерт скрытие и появление, дейстивие на бронирование стола, футер и так далее DONE


echo '

<!DOCTYPE html>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
		<title>Ресторан</title>
<link rel=\'dns-prefetch\' href=\'http://fonts.googleapis.com/\' />
<link rel=\'dns-prefetch\' href=\'http://s.w.org/\' />
<link rel="alternate" type="application/rss+xml" title=" &raquo; Feed" href="http://localhost/wordpress/feed/" />
<link rel="alternate" type="application/rss+xml" title=" &raquo; Comments Feed" href="http://localhost/wordpress/comments/feed/" />
		<script type="text/javascript">
			window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/11\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/11\/svg\/","svgExt":".svg","source":{"concatemoji":"http:\/\/localhost\/wordpress\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.9.8"}};
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
<link rel=\'stylesheet\' id=\'bootstrap-css\'  href=\'../../../includes/themes/elemento/assets/css/bootstrap.min4a7d.css?ver=20151215\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'flexslider-css\'  href=\'../../../includes/themes/elemento/assets/css/flexslider.min4a7d.css?ver=20151215\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'font-awesome-css\'  href=\'../../../includes/plugins/elementor/assets/lib/font-awesome/css/font-awesome.min1849.css?ver=4.7.0\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elemento-style-css\'  href=\'../../../includes/themes/elemento/style4b1d.css?ver=1.8\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elemento-responsive-css\'  href=\'../../../includes/themes/elemento/assets/css/responsive5152.css?ver=1.0\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-icons-css\'  href=\'../../../includes/plugins/elementor/assets/lib/eicons/css/elementor-icons.min9e95.css?ver=3.8.0\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-animations-css\'  href=\'../../../includes/plugins/elementor/assets/lib/animations/animations.mindbc2.css?ver=2.2.6\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-frontend-css\'  href=\'../../../includes/plugins/elementor/assets/css/frontend.mindbc2.css?ver=2.2.6\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-pro-css\'  href=\'../../../includes/plugins/elementor-pro/assets/css/frontend.mincc91.css?ver=2.1.8\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-global-css\'  href=\'../../../includes/uploads/elementor/css/globale8e6.css?ver=1540254196\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'elementor-post-64-css\'  href=\'../../../includes/uploads/elementor/css/post-640e22.css?ver=1540991144\' type=\'text/css\' media=\'all\' />
<link rel=\'stylesheet\' id=\'google-fonts-1-css\'  href=\'https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CBitter%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRaleway%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;ver=4.9.8\' type=\'text/css\' media=\'all\' />
<script type=\'text/javascript\' src=\'../../../includes/js/jquery/jqueryb8ff.js?ver=1.12.4\'></script>
<script type=\'text/javascript\' src=\'../../../includes/js/jquery/jquery-migrate.min330a.js?ver=1.4.1\'></script>
<link rel=\'https://api.w.org/\' href=\'http://localhost/wordpress/wp-json/\' />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://localhost/wordpress/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://localhost/wordpress/wp-includes/wlwmanifest.xml" /> 
<meta name="generator" content="WordPress 4.9.8" />
<link rel="canonical" href="index.html" />
<link rel=\'shortlink\' href=\'http://localhost/wordpress/?p=64\' />
<link rel="alternate" type="application/json+oembed" href="http://localhost/wordpress/wp-json/oembed/1.0/embed?url=http%3A%2F%2Flocalhost%2Fwordpress%2Frestaraunt%2F" />
<link rel="alternate" type="text/xml+oembed" href="http://localhost/wordpress/wp-json/oembed/1.0/embed?url=http%3A%2F%2Flocalhost%2Fwordpress%2Frestaraunt%2F&amp;format=xml" />
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
			<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
</head>



<body class="page-template page-template-elementor_canvas page page-id-64 elementor-default elementor-template-canvas elementor-page elementor-page-64">




<div class="body-wrapp  ">
<header id="siteHeader" class="jr-site-header pd-a-15 absolute-header menu-inline">

<div class="container-large">
            <div class="row align-flex-item-center full-width">
                <div class="col-md-3">
                    <div class="logo-holder">
                                                    <h1 class="site-title"><a href="http://localhost/wordpress/" rel="home"></a></h1>
                                                        <p class="site-description">Уязвимое веб-приложение!</p>
                                                </div>
                </div>

                <div class="col-md-9 text-align-right">
                                    <nav class="menu-main">
                    <div class="menu-home-container"><ul id="primary-menu" class="floted-li clearfix d-i-b"><li id="menu-item-31" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-31"><a href="../../../myprofile.php"><b>Личный профиль</b></a></li>
</ul></div>                    </nav>
                </div>
            </div>
        </div>
    </header>






			<div class="elementor elementor-64">
			<div class="elementor-inner">
				<div class="elementor-section-wrap">
							<section data-id="5b286423" class="elementor-element elementor-element-5b286423 elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;shape_divider_bottom&quot;:&quot;curve&quot;,&quot;shape_divider_bottom_negative&quot;:&quot;yes&quot;}" data-element_type="section">
							<div class="elementor-background-overlay"></div>
						<div class="elementor-shape elementor-shape-bottom" data-negative="true">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
	<path class="elementor-shape-fill" d="M500,97C126.7,96.3,0.8,19.8,0,0v100l1000,0V1C1000,19.4,873.3,97.8,500,97z"/>
</svg>		</div>
					<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="4eb1094f" class="elementor-element elementor-element-4eb1094f elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="2c8e1ddb" class="elementor-element elementor-element-2c8e1ddb elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h1 class="elementor-heading-title elementor-size-default">Ресторан<br>"Столовая УрФУ"</h1>		</div>
				</div>
				<div data-id="9c1733b" class="elementor-element elementor-element-9c1733b elementor-widget elementor-widget-divider" data-element_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator"></span>
		</div>
				</div>
				</div>
				<div data-id="6957576a" class="elementor-element elementor-element-6957576a elementor-align-center elementor-widget elementor-widget-button" data-element_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="#reserve" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">Зарезервировать столик</span>
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
				<section data-id="4102acf9" class="elementor-element elementor-element-4102acf9 elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="75f023e1" class="elementor-element elementor-element-75f023e1 elementor-column elementor-col-50 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="100c105" class="elementor-element elementor-element-100c105 elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">О нас</h2>		</div>
				</div>
				<div data-id="7cb41677" class="elementor-element elementor-element-7cb41677 elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Лучшие из лучших</h2>		</div>
				</div>
				<div data-id="4832335d" class="elementor-element elementor-element-4832335d elementor-widget elementor-widget-divider" data-element_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator"></span>
		</div>
				</div>
				</div>
				<div data-id="5faa99c2" class="elementor-element elementor-element-5faa99c2 elementor-widget elementor-widget-text-editor" data-element_type="text-editor.default">
				<div class="elementor-widget-container">
					<div class="elementor-text-editor elementor-clearfix"><span style="color: #676767; font-family: \'Playfair Display\', \'PT Serif\', serif; font-size: 20px; font-style: italic;">&#8220;Столовая УрФУ&#8221; – один из самых изысканных ресторанов Екатеринбурга, представляет собой уютный уголок спокойствия на границе Европы и Азии. Он идеально создан как для традиционных семейных трапез, приятного уединения романтических вечеров, посиделок с друзьями, так и для проведения корпоративных торжеств. </span></div>
				</div>
				</div>
						</div>
			</div>
		</div>
				<div data-id="4dd5447b" class="elementor-element elementor-element-4dd5447b elementor-column elementor-col-50 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="28d042ab" class="elementor-element elementor-element-28d042ab elementor-widget elementor-widget-image" data-element_type="image.default">
				<div class="elementor-widget-container">
					<div class="elementor-image">
										<img src="../../../includes/uploads/elementor/thumbs/salad-2592039_1280-1-ntvggkws0nqivo61hfq59no2ayc4mqaayidlcn4m4g.jpg" title="salad-2592039_1280-1.jpg" alt="salad-2592039_1280-1.jpg" />											</div>
				</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id="2ca78870" class="elementor-element elementor-element-2ca78870 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;shape_divider_top&quot;:&quot;curve&quot;,&quot;shape_divider_top_negative&quot;:&quot;yes&quot;}" data-element_type="section">
							<div class="elementor-background-overlay"></div>
						<div class="elementor-shape elementor-shape-top" data-negative="true">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
	<path class="elementor-shape-fill" d="M500,97C126.7,96.3,0.8,19.8,0,0v100l1000,0V1C1000,19.4,873.3,97.8,500,97z"/>
</svg>		</div>
					<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="4d3261ac" class="elementor-element elementor-element-4d3261ac elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="15320ff5" class="elementor-element elementor-element-15320ff5 elementor-widget elementor-widget-menu-anchor" data-element_type="menu-anchor.default">
				<div class="elementor-widget-container">
					<div id="menu" class="elementor-menu-anchor"></div>
				</div>
				</div>
				<div data-id="3514f6ef" class="elementor-element elementor-element-3514f6ef elementor-widget elementor-widget-image" data-element_type="image.default">
				<div class="elementor-widget-container">
					<div class="elementor-image">
										<img src="../../../includes/uploads/elementor/thumbs/cooking-spoon-159122_640-ntvggmsgebpvx5436n007hqfbhu4cutkykmsuz6cjk.png" title="cooking-spoon-159122_640.png" alt="cooking-spoon-159122_640.png" />											</div>
				</div>
				</div>
				<div data-id="675ed3dc" class="elementor-element elementor-element-675ed3dc elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Наше меню</h2>		</div>
				</div>
				<div data-id="1e2cdc58" class="elementor-element elementor-element-1e2cdc58 elementor-widget elementor-widget-price-list" data-element_type="price-list.default">
				<div class="elementor-widget-container">
			
		<ul class="elementor-price-list">

									<li class="elementor-price-list-item">									<div class="elementor-price-list-image">
					<img src="../../../includes/uploads/elementor/thumbs/food-1631727_1280-ntvggnqbdnynmnb5dtfj5y7bgazkr4tm7ncemmnwzu.jpg" alt="GOLDEN PORK ESCALOPE" />				</div>
				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">GOLDEN PORK ESCALOPE</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">19 Р</span>
										</div>
															<p class="elementor-price-list-description">Herby breadcrumbed free-range pork escalope with cherry tomato salad & crumbled feta</p>
								</div>
				</li>												<li class="elementor-price-list-item">									<div class="elementor-price-list-image">
					<img src="../../../includes/uploads/elementor/thumbs/salad-2068210_1920-ntvggoo5khzxy99s8bu5qfys1ouxytxcjrzw3wmitm.jpg" alt="CAULIFLOWER CHEESE GNOCCHI" />				</div>
				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">CAULIFLOWER CHEESE GNOCCHI</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">10 Р</span>
										</div>
															<p class="elementor-price-list-description">Organic potato gnocchi, creamy cauliflower & Gorgonzola sauce & roasted cauliflower</p>
								</div>
				</li>												<li class="elementor-price-list-item">									<div class="elementor-price-list-image">
					<img src="../../../includes/uploads/elementor/thumbs/food-712666_1280-ntvggqjty62ilh71xcnevfhp8gloe84t81av2gjqh6.jpg" alt="GENNARO’S TAGLIATELLE BOLOGNESE" />				</div>
				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">GENNARO’S TAGLIATELLE BOLOGNESE</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">18 Р</span>
										</div>
															<p class="elementor-price-list-description">Amazing pork & beef slow cooked with red wine, topped with pangrattato & Parmesan</p>
								</div>
				</li>												<li class="elementor-price-list-item">									<div class="elementor-price-list-image">
					<img src="../../../includes/uploads/elementor/thumbs/salad-2068210_1920-ntvggoo5khzxy99s8bu5qfys1ouxytxcjrzw3wmitm.jpg" alt="OXTAIL LASAGNE" />				</div>
				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">OXTAIL LASAGNE</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">13 Р</span>
										</div>
															<p class="elementor-price-list-description">Herby 12-hour slow-cooked oxtail & Chianti ragù layered with pasta, béchamel, mozzarella & Parmesan</p>
								</div>
				</li>												<li class="elementor-price-list-item">									<div class="elementor-price-list-image">
					<img src="../../../includes/uploads/elementor/thumbs/sweets-268296_1920-ntvggsfibu538p4bmdgo0f0mf8cetmc9walu10gy4q.jpg" alt="TIRAMISÙ" />				</div>
				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">TIRAMISÙ</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">6 Р</span>
										</div>
															<p class="elementor-price-list-description">Our take on the classic coffee-flavoured sponge, mascarpone & chocolate</p>
								</div>
				</li>												<li class="elementor-price-list-item">									<div class="elementor-price-list-image">
					<img src="../../../includes/uploads/elementor/thumbs/food-1247612_1280-ntvggub6pi7nvx1lbe9x5ejjm03590jqkjwszke5sa.jpg" alt="CHOCOLATE FUDGE SUNDAE" />				</div>
				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">CHOCOLATE FUDGE SUNDAE</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">8 Р</span>
										</div>
															<p class="elementor-price-list-description">Salted caramel popcorn & chocolate gelatos, brownie pieces & caramelised popcorn</p>
								</div>
				</li>					
		</ul>

				</div>
				</div>
				<div data-id="f3033a8" class="elementor-element elementor-element-f3033a8 elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h4 class="elementor-heading-title elementor-size-default">*Цены действуют при предъявлении студенческого билета</h4>		</div>
				</div>
				<div data-id="274b78c0" class="elementor-element elementor-element-274b78c0 elementor-align-center elementor-widget elementor-widget-button" data-element_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="#reserve" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">Зарезервировать столик</span>
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
				<section data-id="6c5ce324" class="elementor-element elementor-element-6c5ce324 elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="10c9b49b" class="elementor-element elementor-element-10c9b49b elementor-column elementor-col-50 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="4315212c" class="elementor-element elementor-element-4315212c elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">"Столовая УрФУ"</h2>		</div>
				</div>
				<div data-id="6fed52be" class="elementor-element elementor-element-6fed52be elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Лучший ресторан Екатеринбурга</h2>		</div>
				</div>
				<div data-id="571d4f98" class="elementor-element elementor-element-571d4f98 elementor-widget elementor-widget-divider" data-element_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator"></span>
		</div>
				</div>
				</div>
				<div data-id="5d9fcaa4" class="elementor-element elementor-element-5d9fcaa4 elementor-widget elementor-widget-text-editor" data-element_type="text-editor.default">
				<div class="elementor-widget-container">
					<div class="elementor-text-editor elementor-clearfix"><span style="color: #676767; font-family: \'Playfair Display\', \'PT Serif\', serif; font-size: 20px; font-style: italic;">В кулинарной коллекции ресторана собрано все лучшее, что можно встретить в известнейших местах мира и это дополняется современными тенденциями в мировой кухне, которые адаптируются и аккуратно вписываются в концепцию нашего ресторана. </span></div>
				</div>
				</div>
				<div data-id="37d2e0e8" class="elementor-element elementor-element-37d2e0e8 elementor-align-center elementor-widget elementor-widget-button" data-element_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="#menu" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">Меню</span>
		</span>
					</a>
		</div>
				</div>
				</div>
						</div>
			</div>
		</div>
				<div data-id="4c5c9fad" class="elementor-element elementor-element-4c5c9fad elementor-column elementor-col-50 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<section data-id="64f81fa5" class="elementor-element elementor-element-64f81fa5 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-inner-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="76ae9b0a" class="elementor-element elementor-element-76ae9b0a elementor-column elementor-col-50 elementor-inner-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="62b9a28" class="elementor-element elementor-element-62b9a28 elementor-widget elementor-widget-image" data-element_type="image.default">
				<div class="elementor-widget-container">
					<div class="elementor-image">
										<img width="300" height="200" src="../../../includes/uploads/2018/07/restaurant-2662988_1280-300x200.jpg" class="attachment-medium size-medium" alt="" srcset="../../../includes/uploads/2018/07/restaurant-2662988_1280-300x200.jpg 300w, ../../../includes/uploads/2018/07/restaurant-2662988_1280-768x512.jpg 768w, ../../../includes/uploads/2018/07/restaurant-2662988_1280-1024x682.jpg 1024w, ../../../includes/uploads/2018/07/restaurant-2662988_1280-525x350.jpg 525w, ../../../includes/uploads/2018/07/restaurant-2662988_1280-105x70.jpg 105w, ../../../includes/uploads/2018/07/restaurant-2662988_1280.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" />											</div>
				</div>
				</div>
						</div>
			</div>
		</div>
				<div data-id="250613ea" class="elementor-element elementor-element-250613ea elementor-column elementor-col-50 elementor-inner-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="f218dbe" class="elementor-element elementor-element-f218dbe elementor-widget elementor-widget-image" data-element_type="image.default">
				<div class="elementor-widget-container">
					<div class="elementor-image">
										<img width="300" height="200" src="../../../includes/uploads/2018/07/bar-2689548_1280-300x200.jpg" class="attachment-medium size-medium" alt="" srcset="../../../includes/uploads/2018/07/bar-2689548_1280-300x200.jpg 300w, ../../../includes/uploads/2018/07/bar-2689548_1280-768x512.jpg 768w, ../../../includes/uploads/2018/07/bar-2689548_1280-1024x682.jpg 1024w, ../../../includes/uploads/2018/07/bar-2689548_1280-525x350.jpg 525w, ../../../includes/uploads/2018/07/bar-2689548_1280-105x70.jpg 105w, ../../../includes/uploads/2018/07/bar-2689548_1280.jpg 1280w" sizes="(max-width: 300px) 100vw, 300px" />											</div>
				</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<div data-id="5bf27c59" class="elementor-element elementor-element-5bf27c59 elementor-widget elementor-widget-image" data-element_type="image.default">
				<div class="elementor-widget-container">
					<div class="elementor-image">
										<img src="../../../includes/uploads/elementor/thumbs/restaurant-2623071_1280-ntvggw71wrepo99z4v6ut0mq7c3qpfwbykk9pz7bsw.jpg" title="restaurant-2623071_1280.jpg" alt="restaurant-2623071_1280.jpg" />											</div>
				</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id="51a5087c" class="elementor-element elementor-element-51a5087c elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" data-element_type="section">
							<div class="elementor-background-overlay"></div>
							<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="2a512e92" class="elementor-element elementor-element-2a512e92 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="3d1b546c" class="elementor-element elementor-element-3d1b546c elementor-widget elementor-widget-image" data-element_type="image.default">
				<div class="elementor-widget-container">
					<div class="elementor-image">
										<img src="../../../includes/uploads/elementor/thumbs/cooking-spoon-159122_640-ntvggmsgebpvx5436n007hqfbhu4cutkykmsuz6cjk.png" title="cooking-spoon-159122_640.png" alt="cooking-spoon-159122_640.png" />											</div>
				</div>
				</div>
				<div data-id="14832cb7" class="elementor-element elementor-element-14832cb7 elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Отзывы гостей</h2>		</div>
				</div>
				<div data-id="4d2efe57" class="elementor-element elementor-element-4d2efe57 elementor-testimonial--skin-bubble elementor-testimonial--layout-image_stacked elementor-testimonial--align-center elementor-widget elementor-widget-testimonial-carousel" data-settings="{&quot;slides_per_view&quot;:&quot;2&quot;,&quot;slides_per_view_tablet&quot;:&quot;1&quot;,&quot;slides_per_view_mobile&quot;:&quot;1&quot;,&quot;speed&quot;:500,&quot;loop&quot;:&quot;yes&quot;,&quot;space_between&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:10},&quot;space_between_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:10},&quot;space_between_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:10}}" data-element_type="testimonial-carousel.default">
				<div class="elementor-widget-container">
					<div class="elementor-swiper">
			<div class="elementor-main-swiper swiper-container">
				<div class="swiper-wrapper">
											<div class="swiper-slide">
									<div class="elementor-testimonial">
							<div class="elementor-testimonial__content">
					<div class="elementor-testimonial__text">
						Интересный интерьер,в одном зале современный прованс - светлый, уютный, в другом - насыщенные оттенки Центральной Азии, меню тоже представлено в двух вариантах, но блюда можно заказывать, независимо от зала, в котором вы расположились. Приятное обслуживание, подача блюд и, главное, все очень вкусно!					</div>
									</div>
						<div class="elementor-testimonial__footer">
									<div class="elementor-testimonial__image">
						<img src="../../../includes/uploads/2018/07/4-150x150.jpg" alt="Николай Иванович">
					</div>
								<cite class="elementor-testimonial__cite"><span class="elementor-testimonial__name">Николай Иванович</span></cite>			</div>
		</div>
								</div>
											<div class="swiper-slide">
									<div class="elementor-testimonial">
							<div class="elementor-testimonial__content">
					<div class="elementor-testimonial__text">
						Шикарный интерьер, просто не хочется уходить. Очень вкусная еда, прекрасное обслуживание и доступные цены. Порадовали зарядники для посетителей.					</div>
									</div>
						<div class="elementor-testimonial__footer">
									<div class="elementor-testimonial__image">
						<img src="../../../includes/uploads/2018/07/3-150x150.jpg" alt="Ефросинья Анатольевна">
					</div>
								<cite class="elementor-testimonial__cite"><span class="elementor-testimonial__name">Ефросинья Анатольевна</span></cite>			</div>
		</div>
								</div>
									</div>
																					</div>
		</div>
				</div>
				</div>
				<div data-id="665a5d68" class="elementor-element elementor-element-665a5d68 elementor-align-center elementor-widget elementor-widget-button" data-element_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="#reserve" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">Зарезервировать</span>
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
				<section data-id="2fa0eb98" class="elementor-element elementor-element-2fa0eb98 elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="1354e2a8" class="elementor-element elementor-element-1354e2a8 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="6a0ae8ea" class="elementor-element elementor-element-6a0ae8ea elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Галерея</h2>		</div>
				</div>
				<div data-id="affd747" class="elementor-element elementor-element-affd747 elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Наши знаменитые завтраки</h2>		</div>
				</div>
				<div data-id="30fc68e" class="elementor-element elementor-element-30fc68e elementor-widget elementor-widget-divider" data-element_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator"></span>
		</div>
				</div>
				</div>
				<div data-id="71470d49" class="elementor-element elementor-element-71470d49 gallery-spacing-custom elementor-widget elementor-widget-image-gallery" data-element_type="image-gallery.default">
				<div class="elementor-widget-container">
					<div class="elementor-image-gallery">
			<div id=\'gallery-1\' class=\'gallery galleryid-64 gallery-columns-3 gallery-size-medium_large\'><figure class=\'gallery-item\'>
			<div class=\'gallery-icon landscape\'>
				<a data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="71470d49" href=\'../../../includes/uploads/2018/07/food-712666_1280.jpg\'><img width="640" height="427" src="../../../includes/uploads/2018/07/food-712666_1280-768x512.jpg" class="attachment-medium_large size-medium_large" alt="" srcset="../../../includes/uploads/2018/07/food-712666_1280-768x512.jpg 768w, ../../../includes/uploads/2018/07/food-712666_1280-300x200.jpg 300w, ../../../includes/uploads/2018/07/food-712666_1280-1024x682.jpg 1024w, ../../../includes/uploads/2018/07/food-712666_1280-525x350.jpg 525w, ../../../includes/uploads/2018/07/food-712666_1280-105x70.jpg 105w, ../../../includes/uploads/2018/07/food-712666_1280.jpg 1280w" sizes="(max-width: 640px) 100vw, 640px" /></a>
			</div></figure><figure class=\'gallery-item\'>
			<div class=\'gallery-icon landscape\'>
				<a data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="71470d49" href=\'../../../includes/uploads/2018/07/food-1155130_1280.jpg\'><img width="640" height="427" src="../../../includes/uploads/2018/07/food-1155130_1280-768x512.jpg" class="attachment-medium_large size-medium_large" alt="" srcset="../../../includes/uploads/2018/07/food-1155130_1280-768x512.jpg 768w, ../../../includes/uploads/2018/07/food-1155130_1280-300x200.jpg 300w, ../../../includes/uploads/2018/07/food-1155130_1280-1024x682.jpg 1024w, ../../../includes/uploads/2018/07/food-1155130_1280-525x350.jpg 525w, ../../../includes/uploads/2018/07/food-1155130_1280-105x70.jpg 105w, ../../../includes/uploads/2018/07/food-1155130_1280.jpg 1280w" sizes="(max-width: 640px) 100vw, 640px" /></a>
			</div></figure><figure class=\'gallery-item\'>
			<div class=\'gallery-icon landscape\'>
				<a data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="71470d49" href=\'../../../includes/uploads/2018/07/food-1247612_1280.jpg\'><img width="640" height="427" src="../../../includes/uploads/2018/07/food-1247612_1280-768x512.jpg" class="attachment-medium_large size-medium_large" alt="" srcset="../../../includes/uploads/2018/07/food-1247612_1280-768x512.jpg 768w, ../../../includes/uploads/2018/07/food-1247612_1280-300x200.jpg 300w, ../../../includes/uploads/2018/07/food-1247612_1280-1024x682.jpg 1024w, ../../../includes/uploads/2018/07/food-1247612_1280-525x350.jpg 525w, ../../.w./includes/uploads/2018/07/food-1247612_1280-105x70.jpg 105w, ../../../includes/uploads/2018/07/food-1247612_1280.jpg 1280w" sizes="(max-width: 640px) 100vw, 640px" /></a>
			</div></figure><figure class=\'gallery-item\'>
			<div class=\'gallery-icon landscape\'>
				<a data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="71470d49" href=\'../../../includes/uploads/2018/07/food-1631727_1280.jpg\'><img width="640" height="427" src="../../../includes/uploads/2018/07/food-1631727_1280-768x512.jpg" class="attachment-medium_large size-medium_large" alt="" srcset="../../../includes/uploads/2018/07/food-1631727_1280-768x512.jpg 768w, ../../../includes/uploads/2018/07/food-1631727_1280-300x200.jpg 300w, ../../../includes/uploads/2018/07/food-1631727_1280-1024x682.jpg 1024w, ../../../includes/uploads/2018/07/food-1631727_1280-525x350.jpg 525w, ../../../includes/uploads/2018/07/food-1631727_1280-105x70.jpg 105w, ../../../includes/uploads/2018/07/food-1631727_1280.jpg 1280w" sizes="(max-width: 640px) 100vw, 640px" /></a>
			</div></figure><figure class=\'gallery-item\'>
			<div class=\'gallery-icon landscape\'>
				<a data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="71470d49" href=\'../../../includes/uploads/2018/07/salad-2068210_1920.jpg\'><img width="640" height="423" src="../../../includes/uploads/2018/07/salad-2068210_1920-768x508.jpg" class="attachment-medium_large size-medium_large" alt="" srcset="../../../includes/uploads/2018/07/salad-2068210_1920-768x508.jpg 768w, ../../../includes/uploads/2018/07/salad-2068210_1920-300x198.jpg 300w, ../../../includes/uploads/2018/07/salad-2068210_1920-1024x677.jpg 1024w, ../../../includes/uploads/2018/07/salad-2068210_1920-105x70.jpg 105w" sizes="(max-width: 640px) 100vw, 640px" /></a>
			</div></figure><figure class=\'gallery-item\'>
			<div class=\'gallery-icon landscape\'>
				<a data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="71470d49" href=\'../../../includes/uploads/2018/07/sweets-268296_1920.jpg\'><img width="640" height="423" src="../../../includes/uploads/2018/07/sweets-268296_1920-768x508.jpg" class="attachment-medium_large size-medium_large" alt="" srcset="../../../includes/uploads/2018/07/sweets-268296_1920-768x508.jpg 768w, ../../../includes/uploads/2018/07/sweets-268296_1920-300x199.jpg 300w, ../../../includes/uploads/2018/07/sweets-268296_1920-1024x678.jpg 1024w, ../../../includes/uploads/2018/07/sweets-268296_1920-105x70.jpg 105w" sizes="(max-width: 640px) 100vw, 640px" /></a>
			</div></figure>
		</div>
		</div>
				</div>
				</div>
				<div data-id="2eec2fe3" class="elementor-element elementor-element-2eec2fe3 elementor-align-center elementor-widget elementor-widget-button" data-element_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="#menu" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">Меню</span>
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
		
		<!-- JOHNGALT says check the website security! Who is JOHNGALT? -->
		
				<section data-id="7ba13608" class="elementor-element elementor-element-7ba13608 elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" data-element_type="section">
							<div class="elementor-background-overlay"></div>
							<div class="elementor-container elementor-column-gap-no">
				<div class="elementor-row">
				<div data-id="15582cfe" class="elementor-element elementor-element-15582cfe elementor-column elementor-col-50 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="3cc4ff95" class="elementor-element elementor-element-3cc4ff95 elementor-widget elementor-widget-menu-anchor" data-element_type="menu-anchor.default">
				<div class="elementor-widget-container">
					<div id="reserve" class="elementor-menu-anchor"></div>
				</div>
				</div>
				<div data-id="5927aca" class="elementor-element elementor-element-5927aca elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Зарезервируйте столик</h2>		</div>
				</div>
				<div data-id="291e42ed" class="elementor-element elementor-element-291e42ed elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h3 class="elementor-heading-title elementor-size-default">Время работы</h3>		</div>
				</div>
				<div data-id="110cc920" class="elementor-element elementor-element-110cc920 elementor-widget elementor-widget-divider" data-element_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator"></span>
		</div>
				</div>
				</div>
				<div data-id="7ae8421b" class="elementor-element elementor-element-7ae8421b elementor-widget elementor-widget-price-list" data-element_type="price-list.default">
				<div class="elementor-widget-container">
			
		<ul class="elementor-price-list">

									<li class="elementor-price-list-item">				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">Понедельник</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">8:00 - 16:00</span>
										</div>
												</div>
				</li>												<li class="elementor-price-list-item">				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">Вторник</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">8:00 - 16:00</span>
										</div>
												</div>
				</li>												<li class="elementor-price-list-item">				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">Среда</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">8:00 - 16:00</span>
										</div>
												</div>
				</li>												<li class="elementor-price-list-item">				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">Четверг</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">8:00 - 16:00</span>
										</div>
												</div>
				</li>												<li class="elementor-price-list-item">				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">Пятница</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">8:00 - 16:00</span>
										</div>
												</div>
				</li>												<li class="elementor-price-list-item">				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">Суббота</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">Выходной</span>
										</div>
												</div>
				</li>												<li class="elementor-price-list-item">				
				<div class="elementor-price-list-text">
									<div class="elementor-price-list-header">
											<span class="elementor-price-list-title">Воскресенье</span>
																		<span class="elementor-price-list-separator"></span>
																			<span class="elementor-price-list-price">Выходной</span>
										</div>
												</div>
				</li>					
		</ul>

				</div>
				</div>
						</div>
			</div>
		</div>
		
		
		
		
				<div data-id="77409d7e" class="elementor-element elementor-element-77409d7e elementor-column elementor-col-50 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					
					
					<div class="elementor-widget-wrap">
				<div data-id="8d5dfc3" class="elementor-element elementor-element-8d5dfc3 elementor-widget elementor-widget-alert" data-element_type="alert.default">
				
				
				<div class="elementor-widget-container">
				
				
				<div data-id="ec2ab49" class="elementor-element elementor-element-ec2ab49 animated fadeInDown elementor-button-align-center elementor-invisible elementor-widget elementor-widget-form  elementor-widget-login" data-settings="{&quot;_animation&quot;:&quot;fadeInDown&quot;}" data-element_type="login.default">
				
					<div class="elementor-widget-container">
						
						
						
						
			<form class="elementor-login elementor-form" method="post" action="restaraunt.php">

			<div class="elementor-form-fields-wrapper elementor-labels-">
				
								<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-name elementor-col-100 elementor-field-required">
					<label for="form-field-name" class="elementor-field-label elementor-screen-only">Name</label><input size="1" type="text" name="Guest_name" id="form-field-name" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="Ваше имя" required="required" aria-required="true">				</div>
					
					<br/>
					
								<div class="elementor-field-type-number elementor-field-group elementor-column elementor-field-group-field_1 elementor-col-100 elementor-field-required">
					<label for="form-field-field_1" class="elementor-field-label elementor-screen-only">Guests</label><input type="number" name="Guest_num" id="form-field-field_1" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="Количество гостей" required="required" aria-required="true" min="1" max="7">				</div>
					
					
								<div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-100">
					<button type="submit" class="elementor-button elementor-size-sm elementor-animation-grow" id="check" name="Reserve">
						<span >
																						<span class="elementor-button-text">Зарезервировать</span>
													</span>
					</button>
					
				</div>
			</div>
		</form>
		
		
		
		
		
		
		
		
		
				</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id="3e60c630" class="elementor-element elementor-element-3e60c630 elementor-section-full_width elementor-section-content-middle elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="4ff821ac" class="elementor-element elementor-element-4ff821ac elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="12f54214" class="elementor-element elementor-element-12f54214 elementor-widget elementor-widget-google_maps" data-element_type="google_maps.default">
				<div class="elementor-widget-container">
			<div class="elementor-custom-embed"><iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%D0%95%D0%BA%D0%B0%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B1%D1%83%D1%80%D0%B3%20%D0%9C%D0%B8%D1%80%D0%B0%2032&amp;t=m&amp;z=14&amp;output=embed&amp;iwloc=near" aria-label="Екатеринбург Мира 32"></iframe></div>		</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id="7b3fdfac" class="elementor-element elementor-element-7b3fdfac elementor-section-full_width elementor-section-content-middle elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="79a902b7" class="elementor-element elementor-element-79a902b7 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="7f5ac67c" class="elementor-element elementor-element-7f5ac67c elementor-shape-rounded elementor-widget elementor-widget-social-icons" data-element_type="social-icons.default">
				<div class="elementor-widget-container">
					<div class="elementor-social-icons-wrapper">
							<a class="elementor-icon elementor-social-icon elementor-social-icon-facebook elementor-animation-grow" href="#" target="_blank">
					<span class="elementor-screen-only">Facebook</span>
					<i class="fa fa-facebook"></i>
				</a>
							<a class="elementor-icon elementor-social-icon elementor-social-icon-twitter elementor-animation-grow" href="#" target="_blank">
					<span class="elementor-screen-only">Twitter</span>
					<i class="fa fa-twitter"></i>
				</a>
							<a class="elementor-icon elementor-social-icon elementor-social-icon-google-plus elementor-animation-grow" href="#" target="_blank">
					<span class="elementor-screen-only">Google-plus</span>
					<i class="fa fa-google-plus"></i>
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
				<section data-id="e77cc9f" class="elementor-element elementor-element-e77cc9f elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="1a9154fb" class="elementor-element elementor-element-1a9154fb elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="1ce87613" class="elementor-element elementor-element-1ce87613 elementor-widget elementor-widget-heading" data-element_type="heading.default">
				
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
		
		
		 <!--Footer component-->
    <section id="footer" class="jr-site-footer"><!--Now active fixed footer-->

        <div class="copyright-bottom">
        Copyright Pavlukhin Dmitry. All rights reserved.  
        <span> | </span>     
        Powered by <a target="_blank" rel="designer" href="mailto:pavluhin_dima@mail.ru">Pavlukhin Dmitry</a>     
        </div>
    </section>
    <!--Ends-->
		
		
		
		
		<script type=\'text/javascript\' src=\'../../../includes/themes/elemento/assets/js/bootstrap.min4a7d.js?ver=20151215\'></script>
<script type=\'text/javascript\' src=\'../../../includes/themes/elemento/assets/js/flexslider.min4a7d.js?ver=20151215\'></script>
<script type=\'text/javascript\' src=\'../../../includes/themes/elemento/assets/js/skip-link-focus-fix4a7d.js?ver=20151215\'></script>
<script type=\'text/javascript\' src=\'../../../includes/themes/elemento/assets/js/scriptsf269.js?ver=1.0.1\'></script>
<script type=\'text/javascript\' src=\'../../../includes/js/wp-embed.min5010.js?ver=4.9.8\'></script>
<script type=\'text/javascript\' src=\'../../../includes/js/imagesloaded.min55a0.js?ver=3.2.0\'></script>
<script type=\'text/javascript\' src=\'../../../includes/plugins/elementor-pro/assets/lib/sticky/jquery.sticky.mincc91.js?ver=2.1.8\'></script>
<script type=\'text/javascript\'>
/* <![CDATA[ */
var ElementorProFrontendConfig = {"ajaxurl":"http:\/\/localhost\/wordpress\/wp-admin\/admin-ajax.php","nonce":"80698508ee","shareButtonsNetworks":{"facebook":{"title":"Facebook","has_counter":true},"twitter":{"title":"Twitter"},"google":{"title":"Google+","has_counter":true},"linkedin":{"title":"LinkedIn","has_counter":true},"pinterest":{"title":"Pinterest","has_counter":true},"reddit":{"title":"Reddit","has_counter":true},"vk":{"title":"VK","has_counter":true},"odnoklassniki":{"title":"OK","has_counter":true},"tumblr":{"title":"Tumblr"},"delicious":{"title":"Delicious"},"digg":{"title":"Digg"},"skype":{"title":"Skype"},"stumbleupon":{"title":"StumbleUpon","has_counter":true},"telegram":{"title":"Telegram"},"pocket":{"title":"Pocket","has_counter":true},"xing":{"title":"XING","has_counter":true},"whatsapp":{"title":"WhatsApp"},"email":{"title":"Email"},"print":{"title":"Print"}},"facebook_sdk":{"lang":"en_US","app_id":""}};
/* ]]> */
</script>
<script type=\'text/javascript\' src=\'../../../includes/plugins/elementor-pro/assets/js/frontend.mincc91.js?ver=2.1.8\'></script>
<script type=\'text/javascript\' src=\'../../../includes/js/jquery/ui/position.mine899.js?ver=1.11.4\'></script>
<script type=\'text/javascript\' src=\'../../../includes/plugins/elementor/assets/lib/dialog/dialog.min268f.js?ver=4.5.0\'></script>
<script type=\'text/javascript\' src=\'../../../includes/plugins/elementor/assets/lib/waypoints/waypoints.min05da.js?ver=4.0.2\'></script>
<script type=\'text/javascript\' src=\'../../../includes/plugins/elementor/assets/lib/swiper/swiper.jquery.mincb20.js?ver=4.4.3\'></script>
<script type=\'text/javascript\'>
/* <![CDATA[ */
var elementorFrontendConfig = {"isEditMode":"","is_rtl":"","breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"version":"2.2.6","urls":{"assets":"http:\/\/localhost\/wordpress\/wp-content\/plugins\/elementor\/assets\/"},"settings":{"page":[],"general":{"elementor_global_image_lightbox":"yes","elementor_enable_lightbox_in_editor":"yes"}},"post":{"id":64,"title":"Restaraunt","excerpt":""}};
/* ]]> */
</script>
<script type=\'text/javascript\' src=\'../../../includes/plugins/elementor/assets/js/frontend.mindbc2.js?ver=2.2.6\'></script>
	</body>

</html>



';



?>