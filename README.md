## Facebook Albums Downloader and Backup albums to drive
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kishanjasani/SociaManager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kishanjasani/SociaManager/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/kishanjasani/SociaManager/badges/build.png?b=master)](https://scrutinizer-ci.com/g/kishanjasani/SociaManager/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/kishanjasani/SociaManager/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

Live Application Demo - https://fbrtchallenge.tk

This is a core php Application with expressive, elegant syntax which  allows a user to do following activities:

## Login with facebook
- User Login using Facebook credentials and Ask user to give permission to access the email,name and photos.
Application fetches all Albums which is added by user or in which user is tagged.

## Album Slideshow
- Albums are displayed with the thumbnail and album-name. When user click on album photo, all photos of that album are displayed in fullscreen slideshow.

## Download Album
- Download button are displayed for each album. When user click on that download icon, jQuery(Ajax) processes the php script to fetch photos of that album than zip is and display the "DownloadZipFolder" button to user for download.
- A checkbox is displayed in each album in case the user wants to download checked albums. A "Download Selected" button is displayed on the navigation bar as user checked checkbox for download.
 Here ,more than one album will be mounted in a single Zip file on the server. when user click on the button, It will work in similar way as above when user download single album. But here Here ,more than one album will be mounted in a single Zip file on the server.
- A "Download All Albums" button is displayed at top. When user clicks on "Download All Albums" button, jquery(Ajax) processes PHP script to collect photos for all albums, Zip them and prompts "Download Zip Folder" Link to user for download.

- During the time of Zip and download process is going on, the user will be shown a nice pre-loader for albums while the user awaits the file.

## Backup albums to Google Drive

- NOTE : At first time if user is not login to google account then it sends to login page and asks to grant access from user.(Permission for access the google drive files)

- When the albums are uploaded to Google Drive it will be stored in a parent folder named as "Facebook_UserId_Albums" and there will be child folders of the albums that are uploaded inside this parent folder.

- There is a "Move to drive" button besides the "download icon" icon which will enable the user to upload a single album to their google drive under the parent folder mentioned above with a child folder of the album name itself. This is also processes via an AJAX jQuery request.

- Also There is a "Move Selected" button displayed in the navigation bar, which will upload the selected albums on to the Google Drive under the same parent folder mentioned above alongwith each child folder for the respective albums that were selected for upload.
- There is a "Move all" button displayed in the navigation bar, which will upload all the albums under the same parent folder mentioned above alongwith each child folder for all the albums.
- During the time of moving to drive process is going on, the user will be shown a nice pre-loader for albums while the user awaits the file.

## Additional :-
    > You also can export the the album data in json format by clicking on export data button on the album. so you can use that data in your other website as well by importing this json file.

    > After downloading the album the user gets an email "Your album are downloaded successfully".. and also in mail you get a button of "Download albums". On clicking of that you can download albums.

    > Albums will stay 30 days on server. After 30 day album will destroy from the server.

**About Background Job** : 

> - On Move to drive Button click, Server will initiate background job to move facebook album into your google drive.
> - Once background job is initiated, you can turn off your machine or internet connection. Gearman server will do it for you.
> - You can run 3 background process simuntaneously to move your album to google drive. And other will in queue. When current running process is done then other process will start executing in background one by one.
> - Here we have used a **Gearman Server For Background Job** processing. If you want to implement our project on your server than You have to setup gearman server and **supervisor** up and running.


Library Used:
==========================================================
**Facebook PHP SDK :-**   
The Facebook SDK for PHP provides developers with a modern, native library for accessing the Graph API and
taking advantage of Facebook Login. Usually this means you're developing with PHP for a Facebook Canvas app,
building your own website, or adding server-side functionality to an app.
<a href="https://developers.facebook.com/docs/reference/php/">More Information About Facebook SDK</a>

**Google Drive PHP Library :-**  
Used for uploading albums on https://drive.google.com and <a href="https://developers.google.com/drive/api/v3/quickstart/php">More Information About Google Drive Api</a>

**Materialize Css :-**   
A modern responsive front-end framework based on Material Design.
Materialize is the most popular HTML, CSS, and JS framework for developing responsive. <a href="https://materializecss.com/">For more information</a>

**Slider Design Used :** <a href="https://www.w3schools.com/howto/howto_js_slideshow.asp">W3Schools's
example</a>

**Email Sending** : <a href="https://github.com/PHPMailer/PHPMailer">PHP Mailer</a>  

Platform : PHP

Scripting Languages:
Jquery,
Ajax

Styling: CSS

How To use
================================================

**Step - 1** : Logging into a Developer Account
You need to login with your facebook account at https://developers.facebook.com/. Once done you can create a new app over there.Follow the steps and the app is created as per your need.
- From menu select Apps -> Add a New App -> Give Name and click on Create App ID.
- now select facebook login and click on **"Set Up"** button => **www(Web)** => Provide your site url in Site Url textbox.(Example : https://www.xyz.com) ans click on save button.
- After doing all this step you have to st up **"Valid OAuth Redirect URIs"** of your application.

**Step - 2 : Configuring your App**

Once the app is created you will be provided with a appId and appSecret which are very important and you shouldn't disclose them to anybody but you or a trusted developer. Afterwards, you need to set the App Domain for your app, a Site URL and a valid OAuth redirection url. They all must be the same and should be in the whitelisted URL list which are secure and allowed by Facebook.

This app-id and app-Secret are used to authenticate and authorize your app with facebook when a user tries to access and user your app's services.

After setting your app : Download Composer from <a href="https://getcomposer.org/">Download Composer</a>

NOTE : even if localhost url also works but you have to use "https" protocol.

## Now Download or Clone our app from github
=> put this in root directory(Wamp => www, xampp => htdocs)
=> unzip it.
In the project's root directory download Facebook PHP SDK For that.. And Google Client Api

Run this command:
```sh
composer require facebook/graph-sdk
composer require google/apiclient:"^2.0"
```
Or

if you are using my project then you just have use `composer install ` command.
<p><b>NOTE : you have to make changes in facebook graph api's => Facebook/Helpers/FacebookRedirectLoginHelper.php file.</b></p>

`$redirectUrl = FacebookUrlManipulator::removeParamsFromUrl($redirectUrl, ['code', 'state']);`

to

`$redirectUrl = FacebookUrlManipulator::removeParamsFromUrl($redirectUrl, ['code', 'state', 'enforce_https']);`


=> go to config.php
	Set:

        $fb = new Facebook\Facebook([
            'app_id' => 'XXXXXXXXXXXXXX', // Replace {app-id} with your app id
            'app_secret' => 'XXXXXXXXXXXXXX', //Replace {app-secret} with your app secret
            'default_graph_version' => 'v2.2',
        ]);

> **Supervisor Configuration** : You have to put "worker.conf" configuration file in Supervisor installation directory. (Hint : In Ubuntu "etc/supervisor/conf.d")

> **For the email configuration** (If you are using google's smtp) : You need to first setup seperate app password in your google account. and use that password in your email.php

- Now setup Google Application on <a href="https://console.developers.google.com/">Google Console Developer</a>
- After that download client_secrete.json and put it into the root folder of project.
- Now, Run the index.php page and have fun :wink: :blush:
