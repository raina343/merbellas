<?
header('Content-type: text/css'); 
?>
@font-face {
	font-family: "BlackChancery";
	src: url("type/BLKCHCRY.eot");
	src: local("."),
	url("type/BLKCHCRY.woff") format("woff"),
	url("type/BLKCHCRY.otf") format("opentype"),
	url("type/BLKCHCRY.svg#BLKCHCRY") format("svg");
}
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 13px;
	color:#000
}


#wrapper {
	margin: 0 auto;
	width: 1000px;
}

#header {
	float: left;
	height: 165px;
	width: 1000px;
}
#innerheader{
	position:relative;
	background: url(images/top.png) no-repeat top center;
	height:165px;
	z-index:5;
}
#content {
	margin-left:8px;
	position:relative;
	float: left;
	top:-60px;
	background: url(images/tiledshells.jpg);
	width: 984px;
	height:649px;
}

#leftpanel{
	float:left;
	width:20px;
	height:20px;
}
#centerpanel{
	padding-left:-20px;
	width:960px;
	height:40px;
}
#rightpanel{
	float:right;
	width:20px;
	height:20px;
}
#d1 {
	width:20px;
	background:url('images/leftouter.png') no-repeat top left;
	height:649px;
	float: left;
}
#d2 {
	height:40px;
	float: center;
	margin-right: 5px;
}

#d3 {
	width:20px;
	background:url('images/rightouter.png') no-repeat top right;
	height:649px;
	float: right;
}
#centercontentpanel{
<?if ($_GET['type']=="ie8"){
	print 'margin:0 0 0 auto;';
}else{
	print 'margin: 0 auto;';
}
?>
	height:500px;
	width:738px;
}
#navbar{
	vertical-align:text-bottom;
	font-family: "BlackChancery", Georgia, serif;
	font-size:20px;
	background:#8dafa9;
	margin:0 auto;
	height:27px;
	width:650px;
	border-style:solid;
	border-width:6px;
	border-color:#70aea0;
	border-radius:50px;
	behavior: url('PIE.php');
}
#innernav{
	padding-left:10px;
	display: table-cell;
	vertical-align: middle;
}
<?
if ($_GET['type']=="ie8"){?>
	#innernav ul#menu-default-menu li{display:inline;}
	#innernav ul#menu-default-menu li a{display:inline-block;height:auto!important}
<?}?>
#innernav li{
	height:24px;
	background:url('images/navseparator.png') no-repeat top left;
	display: inline-block;
	<?if ($_GET['type']=="ie8"){
		print '	padding:0.1em 0.10em 0 0.8em;';
	}else {
		print '	padding:0.2em 0.10em 0 0.8em;';
	}
	?>
/*	padding:0.2em 0.25em 0 0.9em;*/
/*	padding:0.2em 0.15em 0 0.8em;*/
/*	padding:0.2em 0.8em 0 0.15em;*/
	text-decoration: none;
	color:black;
        vertical-align: middle;
}
#innernav li:last-child:after{
	padding:2px 0px 2px 20px;
	height:38px;
	content:close-quote;
	content:no-close-quote;
	background:url('images/navseparator.png') no-repeat top left;
	background-position:0.2em 0px;
}
#innernav a{
	text-decoration:none;
	color:black;
	font-weight:bold;
}
#innernav ul{
	display: inline-block;
	text-decoration: none;
        vertical-align: middle;
}
@-moz-document url-prefix() {
    /* For some reason FF needs to be 3 pixels higher for the text to look centered */
	#innernav{
	        padding-left:10px;
	        display: table-cell;
	        height: 27px;
	        vertical-align: middle;
	}
}

#logo{
	position:relative;
	top:10px;
	margin:0 auto;
	width:366px;
}
#innertop{
        background:url('images/contentframetop.png') no-repeat top center;
	height:20px;
	width:100%;
}
#innerd1 {
        width:14px;
        background:url('images/contentframeleft.png') no-repeat top left;
        height:506px;
        float: left;
}
#innerd2 {
	overflow-y:scroll;
        height:486px;
        float: center;
	background:#eef5f3;
	padding:10px 20px;
	font-size:10px;
}

#innerd3 {
        width:20px;
        background:url('images/contentframeright.png') no-repeat top right;
        height:506px;
        float: right;
}
.sectiontitle{
	padding:10px 0px 5px 0px;
	font-family: "BlackChancery", Georgia, serif;
	font-size:26px;
}
.current_page_item{
	font-weight:bold;
}
.nav-menu99 li{
	color:blue;
}
#hirepanel {
	position:relative;
	float:right;
	top:250px;
	height:273px;
	width:104px;
}
@-moz-document url-prefix() {
	#innerd1 {
		height:507px;
	}
	#innerd3 {
		height:507px;
	}
	#innerd2 {
	height:487px;
	}

}
.entry-content h1 {
        font-family: "BlackChancery", Georgia, serif;
        font-size:26px;
	margin:0px;
}
.entry-title-blog{
	font-size:40px;
}
.entry-header-blog{
	margin-bottom:10px;
}
.entry-header-blog a{
	text-decoration:none;
	color:black;
}
.entry-header-blog a:hover{
	text-decoration:underline;
	color:black;
}
.entry-title-blog a{ 
	font-weight:normal;
	text-decoration:none;
	color:black;
}
.entry-content-blog{
	font-size:12px;
}
.entry-meta-blog{
	padding-top:10px;
	padding-bottom:20px;
}
