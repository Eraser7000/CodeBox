<html>
	<head>
		<title><?php echo $title ?> - CodeBox</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/qwerty.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/loader.css" />
	     <script language="javascript" type="text/javascript">
	        function printDiv(divID) 
	        {
	            //Get the HTML of div
	            var divElements = document.getElementById(divID).innerHTML;
	            //Get the HTML of whole page
	            var oldPage = document.body.innerHTML;

	            //Reset the page's HTML with div's HTML only
	            document.body.innerHTML = 
	              "<html><head><title></title></head><body>" + 
	              divElements + "</body>";

	            //Print Page
	            window.print();

	            //Restore orignal HTML
	            document.body.innerHTML = oldPage;

	          
	        }
			function checkLoad()
			{
			   	if(document.getElementById("bottom"))
			  	{	
					document.getElementById("preLoaderDiv").style.visibility = "hidden";
				}
			}
			setInterval("checkLoad()",500);
	    </script>
	</head>
	<body>
		<h1 class = "content">Codebox - Welkom <?php $usernamevar = $this->user->getfullnamefromdb($username); echo $usernamevar?>, u bent ingelogd als <?php echo $rolename ?></h1>
		<div id="preLoaderDiv">
			<img id="preloaderAnimation" src="/images/loader.gif" />
		</div>