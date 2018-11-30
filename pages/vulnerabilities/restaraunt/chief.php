<?php

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
    RedirectTo( root_page . 'setup.php' );
}


for ($i = 0; $i < 5; $i++) {

    $Increment = $i+1;
    $queryFlags = ("SELECT flag FROM flags where id='{$Increment}'");
    $resultFlags = @mysqli_query($GLOBALS["___mysqli_ston"], $queryFlags);
    $outFlags = mysqli_fetch_array($resultFlags);
    $Checkflags[$i]= $outFlags['flag'];


}


if( isset( $_POST[ 'ToChief' ] ) ) {

    if ($_POST['MsgToChief']=="ToGRearden")
    {
        RedirectTo( root_page . 'FJF384gGDHW&@RGVFuh@dk3738y32gt874.php' );

    }

}








/*echo
'*/

?>

<!doctype html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<title>Шеф-повар</title>
<link rel='dns-prefetch' href='http://fonts.googleapis.com/' />
<link rel='dns-prefetch' href='http://s.w.org/' />
<link rel="alternate" type="application/rss+xml" title=" &raquo; Feed" href="http://localhost/wordpress/feed/" />
<link rel="alternate" type="application/rss+xml" title=" &raquo; Comments Feed" href="http://localhost/wordpress/comments/feed/" />
		<script type="text/javascript">
			window._wpemojiSettings = {"baseUrl":"https://s.w.org/images/core/emoji/11/72x72/","ext":".png","svgUrl":"https://s.w.org/images/core/emoji/11/svg/","svgExt":".svg","source":{"concatemoji":"http://localhost/wordpress/wp-includes/js/wp-emoji-release.min.js?ver=4.9.8"}};
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
<link rel='stylesheet' id='elemento-font-css'  href='https://fonts.googleapis.com/css?family=Libre+Franklin%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900&amp;ver=20151215' type='text/css' media='all' />
<link rel='stylesheet' id='bootstrap-css'  href='../../../includes/themes/elemento/assets/css/bootstrap.min4a7d.css?ver=20151215' type='text/css' media='all' />
<link rel='stylesheet' id='flexslider-css'  href='../../../includes/themes/elemento/assets/css/flexslider.min4a7d.css?ver=20151215' type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome-css'  href='../../../includes/plugins/elementor/assets/lib/font-awesome/css/font-awesome.min1849.css?ver=4.7.0' type='text/css' media='all' />
<link rel='stylesheet' id='elemento-style-css'  href='../../../includes/themes/elemento/style4b1d.css?ver=1.8' type='text/css' media='all' />
<link rel='stylesheet' id='elemento-responsive-css'  href='../../../includes/themes/elemento/assets/css/responsive5152.css?ver=1.0' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-css'  href='../../../includes/plugins/elementor/assets/lib/eicons/css/elementor-icons.min9e95.css?ver=3.8.0' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-animations-css'  href='../../../includes/plugins/elementor/assets/lib/animations/animations.mindbc2.css?ver=2.2.6' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-frontend-css'  href='../../../includes/plugins/elementor/assets/css/frontend.mindbc2.css?ver=2.2.6' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-pro-css'  href='../../../includes/plugins/elementor-pro/assets/css/frontend.mincc91.css?ver=2.1.8' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-global-css'  href='../../../includes/uploads/elementor/css/globale8e6.css?ver=1540254196' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-149-css'  href='../../../includes/uploads/elementor/css/post-149d084.css?ver=1543025210' type='text/css' media='all' />
<link rel='stylesheet' id='google-fonts-1-css'  href='https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;ver=4.9.8' type='text/css' media='all' />
<script type='text/javascript' src='../../../includes/js/jquery/jqueryb8ff.js?ver=1.12.4'></script>
<script type='text/javascript' src='../../../includes/js/jquery/jquery-migrate.min330a.js?ver=1.4.1'></script>
<link rel='https://api.w.org/' href='http://localhost/wordpress/wp-json/' />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://localhost/wordpress/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://localhost/wordpress/wp-includes/wlwmanifest.xml" />
<meta name="generator" content="WordPress 4.9.8" />
<link rel="canonical" href="index.html" />
<link rel='shortlink' href='http://localhost/wordpress/?p=149' />
<link rel="alternate" type="application/json+oembed" href="http://localhost/wordpress/wp-json/oembed/1.0/embed?url=http%3A%2F%2Flocalhost%2Fwordpress%2Fchief%2F" />
<link rel="alternate" type="text/xml+oembed" href="http://localhost/wordpress/wp-json/oembed/1.0/embed?url=http%3A%2F%2Flocalhost%2Fwordpress%2Fchief%2F&amp;format=xml" />
	<style>
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


