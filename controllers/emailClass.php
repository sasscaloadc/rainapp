<?php
class Emailer{
public function sendEmail($hashkey, $id, $user){
    
$headers = "From: SASSCAL Open Access Data Centre <oadc@sasscal.org>\n";
$headers .= "Reply-To: oadc@sasscal.org\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";
//$link = $link;
 $link = 'https://afrihost.sasscal.org/rainapp/confirm.php?token='.@$hashkey.'&id='.@$id;
                    //header
$body = '<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>SASSCAL WELCOME Email</title>
    <style>
 { 
	margin:0;
	padding:0;
}
* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

img { 
	max-width: 100%; 
}
.collapse {
	margin:0;
	padding:0;
}
body {
	-webkit-font-smoothing:antialiased; 
	-webkit-text-size-adjust:none; 
	width: 100%!important; 
	height: 100%;
}

a { color: #2BA6CB;}

.btn {
	text-decoration:none;
	color: #FFF;
	background-color: #666;
	padding:10px 16px;
	font-weight:bold;
	margin-right:10px;
	text-align:center;
	cursor:pointer;
	display: inline-block;
}

p.callout {
	padding:15px;
	background-color:#ECF8FF;
	margin-bottom: 15px;
}
.callout a {
	font-weight:bold;
	color: #fff;
}

table.social {
/* 	padding:15px; */
	background-color: #ebebeb;
	
}
.social .soc-btn {
	padding: 3px 7px;
	font-size:12px;
	margin-bottom:10px;
	text-decoration:none;
	color: #FFF;font-weight:bold;
	display:block;
	text-align:center;
}
a.fb { background-color: #3B5998!important; }
a.tw { background-color: #1daced!important; }
a.gp { background-color: #DB4A39!important; }
a.ms { background-color: #000!important; }

.sidebar .soc-btn { 
	display:block;
	width:100%;
}

table.head-wrap { width: 100%;}

.header.container table td.logo { padding: 15px; }
.header.container table td.label { padding: 15px; padding-left:0px;}

table.body-wrap { width: 100%;}

table.footer-wrap { width: 100%;	clear:both!important;
}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
	font-size:10px;
	font-weight: bold;
	
}

h1,h2,h3,h4,h5,h6 {
font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
}
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

h1 { font-weight:200; font-size: 44px;}
h2 { font-weight:200; font-size: 37px;}
h3 { font-weight:500; font-size: 27px;}
h4 { font-weight:500; font-size: 23px;}
h5 { font-weight:900; font-size: 17px;}
h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

.collapse { margin:0!important;}

p, ul { 
	margin-bottom: 10px; 
	font-weight: normal; 
	font-size:14px; 
	line-height:1.6;
}
p.lead { font-size:17px; }
p.last { margin-bottom:0px;}

ul li {
	margin-left:5px;
	list-style-position: inside;
}

ul.sidebar {
	background:#ebebeb;
	display:block;
	list-style-type: none;
}
ul.sidebar li { display: block; margin:0;}
ul.sidebar li a {
	text-decoration:none;
	color: #666;
	padding:10px 16px;
/* 	font-weight:bold; */
	margin-right:10px;
/* 	text-align:center; */
	cursor:pointer;
	border-bottom: 1px solid #777777;
	border-top: 1px solid #FFFFFF;
	display:block;
	margin:0;
}
ul.sidebar li a.last { border-bottom-width:0px;}
ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}

/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
	display:block!important;
	max-width:600px!important;
	margin:0 auto!important; /* makes it centered */
	clear:both!important;
}

/* This should also be a block element, so that it will fill 100% of the .container */
.content {
	padding:15px;
	max-width:600px;
	margin:0 auto;
	display:block; 
}

/* Lets make sure tables in the content area are 100% wide */
.content table { width: 100%; }


/* Odds and ends */
.column {
	/*width: 300px;
	float:left;*/
}
.column tr td { padding: 15px; }
.column-wrap { 
	padding:0!important; 
	margin:0 auto; 
	max-width:600px!important;
}
.column table { width:100%;}
.social .column {
	width: 280px;
	min-width: 279px;
	float:left;
}

/* Be sure to place a .clear element after each set of columns, just to be safe */
.clear { display: block; clear: both; }

@media only screen and (max-width: 600px) {
	
	a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

	div[class="column"] { width: auto!important; float:none!important;}
	
	table.social div[class="column"] {
		width:auto!important;
	}

}</style>
  </head>
  <body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">';
 
                      //body strats here
$body .= '<table class="head-wrap" bgcolor="#fff">
      <tr>
        <td></td>
        <td class="header container" >
          <div class="content">
            <table bgcolor="#fff">
              <tr>
                <td><img src="https://afrihost.sasscal.org/rainapp/images/sasscal_small.png" /></td>
                <td align="right">
                  <h6 class="collapse">SASSCAL CROWD WEATHER</h6>
                </td>
              </tr>
            </table>
            <hr>
          </div>
        </td>
        <td></td>
      </tr>
    </table>
        <table class="body-wrap">
      <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">
          <div class="column-wrap">
            <div class="column">
              <table>
                <tr>
                  <td>
                    <h4>Hello!</i></h4>
                    <p>Welcome, and thank you for registering! We need to make sure that we have got your email address right, so ...
                    </p>';
        
        $body .= '<p >
                    <center><a href="'.$link.'" target="_blank" class="btn">Please click here to confirm your email address</a></center>
                    </p>
                    <p>You are ready to contribute to a valuable database of recorded rainfall in Southern Africa. We hope that
                      thousands of people across the region will join in to help make this rainfall database a valuable 
                      resource for scientists, government, farmers and the public.
                    </p>
                    <p><i><strong><center>So please invite your friends and neighbours to sign up too.</center></strong></i></p>
                    <p>';
                      
        $body .= 'There are a few considerations that we would like to share with you:<br>
                    <ul style="padding-left: 1em;text-indent: -1em;">
                
                    <li style="text-align:justify;padding-top:6px;">
                    Ideally, rainfall for any particular day should be recorded around 0800hrs the following
                     morning (if at all possible), or as close to that time as you can manage.
                     </li>
                 
                     <li style="text-align:justify;padding-top:5px;">
                  	 Rainfall of "0" millimetres would normally be interpreted as a very faint drizzle that
                     barely wet your rain gauge. If it was a sunny, hot, dry day before, then don\'t record
                    anything. We will fill in the gaps.
                    </li>
					
             			</ul>
                    </p>
                    <p>
                      Thank you very much for your valuable contribution - feel free to contact us any time with your 
                      questions at <a href="mailto:oadc@sasscal.org?Subject=Crowd weather enquiry" target="_top">oadc@sasscal.org</a>
                    </p>
                    <p>
                      <strong>Yours sincerely</strong>
                    </p>
                    <p>
                      The SASSCAL Team
                    </p>
                  </td>
                </tr>
              </table>
            </div>
            <div class="clear"></div>
          </div>
        </td>
        <td></td>
      </tr>
    </table>
     
     </body>
</html>
';           
    $subject = "SASSCAL Crowdweather Welcome email";
    $body = html_entity_decode($body);
  
 $value = mail($user,$subject,$body,$headers);
 echo $value;

}
}
?>