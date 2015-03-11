<?php

session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','register');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

$currentBanas = 0;
if($_SESSION['currentBanas'] != null){
	$currentBanas = $_SESSION['currentBanas'];
}
_connect();   //连接MYSQL数据库

$result = mysql_query("SELECT chapter.title title, chapter.content content, book.name, book.description description, category.name categoryName 
FROM chapter,book,category where book.categoryId = category.id and chapter.bookId = " .$_GET["bId"]." and chapter.id = ".$_GET["cp"]." and chapter.bookId = book.id ");

$row = mysql_fetch_array($result);

$cur_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

?>
<!doctype html>
<html xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta property="og:image" content="http://www.newbbay.com/sources/images/social-img.png" /> 
<meta property="og:site_name" content="NewBbay.com" /> 
<meta property="og:title" content="<?php echo $row['title']." - ". $row['name']." - NewBbay"?>" /> 
<meta property="og:url" content="<?php echo $cur_url; ?>" /> 
<meta property="og:description" content="<?php echo str_replace("\""," ",$row['description']); ?>" /> 
<meta property="og:type" content="og.likes" /> 

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> <?php echo $row['title']." - ". $row['name']." - NewBbay"?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="keywords" content="<?php echo $row['title']." - ".$row['name']." - ".$row['categoryName']." - NewBbay"; ?>" />
	<meta name="description" content="<?php echo str_replace("\""," ",$row['description']); ?>" />

    <link rel="stylesheet" type="text/css" href="../../sources/style/style.css">

	<script src="../../sources/js/jquery-1.9.1.js"></script>
    <script src="../../sources/js/jquery-ui.js"></script>
    <script src="../../sources/js/main.js"></script>
	<script src="../../sources/js/common.js"></script>

</head>
	 <script>

		$(document).keydown(function(e){   
			switch(e.which){     
				// user presses the "a"     
				case 27:    
					var tags = $(".chapter-list");
					var url = $(tags[0]).attr("href");
					window.location.href=url;
					break;   
				case 39:
					var tags = $(".next-chapter");
					if(tags.length > 0){
						if($(tags[0]).hasClass("needsBuy")){
							unlockChapter(tags[0]);
							
						}else{
							var url = $(tags[0]).attr("href");
							window.location.href=url;
						}
					}
					break;
				case 37:
					var tags = $(".previous-chapter");
					if(tags.length > 0){
						if($(tags[0]).hasClass("needsBuy")){
							unlockChapter(tags[0]);
						
						}else{
							var url = $(tags[0]).attr("href");
							window.location.href=url;
						}
					}
					break;
			}     
			return true;
		});  

		$(function(){
			//if(getCookie(<?php echo $_GET["bId"]."-".$_SESSION["userid"]; ?>) != 1){
				$.ajax({
					type: "get",
					url: "../../sum_visit.php?bid="+<?php echo $_GET["bId"]; ?>,
					success: function(data, textStatus){
						//setCookie(24, <?php echo $_GET["bId"]."-".$_SESSION["userid"]; ?> , "1");
					}
				});
			//}

			//Init Font
			$("#content_details p").css("font-size","16px");
			$("#content_details p").css("font-weight","normal");
			$("#content_details p").css("line-height","25px");
			$("#content_details p").css("text-indent","45px");

			$("#normal-font").click(function(){
				$("#content_details p").css("font-size","16px");
				$("#content_details p").css("font-weight","normal");
				$("#content_details p").css("line-height","25px");
				$("#content_details p").css("text-indent","45px");
				return false;
			});

			$("#bigger-font").click(function(){
				$("#content_details p").css("font-size","21px");
				$("#content_details p").css("font-weight","normal");
				$("#content_details p").css("line-height","32px");
				$("#content_details p").css("text-indent","45px");
				return false;
			});
			
			$("#biggest-font").click(function(){
				$("#content_details p").css("font-size","25px");
				$("#content_details p").css("font-weight","normal");
				$("#content_details p").css("line-height","38px");
				$("#content_details p").css("text-indent","45px");
				return false;
			});

		});
		//chapter_details
	</script>
	<style>

		.content_details{font-weight:normal;}
		.content_details p{float:left; width:825px; font-size:16px; 
			display:block; text-align:left; font-weight:normal; }
		#page_resize{float:right; margin-top:30px; }
		#page_resize ul{float:left; }
		#page_resize ul li{float:left; margin-right:10px; }
		#page_resize ul li a{float:left; padding:5px 10px; background:#ccc; color:#000; font-weight:bold; }

		/*#content_details p {font-size:21px; font-weight:bold; line-height:28px;}
		*/
	</style>