<body class="page-template page-template-elementor_header_footer page page-id-149 full-width-layout elementor-default elementor-template-full-width elementor-page elementor-page-149" data-container="container-large">
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
                                                    <h1 class="site-title"><a href="restaraunt.php" rel="В ресторан"></a></h1>
                                                        <p class="site-description">Уязвимое веб-приложение!</p>
                                                </div>
                </div>
                <div class="col-md-9 text-align-right">
                                    <nav class="menu-main">
                    <div class="menu-home-container"><ul id="primary-menu" class="floted-li clearfix d-i-b"><li id="menu-item-31" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-31"><a href="restaraunt.php">В ресторан</a></li>
</ul></div>                    </nav>
                </div>
            </div>
        </div>
    </header>


		<div class="elementor elementor-149">
			<div class="elementor-inner">
				<div class="elementor-section-wrap">
							<section data-id="73722fb" class="elementor-element elementor-element-73722fb elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="9476811" class="elementor-element elementor-element-9476811 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="5bbd178" class="elementor-element elementor-element-5bbd178 elementor-widget elementor-widget-image" data-element_type="image.default">
				<div class="elementor-widget-container">
					<div class="elementor-image">
										<img width="618" height="360" src="../../../includes/uploads/2018/11/gabriel.jpg" class="attachment-large size-large" alt="" srcset="http://localhost/wordpress/wp-content/uploads/2018/11/gabriel.jpg 618w, http://localhost/wordpress/wp-content/uploads/2018/11/gabriel-300x175.jpg 300w" sizes="(max-width: 618px) 100vw, 618px" />											</div>
				</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id="d5221e1" class="elementor-element elementor-element-d5221e1 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="b243676" class="elementor-element elementor-element-b243676 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="e817cfd" class="elementor-element elementor-element-e817cfd elementor-widget elementor-widget-spacer" data-element_type="spacer.default">
				<div class="elementor-widget-container">
					<div class="elementor-spacer">
			<div class="elementor-spacer-inner"></div>
		</div>
				</div>
				</div>
				<div data-id="a7b5315" class="elementor-element elementor-element-a7b5315 elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Добрый день!<br>Меня зовут Василий Антонович, и я рад приветствовать вас!</h2>

                  <!--  <?php  echo($Checkflags[3]) ; ?> -->

                    </div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id="5267be8" class="elementor-element elementor-element-5267be8 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="b868be2" class="elementor-element elementor-element-b868be2 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="21797ea" class="elementor-element elementor-element-21797ea elementor-widget elementor-widget-spacer" data-element_type="spacer.default">
				<div class="elementor-widget-container">
					<div class="elementor-spacer">
			<div class="elementor-spacer-inner"></div>
		</div>
				</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<section data-id="6eeaf94" class="elementor-element elementor-element-6eeaf94 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="1a7c51d" class="elementor-element elementor-element-1a7c51d elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">



					<div class="elementor-widget-wrap">
				<div data-id="ec2ab49" class="elementor-element elementor-element-413b705 elementor-button-align-center animated zoomIn elementor-invisible elementor-widget elementor-widget-form" data-settings="{&quot;_animation&quot;:&quot;zoomIn&quot;}" data-element_type="login.default">
				<div class="elementor-widget-container">
					<form class="elementor-form" method="post" id="msg" name="msg" action="chief.php">


			<div class="elementor-form-fields-wrapper elementor-labels-above">
								<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-name elementor-col-100">
					<input size="1" type="text" name="form_fields[name]" id="form-field-name" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="Имя">				</div>
								<div class="elementor-field-type-textarea elementor-field-group elementor-column elementor-field-group-message elementor-col-100">
					<textarea class="elementor-field-textual elementor-field  elementor-size-sm" name="MsgToChief" id="form-field-message" rows="4" placeholder="Ваше сообщение для меня"></textarea>				</div>
								<div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-100">
					<button type="submit" class="elementor-button elementor-size-md" name="ToChief">
						<span >
																						<span class="elementor-button-text">Send</span>
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
						</div>
			</div>
		</div>

   </div>

    <!--Footer component-->
    <section id="footer" class="jr-site-footer"><!--Now active fixed footer-->
       <!--  <div class="container-large">



        </div>
 -->
        <div class="copyright-bottom">
        Copyright Pavlukhin Dmitry. All rights reserved.
        <span> | </span>
        Powered by <a target="_blank" rel="designer" href="mailto:pavluhin_dima@mail.ru">Pavlukhin Dmitry</a>
        </div>
    </section>
    <!--Ends-->

