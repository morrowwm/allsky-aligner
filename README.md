# allsky-aligner
tool to align constellation overlay in https://github.com/AllskyTeam/allsky

Very alpha. If you'd like to help:
1) copy aligner.php into ~/allsky/html/allsky/
2) copy the test image into a location that your webserver will be able to access. Or use your own image
3) navigate to http:/your-allsky-host/allsky/aligner.php
4) enter the path (relative to the site root)  in the text box, and click on Load. This will cause a jquery event handler to fire, and:
5) your image should appear

6) open the developer console, click on the navigation buttons, you should see messages
7) constellations should rotate now

I could use a quick browse through aligner.php by an experienced allsky developer for feedback on any real issues. So far it isn't really PHP code at all. I think it will have to have some PHP to write out the alignment parameters

Next steps:
* make the latitude and longitude configurable
* add a real file selector
* get the time from the image, for use in planetarium object
* **Working on**: get the constellation adjusting buttons working. This will take some changes to virtual sky, I think?
* make the whole thing prettier
* get image and constellation scaling figured out
* present results in a form usable by allsky
* pull request on changes needed in all-sky for use in html/allsky/virtualsky/virtualsky.js
* * see https://github.com/AllskyTeam/allsky/discussions/3462#discussioncomment-8753359
  *  scaling, rotation, xoffset, yoffset
* pull it into allsky baseline? 