<body style="background:#fff; background:#e5f3cb;">
<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1409011699370119&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="social_buttons" style="position:fixed; top:180px; left:0px; width:95px; height:240px; background:#fff; border:#ccc 1px solid; ">
	<div class="fb-like"  data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"
								 style="float:left; margin-top:10px; margin-left:20px;"></div>

<div style="float:left; margin-left: 15px; margin-top: 15px;">
	<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" target="_blank" 
									data-text="<?php echo str_replace("\""," ",$row['description']); ?>" data-count="vertical"
								   style="">Tweet</a>
</div>
	
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

	<div style="float:left; margin-top:15px; margin-left:10px;">
		<script src="//platform.linkedin.com/in.js" type="text/javascript">
			lang: en_US
		</script>
		<script type="IN/Share"  data-counter="top"></script>
	</div>

</div>

<div id="userStatus" style="display:none;"><?php 
	if($_SESSION['userStatus'] == "1"){
		echo "1";
	}else{
		echo "0";
	}
?></div>
	<div id="container" style="background:#fff; background:#efefef;" onMouseMove="event.returnValue=false;" >
        <div class="header">
            <div class="sign">
				<?php
					if($_SESSION['userid'] != null && $_SESSION['userid'] != ""){
				?>
					<a class="sign_up" href="#" onClick="logOut();">LogOut</a>
					
					<a href="<?php 
								if($_SESSION['userStatus'] == "1"){
									echo "../../authors/author.php";
								}else if($_SESSION['userStatus'] == "0"){ 
									echo "../../member/member.php";
								}else { 
									echo "../../administrator-login/admin.php";}?>" class="sign_in" style="border:none; text-decoration:underline;">
						Member Center
					</a>
					<span class="sign_up">
						Banas: <?php echo $currentBanas;?>&nbsp;&nbsp;&nbsp;&nbsp;
						Account: <?php if($_SESSION['username'] != null){ 
							echo $_SESSION['username']; 
						} else {
							echo "Anon";
						}?>
						
					</span>
				<?php 
					}else{
				?>
					<a class="sign_in" href="/sign_in.html">Sign In</a>
					<a class="sign_up" href="/sign_up.html">Sign Up</a>
				<?php
					}
				?>

			</div>
			
			<div class="logo_box">
				<a class="logo" href="http://www.newbbay.com/" style="text-align:center;">
					<img src="../../sources/images/logo.png" alt="Newbbay"/>
				</a>
				<h1>World's Creative Writing Incubator </h1>
			</div>
        </div>
		
        <div class="nav">
            <ul>
                <li><a href="../../index.html">Home</a></li>
				<?php
					$result = mysql_query("SELECT id,name FROM category where status = 1");

					while($row = mysql_fetch_array($result)){
					  echo '<li><a href="../../'.$row["name"].'/index.html">'.$row["name"].'</a></li>';
					}
					_close();
					
				?>
            </ul>
        </div>
	<div class="content_box" id="content_box">