<script type='text/javascript' src='../../../includes/themes/elemento/assets/js/bootstrap.min4a7d.js?ver=20151215'></script>
<script type='text/javascript' src='../../../includes/themes/elemento/assets/js/flexslider.min4a7d.js?ver=20151215'></script>
<script type='text/javascript' src='../../../includes/themes/elemento/assets/js/skip-link-focus-fix4a7d.js?ver=20151215'></script>
<script type='text/javascript' src='../../../includes/themes/elemento/assets/js/scriptsf269.js?ver=1.0.1'></script>
<script type='text/javascript' src='../../../includes/js/wp-embed.min5010.js?ver=4.9.8'></script>
<script type='text/javascript' src='../../../includes/plugins/elementor-pro/assets/lib/sticky/jquery.sticky.mincc91.js?ver=2.1.8'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var ElementorProFrontendConfig = {"ajaxurl":"http://localhost/wordpress/wp-admin/admin-ajax.php","nonce":"1d35d64c67","shareButtonsNetworks":{"facebook":{"title":"Facebook","has_counter":true},"twitter":{"title":"Twitter"},"google":{"title":"Google+","has_counter":true},"linkedin":{"title":"LinkedIn","has_counter":true},"pinterest":{"title":"Pinterest","has_counter":true},"reddit":{"title":"Reddit","has_counter":true},"vk":{"title":"VK","has_counter":true},"odnoklassniki":{"title":"OK","has_counter":true},"tumblr":{"title":"Tumblr"},"delicious":{"title":"Delicious"},"digg":{"title":"Digg"},"skype":{"title":"Skype"},"stumbleupon":{"title":"StumbleUpon","has_counter":true},"telegram":{"title":"Telegram"},"pocket":{"title":"Pocket","has_counter":true},"xing":{"title":"XING","has_counter":true},"whatsapp":{"title":"WhatsApp"},"email":{"title":"Email"},"print":{"title":"Print"}},"facebook_sdk":{"lang":"en_US","app_id":""}};
/* ]]> */
</script>
<script type='text/javascript' src='../../../includes/plugins/elementor-pro/assets/js/frontend.mincc91.js?ver=2.1.8'></script>
<script type='text/javascript' src='../../../includes/js/jquery/ui/position.mine899.js?ver=1.11.4'></script>
<script type='text/javascript' src='../../../includes/plugins/elementor/assets/lib/dialog/dialog.min268f.js?ver=4.5.0'></script>
<script type='text/javascript' src='../../../includes/plugins/elementor/assets/lib/waypoints/waypoints.min05da.js?ver=4.0.2'></script>
<script type='text/javascript' src='../../../includes/plugins/elementor/assets/lib/swiper/swiper.jquery.mincb20.js?ver=4.4.3'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var elementorFrontendConfig = {"isEditMode":"","is_rtl":"","breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"version":"2.2.6","urls":{"assets":"http://localhost/wordpress/wp-content/plugins/elementor/assets/"},"settings":{"page":[],"general":{"elementor_global_image_lightbox":"yes","elementor_enable_lightbox_in_editor":"yes"}},"post":{"id":149,"title":"Chief","excerpt":""}};
/* ]]> */
</script>
<script type='text/javascript' src='../../../includes/plugins/elementor/assets/js/frontend.mindbc2.js?ver=2.2.6'></script>

</body>


        </html>

<!--'
;


    ?>-->