# allsky-aligner
tool to align constellation overlay

Very alpha. If you'd like to help:
1) copy aligner.php into ~/allsky/html/allsky/
2) copy the test image into a location that your webserver will be able to access. Or use your own image
3) navigate to http:/your-allsky-host/allsky/aligner.php
4) prefix an "i" to the path to the image in the text box, and press enter. This will cause a jquery event handler to fire, and:
5) your image should appear

I could use a quick browse through aligner.php by an experienced allsky developer for feedback on any real issues. So far it isn't really PHP code at all. I think it will have to have some PHP to write out the alignment parameters

Next steps:
* make the latitude and longitude configurable
* add a real file selector
* get the time from the image, for use in planetarium object
* get the constellation adjusting buttons working
* make the whole thing prettier
* get image and constellation scaling figured out
* present results in a form usable by allsky
* pull request on changes needed in all-sky for use in html/allsky/virtualsky/virtualsky.js
* * see https://github.com/AllskyTeam/allsky/discussions/3462#discussioncomment-8753359
  *  scaling, rotation, xoffset, yoffset