<?php 
//require dirname(__FILE__).'/header_member.php';
if($_SESSION['linksURL'] != null && $_SESSION['linksURL'] != ""){
	$_SESSION['links'] = "";
	$_SESSION['linksURL'] = "";
	$_SESSION['bid'] = "";
	$_SESSION['chapterId'] = "";
}
?>
		<div id="page_resize">
			<ul>
				<li><a href="#" id="normal-font">Normal</a></li>
				<li><a href="#" id="bigger-font">Bigger</a></li>
				<li><a href="#" id="biggest-font">Biggest</a></li>
			</ul>	 
		</div>
        <div class="books_list" style="border:none; margin-top:0px; padding-top:0px; ">
			<?php
				$bookId = $_GET["bId"];

				_connect();   //连接MYSQL数据库

				$result = mysql_query("select book.name, author.nickname from book, author where book.authorId = author.id and book.id = ".$bookId);
				$row = mysql_fetch_array($result);

				_close();
			?>
			<div>
				<span style="float:left;width:100%; margin-top:20px; text-align:center; font-size:28px; "><?php echo $row['name']; ?></span>
				<span style="float:left; width:100%; text-align:center; font-size:16px; "><?php echo $row["nickname"];?></span>
			</div>

            <div class="reading">

                <div class="operate">
			<?php
				$bookId = $_GET["bId"];
				$chapterId = $_GET["cp"];

				_connect();   //连接MYSQL数据库

				$result = mysql_query("select id maxId,banas  from chapter where id = ( SELECT max(id) as maxId FROM chapter where bookId = ".$bookId." and id < " .$chapterId .")");
				$row = mysql_fetch_array($result);

				$result2 = mysql_query("select id minId, banas  from chapter where id = (SELECT min(id) as minId FROM chapter where bookId = ".$bookId." and id > " .$chapterId.")" );
				$row2 = mysql_fetch_array($result2);

				_close();
				
			?>
			<div style="width:800px; float:left; margin-left:-140px; color: blue; font-style:italic; margin-bottom:10px; ">
				Press "&#8592;" to go to the previous chapter，Press "Esc" to go back to the chapter list，Press "&#8594;" to go to the next chapter
			</div>
					<?php if($row['maxId'] != null && $row['maxId'] != ""){
						if($row['banas'] > 0){
							if($_SESSION['userid'] != null){
								_connect();   //连接MYSQL数据库
								$resultTemp = mysql_query("select count(*) as myNumber from chapter_member where chapterId = ".$row['maxId']." and authorId = ".$_SESSION['userid']);
								$rowTemp = mysql_fetch_array($resultTemp);
								if($rowTemp['myNumber']!=null && $rowTemp['myNumber']>0){
						?>
								<a class="previous-chapter" href="<?php echo $bookId ?>-<?php echo $row['maxId']?>.html">Previous Chapter</a>
						<?php
								}else{
						?>
									<a href="<?php echo $bookId ?>-<?php echo $row['maxId']?>.html" class="needsBuy previous-chapter" 
								value="<?php echo ($row['maxId'].'-'.$bookId.'-'.$row['banas'].'-'.$_GET['bname'])?>" title="Locked, need <?php echo $row['banas'] ?> banas, click to buy" onClick="return unlockChapter(this)">Previous Chapter</a>
						<?php
								}
							}else{
						?>
								<a href="<?php echo $bookId ?>-<?php echo $row['maxId']?>.html" class="needsBuy previous-chapter" 
								value="<?php echo ($row['maxId'].'-'.$bookId.'-'.$row['banas'].'-'.$_GET['bname'])?>" title="Locked, need <?php echo $row['banas'] ?> banas, click to buy" onClick="return unlockChapter(this)">Previous Chapter</a>
						<?php
							}
							
						}else{
					?>
						<a class="previous-chapter" href="<?php echo $bookId ?>-<?php echo $row['maxId']?>.html">Previous Chapter</a>
					<?php
						}
					?>
                    
					<?php } ?>
                    <a class="chapter-list" href="chapters-<?php echo $bookId ?>.html">Return Chapter List</a>
					<?php if($row2['minId'] != null && $row2['minId'] != ""){
						if($row2['banas'] > 0){
							if($_SESSION['userid'] != null){
								_connect();   //连接MYSQL数据库
								$resultTemp2 = mysql_query("select count(*) as myNumber from chapter_member where chapterId = ".$row2['minId']." and authorId = ".$_SESSION['userid']);
								$rowTemp2 = mysql_fetch_array($resultTemp2);
								if($rowTemp2['myNumber'] != null && $rowTemp2['myNumber']>0){
						?>
									<a class="next-chapter" href="<?php echo $bookId ?>-<?php echo $row2['minId']?>.html">Next Chapter</a>
						<?php
								}else{
						?>
									<a href="<?php echo $bookId ?>-<?php echo $row2['minId']?>.html" class="needsBuy next-chapter" 
								value="<?php echo ($row2['minId'].'-'.$bookId.'-'.$row2['banas'].'-'.$_GET['bname'])?>" title="Locked, need <?php echo $row2['banas'] ?> banas, click to buy" onClick="return unlockChapter(this)">Next Chapter</a>
						<?php
								}
							}else{
						?>
								<a href="<?php echo $bookId ?>-<?php echo $row2['minId']?>.html" class="needsBuy next-chapter" 
								value="<?php echo ($row2['minId'].'-'.$bookId.'-'.$row2['banas'].'-'.$_GET['bname'])?>" title="Locked, need <?php echo $row2['banas'] ?> banas, click to buy" onClick="return unlockChapter(this)">Next Chapter</a>
						<?php
							}
							
						}else{
					?>
						<a class="next-chapter" href="<?php echo $bookId ?>-<?php echo $row2['minId']?>.html">Next Chapter</a>
					<?php
						}
					?>
						 
					<?php
					}?>
                   
                </div>
                <!--<div class="content_details" style="background:#e5f3cb; width:915px;" onmousemove="event.returnValue=false;">
				-->
				<script>
					$(function(){
						var obj = $("#content_details").html();
						var newobj = obj.replace(/&nbsp;/gm,' ');
						$("#content_details").html(newobj);
					});
				</script>
				<div id="content_details" class="content_details" style="background:#fff; width:915px; height:500px; overflow-y:auto; border:#ccc 1px solid;" onMouseMove="event.returnValue=false;" >
					<?php
						
						_connect();   //连接MYSQL数据库

						$result = mysql_query("SELECT * FROM chapter where bookId = " .$bookId." and id = ".$chapterId);
				
						$row = mysql_fetch_array($result);
						_close();
					?>
					<br/>
                    <h2><?php echo $row['title'] ?></h2>
				
                    <p id="chapter_details">
                        <?php echo $row['content'] ?>
                    </p>
                </div>
				
				    <div class="operate" style="margin-top:20px;">
			<?php
				$bookId = $_GET["bId"];
				$chapterId = $_GET["cp"];

				_connect();   //连接MYSQL数据库

				$result = mysql_query("select id maxId,banas  from chapter where id = ( SELECT max(id) as maxId FROM chapter where bookId = ".$bookId." and id < " .$chapterId .")");
				$row = mysql_fetch_array($result);

				$result2 = mysql_query("select id minId, banas  from chapter where id = (SELECT min(id) as minId FROM chapter where bookId = ".$bookId." and id > " .$chapterId.")" );
				$row2 = mysql_fetch_array($result2);

				_close();
			?>
					<?php if($row['maxId'] != null && $row['maxId'] != ""){
						if($row['banas'] > 0){
							if($_SESSION['userid'] != null){
								_connect();   //连接MYSQL数据库
								$resultTemp = mysql_query("select count(*) as myNumber from chapter_member where chapterId = ".$row['maxId']." and authorId = ".$_SESSION['userid']);
								$rowTemp = mysql_fetch_array($resultTemp);
								if($rowTemp['myNumber']!=null && $rowTemp['myNumber']>0){
						?>
								<a class="previous-chapter" href="<?php echo $bookId ?>-<?php echo $row['maxId']?>.html">Previous Chapter</a>
						<?php
								}else{
						?>
									<a href="<?php echo $bookId ?>-<?php echo $row['maxId']?>.html" class="needsBuy previous-chapter" 
								value="<?php echo ($row['maxId'].'-'.$bookId.'-'.$row['banas'].'-'.$_GET['bname'])?>" title="Locked, need <?php echo $row['banas'] ?> banas, click to buy" onClick="return unlockChapter(this)">Previous Chapter</a>
						<?php
								}
							}else{
						?>
								<a href="<?php echo $bookId ?>-<?php echo $row['maxId']?>.html" class="needsBuy previous-chapter" 
								value="<?php echo ($row['maxId'].'-'.$bookId.'-'.$row['banas'].'-'.$_GET['bname'])?>" title="Locked, need <?php echo $row['banas'] ?> banas, click to buy" onClick="return unlockChapter(this)">Previous Chapter</a>
						<?php
							}
							
						}else{
					?>
						<a class="previous-chapter" href="<?php echo $bookId ?>-<?php echo $row['maxId']?>.html">Previous Chapter</a>
					<?php
						}
					?>
                    
					<?php } ?>
                    <a class="chapter-list" href="chapters-<?php echo $bookId ?>.html">Return Chapter List</a>
					<?php if($row2['minId'] != null && $row2['minId'] != ""){
						if($row2['banas'] > 0){
							if($_SESSION['userid'] != null){
								_connect();   //连接MYSQL数据库
								$resultTemp2 = mysql_query("select count(*) as myNumber from chapter_member where chapterId = ".$row2['minId']." and authorId = ".$_SESSION['userid']);
								$rowTemp2 = mysql_fetch_array($resultTemp2);
								if($rowTemp2['myNumber'] != null && $rowTemp2['myNumber']>0){
						?>
									<a class="next-chapter" href="<?php echo $bookId ?>-<?php echo $row2['minId']?>.html">Next Chapter</a>
						<?php
								}else{
						?>
									<a href="<?php echo $bookId ?>-<?php echo $row2['minId']?>.html" class="needsBuy next-chapter" 
								value="<?php echo ($row2['minId'].'-'.$bookId.'-'.$row2['banas'].'-'.$_GET['bname'])?>" title="Locked, need <?php echo $row2['banas'] ?> banas, click to buy" onClick="return unlockChapter(this)">Next Chapter</a>
						<?php
								}
							}else{
						?>
								<a href="<?php echo $bookId ?>-<?php echo $row2['minId']?>.html" class="needsBuy next-chapter" 
								value="<?php echo ($row2['minId'].'-'.$bookId.'-'.$row2['banas'].'-'.$_GET['bname'])?>" title="Locked, need <?php echo $row2['banas'] ?> banas, click to buy" onClick="return unlockChapter(this)">Next Chapter</a>
						<?php
							}
							
						}else{
					?>
						<a class="next-chapter" href="<?php echo $bookId ?>-<?php echo $row2['minId']?>.html">Next Chapter</a>
					<?php
						}
					?>
						 
					<?php
					}?>
                   <div style="width:800px; float:left; margin-left:-140px; color: blue; font-style:italic; margin-top:10px; ">
						Press "&#8592;" to go to the previous chapter，Press "Esc" to go back to the chapter list，Press "&#8594;" to go to the next chapter
					</div>
                </div>
				
				<div id="review-box" class="review_box" style="float:left; width:100%; ">
					<?php 
						//if($_SESSION['username']=="Rocketboy"){
					?>
					<div class="title" style="float:left; width:95%; padding-left:5%; margin-top:30px; color:blue; font-weight:bold; font-size:18px; ">
						Comments
					</div>

					<div class="review_list" style="float:left; width:95%; padding-left:5%;">
					
					<?php 
						_connect();   //连接MYSQL数据库

						$result = mysql_query("SELECT * FROM comments where bookId = ".$_GET["bId"]." and chapterId = ".$_GET["cp"]);
						while($row = mysql_fetch_array($result)){
					?>
							<div class="review" style="float:left; width:100%; margin-top:10px; border-bottom:#ccc 1px dotted; ">
								<div style="float:left; width:100%; ">
									<span style="float:left; font-weight:bold; font-size:13px; "><?php echo $row['username']; ?></span>
									<span style="float:left; margin-left:15px; font-size:12px; font-style:italic; "><?php echo $row['createDate']; ?></span>
									
								</div>
								<div style="float:left; width:100%; margin-top:5px; line-height:21px; text-indent:25px; ">
									<?php echo $row['content']; ?>
								</div>
							</div>
					<?php
						}
						_close();
					?>
					</div>

					<div class="review_form_box" style="float:left; width:100%; margin-top:35px; ">
						<div class="form_item" style="float:left; width:80%; margin-left:50px; font-weight:bold; color:#111; margin-bottom:5px; ">
							Create New Review:
						</div>
						<form action="/do_comments.php?bId=<?php echo $_GET["bId"]; ?>&cp=<?php echo $_GET["cp"]; ?>" method="POST" >
							<?php if($_SESSION['userid']!=null){ ?>
								<div class="form_item" style="float:left; width:100%;">
									<input type="hidden" name="redirect_url" value="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
									<input type="hidden" name="review_form" value="active" />
									
									<textarea class="review_text" name="review_text"
										style="float:left; width:800px; height:150px; margin-left:50px; padding:15px;"></textarea>
								</div>
								<div class="form_item" style="float:left; width:100%;">
									<input type="submit" value="Submit" class="review_text" style="float:left; padding:5px 10px; color:#fff; background:blue; border:none; margin-left:50px; margin-top:10px; " />
								</div>
							<?php }else{
							?>
									<div class="form_item" style="float:left; width:100%;">
										<div style="float:left; width:800px; margin-left:50px; padding:15px;">Please sign in first !</div>
									</div>
							<?php
							} ?>
						</form>
					</div>
					<?php
						//}
					?>

				</div>



            </div>

        </div>
		<!-- Add Device Process Box Start -->
		<style>
			.popup-box{position: fixed; width: 100%; height: 100%; display: none;}
			.popup-box .bg_layer{ position: fixed; top:0px; left:0px; width: 100%; height: 100%;
				background: #000;
				filter:alpha(opacity = 60);
				-moz-opacity: 0.6;
				opacity: 0.6;
				z-index: 999999;
			}
			.popup-box .fg_box{ position: absolute; top:0px; left:15%; width: 455px; height: 200px; padding:0px 0px 30px 0px;
				background: #fff; z-index: 999999; top: 150px; }
			.popup-box .fg_box p.title{float: left; width: 455px; height: 31px; background: #009ea1;
				font-family: "opensans-semibold"; color: #fff; line-height: 31px; text-align: center; font-weight:bold;}
			.popup-box .fg_box p.title a.close{float: right; margin-right: 17px; cursor: pointer;}
			.popup-box .fg_box p.content{float: left; width: 100%; font-family: "opensans-semibold"; font-size: 14px; text-align: center;}

			.popup-box .fg_box ul{float:left; width:90%; padding-left:5%; padding-right:5%; height:auto; }
			.popup-box .fg_box ul li{ float:left; width:100%; height:25px; line-height:25px; }

			.fg_box{height: auto;}
			.fg_box input.sub{float: left; width: 65px; height: 25px; line-height: 25px;
				font-family: "opensans-semibold"; font-size: 14px; color: #fff; background: #303030; border: none; margin-left: 140px; margin-top: 20px;}
		</style>
		<div id="buy-banas-box"  class="popup-box" style="display:none;">
			<div class="bg_layer"></div>
			<div class="fg_box">
				<p class="title"><span id="buy-banas-title">Buy Chapter</span>
					<a class="close" href="#" id="buy-banas-close"><img src="../../sources/images/close.gif"></a>
				</p>
				<p class="content"  style="margin-top:20px;">
					<ul>
						<li>Book Name: <span id="book-name"></span></li>
						<li>Chapter Name: <span id="chapter-name"></span></li>
						<li><span id="needs-banas"></span> Banas to unlock chapter</li>
					</ul>
					<span style="float:left; display:block; width:100%; margin-left:20px; margin-top:20px;">Proceed to permanently unlock this chapter?</span>
					<form class="confirm_box">
						<input class="sub" id="buy-banas-yes" style="margin-left:150px;" type="button" value="Confirm"/>
						<input class="sub" id="buy-banas-no" style="margin-left:20px;" type="button" value="Cancel"/>
					</form>
				</p>
			</div>
		</div>

		<div id="get-more-banas-box"  class="popup-box" style="display:none; height:100px;">
			<div class="bg_layer"></div>
			<div class="fg_box">
				<p class="title"><span id="buy-banas-title">Buy Chapter</span>
					<a class="close" href="#" id="get-banas-close"><img src="../../sources/images/close.gif"></a>
				</p>
				<p class="content"  style="margin-top:20px;">
					<span style="float:left; display:block; width:100%; margin-left:20px; margin-top:20px;">You do not have sufficient Banas!</span>
					<form class="confirm_box">
						<input class="sub" id="get-more-banas-yes" style="margin-left:150px; width:100px;" type="button" value="Get More!"/>
						<input class="sub" id="get-more-banas-no" style="margin-left:20px;" type="button" value="Cancel"/>
					</form>
				</p>
			</div>
		</div>
		<!-- Add Device Process Box End -->
	</div>
	<!-- Content box End -->
        <?php 
			require './footer.php';
		?>
    </div>
<script>
function unlockChapter(curTag){

		var url = $(curTag).attr("href");
		var ids = $(curTag).attr('value').split("-");
		 var chapterId = ids[0];
		 var bid = ids[1];

		var bookName = ids[3];
		var objName = bookName.replace(/&nbsp;/gm,' ');
		$("#book-name").html(objName);
		$("#chapter-name").html($(curTag).html());
		$("#needs-banas").html(ids[2]);
		$("#buy-banas-box").css("display", "block");

		$("#buy-banas-close").click(function(){
			$("#buy-banas-box").css("display", "none");
			return false;
		});
		$("#get-banas-close").click(function(){
			$("#get-more-banas-box").css("display", "none");
			return false;
		});

		$("#buy-banas-no").click(function(){
			$(".popup-box").css("display", "none");
			return false;
		});
		$("#get-more-banas-no").click(function(){
			$(".popup-box").css("display", "none");
			return false;
		});

		$("#buy-banas-yes").click(function(){
			$.ajax({
				type: "get",
				url: "../../buy_chapter.php?chapterId=" + chapterId + "&bid=" + bid + "&url=" + url,
				success: function(data, textStatus){
					if(data == -1){
						$("#buy-banas-box").css("display", "none");
						$("#get-more-banas-box").css("display","block");
					}else if(data == 0){
						window.location.href="../../sign_in.html";
					}else if(data == 1){
						window.location.href = url; 
					}
				}
			});
			return false;
		});

		$("#get-more-banas-yes").click(function(){
			var userStatus = $("#userStatus").html();

			if(userStatus == "1"){
				window.location.href="../../authors/banas_manage.php";
			}else{
				window.location.href="../../member/banas_manage.php";
			}			
		});
		return false;

}
$(function(){
	
});
</script>

<style>
			a.bg_recommend{float:left; width:100%; font-size:18px; line-height:23px; font-weight:bold; 
				background: url(../../sources/images/bg_recommend.gif) repeat-x left top; height:25px;color:#000; }
		</style>
		<div style="position:fixed; width:350px; height:auto; bottom:-360px; right:0px; z-index:9999; background:#fff; disply:none;">
			<a class="bg_recommend" href="#" onClick="showContact();">&nbsp;&nbsp;&nbsp;&nbsp;Contact Us</a>
			<iframe id="contact_popup" src="contact_us.php" frameborder=no width="350px" scrolling="no" height="360px"></iframe> 
		</div>

</body>
</html>
