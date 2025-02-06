# allsky-aligner
tool to align constellation overlay in https://github.com/AllskyTeam/allsky
![image](https://github.com/user-attachments/assets/73e2b67c-e064-4826-a72a-294d795825d0)


Very alpha. If you'd like to help:
1) copy aligner.php into ~/allsky/html/allsky/
2) save away a copy then overwrite ~/allsky/html/allsky/virtualsky/virtualsky.js with this version
3) copy the test image into a location that your webserver will be able to access. Or better, use your own image.
4) navigate to http:/your-allsky-host/allsky/aligner.php
5) in a separate browser tab, go to your allsky, browse to a good image, right-click "Copy image address" and paste into the Image textbox of the Aligner in your first  tab
6) click on Load. This will cause a jquery event handler to fire, and:
7) your image should appear
8) the map should rotate, pan and zoom now
9) There are popup helps on the less intuitive buttons. The origin setting button doesn't do anything, yet.

### Button Functions
  
🞋 set the rotation origin. Currently does not do anything  
↻ ↺ rotate  
scale: + − 
★ toggle visibility of stars and planets  
♓ toggle visibility of constellations  
🠜 🠞 🠝 🠟 translate  
🠜🠜 🠞🠞 change step size for adjustments by 20%  
the slider adjusts the magnitude threshold for stars' visibility  

I could use a quick browse through aligner.php by an experienced allsky developer for feedback on any real issues. So far it isn't really PHP code at all. I think it will have to have some PHP to write out the alignment parameters

Next steps:
* make the latitude and longitude configurable. May not be necessary. It's reading them from the allsky configuration.json.
* add a real file selector. Might not, see the procedure above
* **Done** the time from the image, for use in planetarium object
* **Done**: get the constellation adjusting buttons working. This will take some changes to virtual sky, I think?
* make the whole thing prettier
* **Done for fisheye** get image and constellation scaling figured out ** Working for fisheye/polar **
* present results in a form usable by allsky controller.js
* pull request on changes needed in all-sky for use in html/allsky/virtualsky/virtualsky.js
* * see https://github.com/AllskyTeam/allsky/discussions/3462#discussioncomment-8753359
  *  scaling, rotation, xoffset, yoffset
* pull it into allsky baseline? 
