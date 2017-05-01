# Ayreon
A modern and free phpBB 3.1/3.2 theme.

![showcase](http://imgur.com/HLdDQo0.png)

So, after dealing with lot of phpBB3 related stuff because of the [Nintendo Blast](http://forum.nintendoblast.com.br/) forum, I decided to play with it a little bit more. So, I came up with this.

## Installation
There are a few things that you may be aware of, so **be sure to follow these steps carefully**.

**1.** Download the theme on the Releases section. Extract it anywhere.

**2.** Move the "ayreon" folder inside your phpBB "styles" directory. Move the "recent.php" file to your phpBB root folder.

**3.** Activate the theme by goind on the ACP > Customise > Install Styles > Install Style (on ayreon).
It will be probably automatically activated, but just do so if it doesn't.
Now here's the tricky part:

**4.** From your phpBB root directory, go to the "includes" folder. Once there, open (to edit) the *functions.php* file.
Search for the following line:
```php
'SITE_LOGO_IMG'			=> $user->img('site_logo'),
```
After that, add the following lines:
```php
		//ayreon variables
		'CURRENT_USERNAME'		=> $user->data['username'],
		'AY_POSTS'				=> $user->lang((int) $config['num_posts']),
		'AY_TOPICS'				=> $user->lang((int) $config['num_topics']),
		'AY_USERS'				=> $user->lang((int) $config['num_users']),
		'AY_NEWEST'	=> $user->lang(get_username_string('full', $config['newest_user_id'], $config['newest_username'], $config['newest_user_colour'])),

		//ayreon text variables
		'AY_N_HOME'				=> "Home",
		"AY_N_FAQ"				=> "FAQ",
		"AY_N_MEMBERS"			=> "Members",
		"AY_N_LOG"				=> "Login or Register",
		"AY_N_RECENT"			=> "Recent Posts",
		"AY_N_STATS"			=> "Statistics",
		"AY_N_SHARE"			=> "Share",
		"AY_N_TOPICS"			=> "Topics",
		"AY_N_POSTS"			=> "Posts",
		"AY_N_USERS"			=> "Users",
		"AY_N_NEWEST"			=> "Our Newest Member is",
		'AY_INDEX'				=> generate_board_url(),
		"AY_ABOUT"				=> "About Us",
		"AY_USEFUL"				=> "Useful Links",
		"AY_CREDITS"			=> "Credits",
		"AY_NAMECRED"			=> "Ayreon theme by <a href='https://github.com/Salies'>Salies</a>.",
```

So it should look like this:
![showcase](http://imgur.com/7GJfwxB.png)

And that should do it ;) Be sure to set ayreon as the default theme to see it without needing to change it on the UCP.

Before finishing, **there are a few things you should be aware of!**

**1.** To change your logo, just change the images on the *overral_header.html*. You can find them by looking for *{T_THEME_PATH}/images/logo.png*.

**2.** You might want to make a few adjustments to the Share social links. Be sure to keep the widgets into the divs to keep them centered.

**3.** **THE RECENT POSTS WIDGET SHOW POSTS FROM EVERY FORUM**. So, if you have a moderation area or something similar, be sure to add it as an exception on the query. To do so, find that on the *recent.php* file:
```php
 and phpbb_posts.topic_id=phpbb_topics.topic_id and phpbb_posts.forum_id != 0 and phpbb_posts.poster_id=phpbb_users.user_id order by post_time desc
 ```
 Before any of the ``and``, add ``and phpbb_posts.forum_id != FORUM_ID`` for each forum that you want to exclude from the Recent Posts (e.g. moderation ones). Change FORUM_ID to your...forum id! You can find it by simply looking at it's url: ``viewforum.php?f=2`` - it's what comes after the "f".
 
 If you follow every step, you shouldn't have any problems. But, if you do so, always feel free to report it as an issue.
 
 ## Credits
The name "Ayreon" came from the progressive metal project by the dutch musician Arjen Anthony Lucassen. The default background stands for the cover of his "Into The Eletric Castle" album. So, thanks Arjen for the awesome inspiration!
 
I'd like to also László Kozma for his *recent widget* code, 'cause I used his http request model to come up with my Recent Posts widget.
