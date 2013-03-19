<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>string rain</title>
<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=false" />
<link rel="apple-touch-startup-image" href="http://placehold.it/320x460.png&text=string+rain"> 
<link rel="apple-touch-startup-image" href="http://placehold.it/640x920.png&text=string+rain" sizes="640x920">
<link rel="apple-touch-startup-image" href="http://placehold.it/640x1096.png&text=string+rain" sizes="640x1096">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<style>
* {
padding: 0;
margin: 0;
-webkit-tap-highlight-color: rgba(255, 155, 0, 0.0);
box-sizing: border-box;
}
html, body {
width: 100%;
height: 100%;
font-family: "Marker Felt";
background-color: #000;
color: #fff;
overflow: hidden;
-webkit-user-select: none;
}
</style>
</head>
<body id="w">
<canvas id="c" width="1096" height="1096">
</canvas>
<script>
document.getElementById("w").addEventListener("touchmove", function(e) {
e.preventDefault();
});
double=1;
window.onresize = function() {
wid=window.innerWidth;
hei=window.innerHeight;
if (double) {
wid=wid*2;
hei=hei*2;
}
if (wid>548) {
can.style.width="1096px";
}
else {
can.style.width="548px";
}
if (wid>1096) {
wid=1096;
}
if (hei>1096) {
hei=1096;
}
};
 
can=document.getElementById("c");
var c=can.getContext("2d");
c.font="30px 'Helvetica Neue'";
c.fillStyle="#FF0000";
strings=["lol", "what's up", "good day", "ouch! ", "jump", "ate yet? "];
<?php
if (isset($_GET["s"])) {
echo 'strings='.stripslashes(urldecode($_GET["s"])).';';
}
?>
 
txts=[];
spd=0.5;
delay=10;// If too small, will not increase speed
fps=160;
topm=30/2;
leftm=100/2;
leftpad=50;
toprng=50;
wid=window.innerWidth;
hei=window.innerHeight;
h=0;
spawnrng=15;
bottomkill=200;
if (double) {
can.style.width="548px";
c.font="60px 'Helvetica Neue'";
delay=delay;
spd=1;
topm=topm*2;
leftm=leftm*2;
bottomkill=bottomkill*2;
toprng=toprng*2;
leftpad=leftpad*2;
spawnrng=spawnrng*2;
wid=wid*2;
hei=hei*2;
if (wid>548) {
can.style.width="1096px";
}
else {
can.style.width="548px";
}
if (wid>1096) {
wid=1096;
}
if (hei>1096) {
hei=1096;
}
}
setInterval(function() {
setTimeout(function() {
if (txts.length<10) {
str=strings[(Math.floor(Math.random()*strings.length))];
if (str=="") {
alert("err");
}
txts[txts.length]=[str, Math.floor(Math.random()*(wid-leftpad*2))+leftpad, -Math.floor(Math.random()*toprng)];
}
}, Math.floor(Math.random()*spawnrng));
}, 1000);
now=before=new Date().getTime();
taken=0;
setInterval(function() {
now=new Date().getTime();
taken=now-before;
before=now;
dist=Math.floor(fps/1000*taken*spd*2+0.5)/2;
c.clearRect(0, 0, wid+bottomkill, hei+bottomkill);
for (i=0;i<txts.length;i++) {
txts[i][2]+=dist;
h+=dist;
c.fillText(txts[i][0], txts[i][1]-leftm, txts[i][2]-topm);
if (txts[i][2]>hei+bottomkill) {
txts.splice(i, 1);
}
}
}, delay);
</script>
</body>
</html>
