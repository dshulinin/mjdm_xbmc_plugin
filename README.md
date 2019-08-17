XBMC / Kodi is a media player distro.
Majordomo is a smarthome automation software.
This is a plugin to control XBMC/Kodi music player from Majordomo interface.

Short manual:
1) Place the file "kodi_api.php" in the webroot dir of majordomo (default is /var/www/html);
2) ensure that the account under which majordomo web server is running can read "kodi_api.php". And may the chmod help you if the previous is not true;
3) create a "Control Menu" type object in majordomo admin interface and pick the type "Custom HTML-code" for this object; 
4) copy and paste the contents of "menu_object.txt" from this repository into "Data" field of the Control Menu object created on the previous step;
5) after pasting into the Data field find and correct the following variables according to your XBMC/Kodi:
xbmc_ip = '192.168.1.21';
music_lib_dir = '/home/user/Music/';
xbmc_user = 'user_kodi';
xbmc_pwd = 'super_password';
If you do not use authentication in XBMC/Kodi interface feel free to leave "xbmc_user" and "xbmc_pwd" blank like ''.
6) add the created "Control Menu" object to your fabulous scene in Majordomo interface.
7) enjoy!

Current CONS:
1) no " ' " signs in music dirs names allowed (if you have a folder on your Kodi host by the name "Music's" it WON'T play);
2) the field of plugin showing currently played item updates automatically every 8 seconds;
3) no SSL encryption of API calls from majordomo to Kodi/XBMC (well that's Kodi "by design" feature).
