<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to FoodOrder</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to FoodOrder</h1>

	<div id="body">
		<h3> 1. Login API (Sign In)</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/login"><?=SITE_URL?>/v1/login</a></li>

			<li>
				params: {
					"email":"appybhanderi825@gmail.com",
					"password":"123456",
					"device_token":"1",
					"latitude" : "1",
					"longitude":"1"
				}
			</li>
		<br>
			  
		</ul>
		<br>
		<h3> 2. Registration</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/login"><?=SITE_URL?>/v1/registration</a></li>

			<li>
				params: {
					"name": "Alpa Bhanderi"
					"email":"appybhanderi825@gmail.com",
					"password":"123456",
					"device_token":"1",
					"latitude" : "1",
					"longitude":"1"
				}
			</li>
		<br>
			  
		</ul>

		<br>
		<h3> 3. Social Signin</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/login"><?=SITE_URL?>/v1/social_signin</a></li>

			<li>
				{
					"name":"Alpa123",
					"email":"appybhanderi825@gmail.com",
					"password":"123456",
					"device_token":"1",
					"latitude" : "1",
					"longitude":"1",
					"social_id":"456789",
					"is_social_login":"1",
					"profile_image":"url"
				}
			</li>
			<li>is_social_login: ===>  1=>facebook, 2=>google</li>
		<br>
			  
		</ul>

		<h3> 4. Logout</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/login"><?=SITE_URL?>/v1/logout</a></li>

			<li>
				{
					"user_id":"1",
					"device_token":"1"
				}
			</li>
		<br>
			  
		</ul>
		<h3> 6. Forget Password</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/login"><?=SITE_URL?>/v1/forgot_password</a></li>

			<li>
				{
					"email":"appybhanderi825@gmail.com"
				}
			</li>
		<br>
			  
		</ul>
<!-- 		

		<h3> 2. Category List</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/category"><?=SITE_URL?>/v1/category</a></li>
		<br>
			
		</ul>
		

		<h3> 3. SubmitCategory</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/add-category?user_id=123&cat_id=1,2,3"><?=SITE_URL?>/v1/add-category?user_id=123&cat_id=1,2,3</a></li>
			<li>
				params: {
				    "user_id" : "1",
				    "cat_id": "1,3,4"
				}
			</li>
		<br>
			  
		</ul>



		<h3> 4. Normal Signup</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/signup"><?=SITE_URL?>/v1/signup</a></li>
			<li>
				parmas: {
				    "email" : "alpa@gmail.com",
				    "password": "123",
				    "name": "alpa",
					"device_type" : "123",
					"device_token": "123",
					"gender": "1",
					"age": "123",
					"city": "ahmedabad",
					"profile_image": "url"
				}
			</li>
		<br>
			  
		</ul>

		<h3> 5. Follower / Following</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/follower-following?user_id=1&type=1"><?=SITE_URL?>/v1/follower-following?user_id=1&type=1</a></li>
			<li>
				params: {
				    "user_id" : "1",
				    "type": "1"
				}
			</li>
			<li>type=   1=>following list, 2=>follower list</li>
		<br>
			
		</ul>

		<h3> 6. Add Bookmark</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/add-bookmark?user_id=1&story_id=1&is_bookmark=1"><?=SITE_URL?>/v1/add-bookmark?user_id=1&story_id=1&is_bookmark=1</a></li>
			<li>
				params: {
				    "user_id" : "1",
				    "story_id": "1",
				    "is_bookmark": "1"
				}
			</li>

		<br>
			
		</ul>

		<h3> 7. Edit Profile</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/edit-profile"><?=SITE_URL?>/v1/edit-profile</a></li>
			<li>
				parmas: {
					"user_id": "1",
				    "name": "alpa",
					"gender": "1",
					"age": "123",
					"city": "ahmedabad",
					"profile_image": "url",
					"user_bio": "bio"
				}
			</li>
		<br>
			  
		</ul>

		<h3> 8. Social Signin</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/social-signin"><?=SITE_URL?>/v1/social-signin</a></li>
			<li>
				parmas: {
				    "email" : "alpa@gmail.com",
				    "password": "",
				    "name": "alpa",
					"device_type" : "123",
					"device_token": "123",
					"gender": "1",
					"age": "123",
					"city": "ahmedabad",
					"profile_image": "url",
					"social_id": "34546456456",
					"registration_type": "1"
				}
			</li>
			<li>registration_type: ===>  1=>facebook, 2=>google, 3=>instagram</li>
		<br>
			  
		</ul>
		<h3> 9. Story List</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/story-list"><?=SITE_URL?>/v1/story-list</a></li>
			<li>
				params: {
				    "user_id" : "1",
				    "mode" : "1"
				}
			</li>
			<li>mode: ===>  1=>bookmark, 2=>my story 3=>all followers/followings
