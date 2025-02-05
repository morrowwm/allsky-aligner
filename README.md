# allsky-aligner
tool to align constellation overlay in https://github.com/AllskyTeam/allsky

Very alpha. If you'd like to help:
1) copy aligner.php into ~/allsky/html/allsky/ and virtualsky.js into ~/allsky/html/allsky/virtualsky/
2) copy the test image into a location that your webserver will be able to access. Or use your own image
3) navigate to http:/your-allsky-host/allsky/aligner.php
4) in allsky, browse to a good image, right-click copy image address and paste into the Image textbox
5) click on Load. This will cause a jquery event handler to fire, and:
6) your image should appear

7) open the developer console, click on the navigation buttons, you should see messages
8) the map should rotate, pan and zoom now
9) There are popup helps on the less intuitive buttons. The origin setting button doesn't do anything, yet.

I could use a quick browse through aligner.php by an experienced allsky developer for feedback on any real issues. So far it isn't really PHP code at all. I think it will have to have some PHP to write out the alignment parameters

Next steps:
* make the latitude and longitude configurable. May not be necessary. It's reading them from the allsky configuration.json.
* add a real file selector. Might not, see the procedure above
* **Done** the time from the image, for use in planetarium object
* **Done**: get the constellation adjusting buttons working. This will take some changes to virtual sky, I think?
* make the whole thing prettier
* **Done for fisheye** get image and constellation scaling figured out ** Working for fisheye/polar **
* present results in a form usable by allsky
* pull request on changes needed in all-sky for use in html/allsky/virtualsky/virtualsky.js
* * see https://github.com/AllskyTeam/allsky/discussions/3462#discussioncomment-8753359
  *  scaling, rotation, xoffset, yoffset
* pull it into allsky baseline? 
