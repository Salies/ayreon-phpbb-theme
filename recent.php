<?php

define('IN_PHPBB', true);
// path to your phpbb installation - if the default one isn't working (wich is very uncommon), set your folder of PHP_ROOT_PATH
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'config.' . $phpEx);

if (!mysql_connect($dbhost, $dbuser, $dbpasswd))
    die("<br><b>Uncommon error - Could not connect to db - check your credentials variables</b>");

if (!mysql_select_db($dbname))
    die("<br><b>Uncommon error - Could not connect to db - check your credentials variables</b>");

//the if above was used in development, it's useless for you - just not for debugging, nways
//if(mysql_select_db($dbname))
//	echo 'Connected to DB';

//defining charset for the query
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8 ");
mysql_set_charset('utf8');

$result = mysql_query("
	SELECT 
	phpbb_posts.poster_id as posterid, 
	phpbb_posts.post_time as post_time, 
	phpbb_posts.topic_id as tid, 
	phpbb_posts.forum_id as fid, 
	phpbb_users.user_id,
	phpbb_users.user_avatar as avatars,
	phpbb_topics.topic_title as topic_title, 
	phpbb_posts.post_id as postid, 
	phpbb_users.username as username,
	phpbb_users.user_colour as usercolour
	from phpbb_posts, phpbb_topics, phpbb_users
	where post_id IN (select * from (select max(post_id) as mpt from phpbb_posts group by topic_id order by mpt desc limit 5) alias ) and phpbb_posts.topic_id=phpbb_topics.topic_id and phpbb_posts.forum_id != 0 and phpbb_posts.poster_id=phpbb_users.user_id order by post_time desc
	;
");

if (!$result) {
    die("<br>Could not retrieve query request");
}

$base_url="http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';

$i = 0;

//showing posts
while($row = mysql_fetch_assoc($result)){
	//this verifies if the avatar is remote or not, and change the way links are created
	if (strncmp($row['avatars'], "http", 4) === 0) {
   		$ayw_avatar = $row['avatars'];
	}
	else if (strncmp($row['avatars'], "https", 5) === 0) {
		$ayw_avatar = $row['avatars'];
	}
	else {
		$ayw_avatar =  $base_url .'/download/file.php?avatar='.$row['avatars'];
	}
	
	//creating the div and the link to the posts
	$i = $i+1;
	echo'<div class="side-post"><img src="'.$ayw_avatar.'"/><b><a href="'.$base_url.'viewtopic.php?f='.$row['fid'].'&t='.$row['tid'].'&p='.$row['postid'].'#p'.$row['postid'].'">'.$row['topic_title'].'</a></b><br>by <b><a href=memberlist.php?mode=viewprofile&u='.$row['posterid'].'><span style="color:#'.$row['usercolour'].'">'.$row['username'].'</span></a></b><br>'.$row['post_time'].'</div>';

}
mysql_free_result($result);
?>