</li>
		<br>
			
		</ul>


		<h3> 10. Add Story</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/add-story"><?=SITE_URL?>/v1/add-story</a></li>
			<li>
				parmas: {
				    "user_id" : "1",
				    "story_title": "this is my first story",
				    "category_id": "1",
					"latitude" : "73.8976",
					"longitude": "72.8976",
					"story_details": "test",
					"story_image": "Base 64 string",
					"tagged_users": "2,3,4",
					"location": "Ahmedabad"
					
				}
			</li>
			
		<br>
			
		</ul>


		<h3> 11. Add Image</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/add-image"><?=SITE_URL?>/v1/add-image</a></li>
			<li>
				params: {
				    "story_image" : "base 64 string"
				}
			</li>
			
		<br>
			
		</ul>

		<h3> 12. Add Claps</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/add-claps"><?=SITE_URL?>/v1/add-claps</a></li>
			<li>
				params: {
				    "story_id" : "1",
				    "user_id" : "1"
				}
			</li>
			
		<br>
			
		</ul>

		<h3> 13. Web view url</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/story-detail/5"><?=SITE_URL?>/story-detail/5</a></li>
				
			<br>	
		</ul>

		<h3> 14. Notification List</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/notifications"><?=SITE_URL?>/v1/notifications</a></li>
			<li>
				params: {
				    "user_id" : "1"
				}
			</li>
			
		<br>
			
		</ul>


		<h3> 15. Add Comments</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/add-comment"><?=SITE_URL?>/v1/add-comment</a></li>
			<li>
				params: {
				    "story_id" : "1",
				    "user_id" : "1",
				    "comment" : "Nice blog...."
				}
			</li>
			
		<br>
			
		</ul>

		<h3> 16. Admin Story List</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/admin-story"><?=SITE_URL?>/v1/admin-story</a></li>
			<li>
				params: {
				    "user_id" : "1"
				}
			</li>
			
		<br>
			
		</ul>

		<h3> 17. Follow/Unfollow</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/add-follow"><?=SITE_URL?>/v1/add-follow</a></li>
			<li>
				params: {
				    "user_id" : "1",
				    "follow_id": "1",
				    "is_follow": "1"
				}
			</li>
			<li>is_follow: ===>  1=>follow, 0=>unfollow</li>
		<br>
			
		</ul>


		<h3> 18. Forgot Password</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/forgot-password"><?=SITE_URL?>/v1/forgot-password</a></li>
			<li>
				params: {
				    "email" : "alpa@gmail.com"
				}
			</li>
			
		<br>
			
		</ul>

		<h3> 19. Logout</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/logout"><?=SITE_URL?>/v1/logout</a></li>
			<li>
				params: {
				    "user_id" : "1",
				    "device_token" : "token"
				}
			</li>
			
		<br>
			
		</ul>


		<h3> 20. Admin Comments</h3>
		<ul style="list-d">
			<li><a href="<?=SITE_URL?>/v1/admin-comments"><?=SITE_URL?>/v1/admin-comments</a></li>
			<li>
				params: {
				    "user_id" : "1"
				}
			</li>
			
		<br>
			
		</ul> -->
	</div>
</div>

</body>
</html>