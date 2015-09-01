  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-63824291-1', 'auto');
  ga('send', 'pageview');
  var topIndex=0;
  var animateDynamyicInterval=setInterval(animateDynamic,2000);
  function animateDynamic() {
    if(topIndex < -71*11)
       {
          $("#dynamic-space")[0].style.top=0;
          topIndex = -71;
        }
        else
            topIndex = topIndex -71.2;
            $("#dynamic-space").animate({top: topIndex+"px"}, 500);
        }
var app = angular.module('soulHomeApp',[]).config(function($interpolateProvider){
            $interpolateProvider.startSymbol('##').endSymbol('##');
        });
    app.config(['$routeProvider',
        function($routeProvider){
      $routeProvider.
      when('/discover',{
        templateUrl:"/soundtrack/angular",
        controller:'lifeSoundController'
      }).
      otherwise({redirectTo:'/discover'});
    }]);
    app.directive('routeLoadingIndicator', function($rootScope) {
    return {
      restrict: 'E',
      template: '<div ng-show="isRouteLoading" style="margin-top:50px;opacity:0.5;text-align:center;background-color:white;width:100%;width: 50%;margin-left: 30%;box-shadow:0 1px 1px 0px rgba(0, 0, 0, 0.2), 0 0 2px 1px rgba(255, 255, 255, 0.5)"><img src="/pictures/icons/loading.gif" style="opacity:1;margin-top: 0px;margin-right: -55px;"><span class="awesome-loading">loading Awesomness ...</span></div>',
      replace: true,
      link: function(scope, elem, attrs) {
        scope.isRouteLoading = false;
   
        $rootScope.$on('$routeChangeStart', function() {
          scope.isRouteLoading = true;
        });
        $rootScope.$on('$routeChangeSuccess', function() {
          scope.isRouteLoading = false;
        });
      }
    };
  });

    app.controller('lifeSoundController',function($scope, $http , $routeParams){
      $scope.nickName=$routeParams.nickName;
      if($routeParams.nickName)
        var urlParams="?nickName="+$routeParams.nickName;

    var options, a;
    jQuery(function(){
        options = { serviceUrl:"http://ws.audioscrobbler.com/2.0/?method=track.search&api_key=543fc405ef684b058fa4808ce33ee018&format=json&limit=5&"};
        try{
          a = $('#song-input-echo').autocomplete(options);
        }catch(e){console.log("error"+e);}
    }); 

var gSpaceIndex = 1;
var editedId;
var stopTyping;
var gSpaceIndex = 1;
$("#song-input").on("change keyup paste", function(){
    clearTimeout(stopTyping);
    stopTyping = setTimeout(completeTrack,500);
    if($("#song-input").val().indexOf(" ") == -1) 
      gSpaceIndex = 1;
    var spaceIndex = $("#song-input").val().split(" ").length;
    if(gSpaceIndex < spaceIndex) 
    {
      gSpaceIndex = spaceIndex;   
      $("#song-input-echo").val($("#song-input").val());
      $("#song-input-echo").focus();
      $("#song-input").focus();
    }
});
var gSpaceIndex = 1;
var gtest;
$("textarea").on("change keyup paste", function(e){
    if((e.keyCode == 13)&&($(this).val().trim() != ""))
      submitComment($(this).attr("id").substr(12));
});

  $http({method:'GET',
         url:"/app_dev.php/getangular/tracks?nickName=icex&?idx=0"
  })
  .success(function(data, status, headers){
    $scope.tracksArray = data.trackArray;
    $scope.searchMessage = "#Type a song or an artist name ";
    $scope.idx = 0;
    $scope.user =  data.user;
    $scope.boards = data.boardsArray;
    var time=10000;
    for (var i = 0; i < $scope.tracksArray.length; i++) {
      if($scope.tracksArray[i].photos.length > 1 )
          {
            $scope.tracksArray[i].photos.idx = 0;
          }
    };
    $scope.ignoreScrolling = false;
    if($scope.user.background)
    {
      $("#cover-image").css("background-image","url("+$scope.user.background+")");
      $(".filter-previews").attr("src",$scope.user.background);
      $("#cover-image").css("-webkit-filter",""); 
    }
    var title=$scope.user.fullName+"'s Soundtrack";
    $("textarea").on("change keyup paste", function(e){
              if((e.keyCode == 13)&&($(this).val().trim() != ""))
                submitComment($(this).attr("id").substr(12));
                });
  });
  
  if(firstTimeScrollDefined == true)
    {
      firstTimeScrollDefined = false;
      $(document).scroll(function(){
            if((-$(this).scrollTop() + $(this).height() < 100) && $scope.ignoreScrolling == false)
            return;
      })
    }
    boardId = -1;
    if(editId == 0)
      getEditId();
    if(playing == false)
      $("#Soundtagged").fadeOut();


$scope.addSong = function () {
};

$scope.submitTrackComment =  function(track){
  $("#sing-up-btn").click();
};
});
var editId=-1;
var playing=false;
var firstTimeScrollDefined=true;
var intervalArray = [];

function hideAllNotifs() {
  return 0;
}


function completeTrack() {
      $("#song-input-echo").val($("#song-input").val());
      $("#song-input-echo").focus();
      $("#song-input").focus();
}


var idCache = new Array();
function addSong(songName,songPic)
{
  
 
if(songName)
{
  keyWord=songName;
  var artist = songName.split("-")[1];
  var title = songName.split("-")[0];
  var newTrackId = 0;
  var search = artist+" "+title;
  var searchId =search.split(" ").join("_");
  if(idCache.length == 0)
      idCache.push(0);
  else
  {
      newTrackId=idCache[idCache.length - 1];
      newTrackId--;
      idCache.push(newTrackId);
  }
  var lyricsLoading = "<span id='lyricsLoading"+newTrackId+"' ><span id='lyricsFading"+newTrackId+"'><img style='margin-right: -50px;opacity: 0.5;z-index: -2;margin-left: 105px;' src='/pictures/icons/loading.gif' > Searching Lyrics</span></span>";

  var controlHtml='<span class="file-uploader-container upload-track-true-container uploadPhotoNoLyrics2" style="left:inherit;top:45px;opacity:0.8;" class="uploadPhotoNoLyrics" onclick="fakeTrackUploadTrigger('+newTrackId+')">'+
                '<img src="/pictures/icons/camera-big.png" class="updaload-track-pic-img">'+
              '</span>'+
              '<span>'+
                '<img ng-show="track.photos.length == 0" ng-click="fakeBindTrigger(track)" title="Mark a place" id="bind-to-a-board" src="https://cdn0.iconfinder.com/data/icons/android-icons/512/location-01-256.png"  style="height: 30px;top: -53px;" ng-class="{bindNoLyrics:track.lyrics == null,bindNoLyrics2:track.lyrics != null}" class="bindNoLyrics2" onClick="append_map('+newTrackId+')">'+

               '</span>'+
               '<button id="choose-lyrics-button'+newTrackId+'" class="btn btn-default btn-select-lines noLyricsChooseButton2" onclick="chooseLyrics('+newTrackId+')" style="margin-top: 1%;color: black;text-transform: none;border: 1px grey solid;">'+
                    '<img src="/pictures/icons/lyrics.png">'+
                     'lyrics'+
               '</button>';
  var mapHtml='<div class="col-md-6 col-sm-10 col-xs-10 col-md-offset-3 col-sm-offset-1 col-xs-offset-1 song_map" id="map'+newTrackId+'"></div>';
  var myhtml='<div class="col-md-6 col-sm-10 col-xs-10 col-md-offset-3 col-sm-offset-1 col-xs-offset-1 main-comment-area" ><textarea id="comment-area'+newTrackId+'" type="text" class="form-control tag-input"  placeholder="What do you think about when you listen to '+title+'?" ></textarea><img src="/pictures/icons/tag_music.jpg" class="song-tag-icon"></div>'+mapHtml+'<span class="board-date">added </span><div class="col-md-6 col-sm-10 col-xs-10 col-md-offset-3 col-sm-offset-1 col-xs-offset-1 sub-container new-track-preview" >'+controlHtml+
      '<button id="done-selecting-button'+newTrackId+'" class="btn btn-success btn-select-lines disabled" onClick="doneSelecting('+newTrackId+')" style="margin-top: 1%;display:none;margin-top: -87px;" >Done selecting</button><img src="/pictures/icons/lyrics.png" style="top: -8%;opacity: 0;height: 55px;margin-left: 189px;cursor: auto;" /><span id="lyrics'+newTrackId+'"><span id="lyrics'+newTrackId+'"><p class="lyrics-limited">'+lyricsLoading+'</p></span><span id="'+searchId+'"  class="youtube-frame-container"></span></span><span class="new-track-preview-title" ><img src="/pictures/icons/big-play-black.png" title="Play" class="play-btn"  id="playSong'+newTrackId+'"  onClick=playSong('+newTrackId+',"")><span id="songTitle'+newTrackId+'">'+title+' -  '+artist+'</span></div>';

    sendTrack(title,artist,null,null,newTrackId,songPic);
    $("#soundtrack-main-container").prepend(myhtml);
    $("#lyricsFading"+newTrackId).fadeOut(5000);
    $("#song-input").val("");
}
else
{
  $("#add-song-loading").fadeIn();
  songName=$("#song-input").val();
  if(songName.length == 0)
    return false;
}

}

var nextId=0;
var newTrackId=0;
function sendTrack(title,artist,lyrics,mood,newTrackId,songPic)
{
 
                $("#validate-lyrics-button").fadeIn();
                var url='http://api.lyricsnmusic.com/songs?api_key=0ece71190cce454fd5beea3db7ec22&track='+encodeURI(title)+'&artist='+encodeURI(artist);
                $.ajax({
                crossDomain: true,
                contentType: "json; charset=utf-8",
                dataType : "jsonp",
                url: url,
                cache:true,
                }).done(function( data ) {
                    var gdata=data.data.sort(sortingOccur);
                    var lyrics=gdata[0].snippet.trim();
                    $("#lyricsLoading"+newTrackId)[0].innerHTML=lyrics;
                    $("#song-input").val("");
                  }
                );
}


function containsOne(elt){ 
  return elt.title.indexOf(keyWord) > -1 
}

function sortingOccur(a,b){
    return (numbreOfOccurance(b.title+" "+b.artist.name,keyWord) - numbreOfOccurance(a.title+" "+a.artist.name,keyWord))
  }


function numbreOfOccurance(strA,strB)
{
  var total=0;
  var total2=0;
  var tabA=strA.toLowerCase().split(/[\s,?!]+/);
  var tabB=strB.toLowerCase().split(/[\s,?!]+/);

  for (var j = 0; j< tabA.length; j++) 
  {
    for (var i = 0; i < tabB.length; i++) 
    {
      if( tabB[i] == tabA[j] ) {
        total ++ ;
        if( i == j) total++ ;
      }
    };
  };

  for (var j = 0; j< tabB.length; j++) 
  {
    for (var i = 0; i < tabA.length; i++) 
    {
      if( tabB[j] == tabA[i] )
      {
        total2 ++ ;
        if( i == j) total2 ++ ;
      }
    };
  };
  return Math.min(total,total2);
}

function select(id,i)
{
  var lineId=id+""+i;
  var elt=$("#l"+lineId);
  $("#done-selecting-button"+id).attr("class","btn btn-success btn-select-lines");
  elt[0].getAttribute.class="lyrics-line selected";
  elt.attr("class","lyrics selected");
  elt.attr("onClick","deselect("+id+","+i+")");
}

function deselect(id,i)
{
  var lineId=id+""+i;
  var elt=$("#l"+lineId);
  elt.attr("class","lyrics notSelected");
  elt.attr("onClick","select("+id+","+i+")");
}

function doneSelecting(id)
{
  var chosenlyrics = $("#editArea"+id).val();
  $("#lyrics"+id)[0].innerHTML="<p class='lyrics-limited'><span id='lyricsLoading"+id+"'>"+chosenlyrics+"</span></p>";
  $("#done-selecting-button"+id).fadeOut();
  $("#choose-lyrics-button"+id).fadeIn();
}

function chooseLyrics(id)
{

  if($("#lyricsLoading"+id)[0].innerText.length > 0)
    var oldLyrics =  $("#lyricsLoading"+id)[0].innerHTML;
  else
    var oldLyrics = "";

  $("#choose-lyrics-button"+id).fadeOut();
  $("#done-selecting-button"+id).fadeIn();
  $("#lyrics"+id)[0].innerHTML="<textarea class='form-control editArea' id='editArea"+id+"'  >"+
                                 oldLyrics.replace('<p class="lyrics-limited">',"").replace("</p>","").trim()+
                                 "</textarea>";
  $("#done-selecting-button"+id).attr("class","btn btn-success btn-select-lines");
}



function playSong(songtrackId,youtubeId)
{
   var songTitle = $("#songTitle"+songtrackId)[0].innerHTML;
   $("#player-track-title")[0].innerHTML=songTitle;
   var trackIdInt=parseInt(songtrackId);
   try{
     $("#nextTrack").attr("onClick","playSong("+(trackIdInt-1)+",'')");
     $("#previousTrack").attr("onClick","playSong("+(trackIdInt+1)+",'')");
     $("#previousTrack").attr("title",$("#songTitle"+(trackIdInt+1))[0].innerText);
     $("#nextTrack").attr("title",$("#songTitle"+(trackIdInt-1))[0].innerText);
   }catch(e){console.log("error"+e)}
   if(youtubeId.length == 0 || youtubeId == "null")
    {
      searchSoundCloudId(songTitle,songtrackId)
    }
   else
   {
      play_track(youtubeId);
   }
}

function updateYoutubeId(songtrackId,videoId)
{
  var url="/app_dev.php/soundtrack/updateYoutubeId";
  $.get(url,{
             songtrackId:songtrackId,
             videoId:videoId
         },function(data){   
                  $("#playSong"+songtrackId).attr("onClick","playSong("+songtrackId+",'"+videoId+"')"); 
               }); 
}

function searchSoundCloudId(str,songtrackId) {
  var url="http://api.soundcloud.com/tracks.json?client_id=229b5c9f7dca199464f6a3d38a9a16d1&q="+str+"&limit=5";
  $.get(url,{},function(data){ 
             if(soundObject)
             {
              soundObject.stop();
              soundObject.destruct();
              soundObject=null;
             }
             play_track(data[0].id);
             $("#player-giraffe")[0].style.bottom="initial";
             $("#player-giraffe")[0].style.left="30%";
             $("#player-giraffe")[0].style.display="block";
             $("#player-giraffe")[0].style.position="fixed";
                })
      }

function append_map(trackId)
{
  var mapCanvas = document.getElementById('map'+trackId);
  var mapOptions = {
  center: new google.maps.LatLng(44.5403, -78.5463),
                                            zoom: 8,
                                            mapTypeId: google.maps.MapTypeId.ROADMAP
            };
  var map = new google.maps.Map(mapCanvas, mapOptions);
  mapCanvas.style.display="block";
  initAutocomplete(trackId);
}



function initAutocomplete(trackId) {
  var map = new google.maps.Map(document.getElementById('map'+trackId), {
    center: {lat: -33.8688, lng: 151.2195},
    zoom: 13,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();
    if (places.length == 0) {
      return;
    }
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }));

      if (place.geometry.viewport) {
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
}


function msToTime(s) {
  function addZ(n) {
    return (n<10? '0':'') + n;
  }

  var ms = s % 1000;
  s = (s - ms) / 1000;
  var secs = s % 60;
  s = (s - secs) / 60;
  var mins = s % 60;
  var hrs = (s - mins) / 60;
  return addZ(mins) + ':' + addZ(secs);
}

try
{
  function loadSongTrack(trackId){
    SC.initialize({
      client_id: "229b5c9f7dca199464f6a3d38a9a16d1",
    });
    SC.get("/tracks/"+trackId, {limit: 1}, function(tracks){      
      $("#ending")[0].innerHTML=msToTime(tracks.duration);
    });
  }
}catch(e){
  console.log("error initialing sound cloud "+e);
};
var soundObject;
var a=new Object();
a.position=0;
function play_track(trackId) {
try{ 
    playing=true;
    if(soundObject)
      soundObject.resume();
    else{
      SC.initialize({
        client_id: "229b5c9f7dca199464f6a3d38a9a16d1",
      });

      SC.get("/tracks/"+trackId, {limit: 1}, function(tracks){
      
        $("#ending")[0].innerHTML=msToTime(tracks.duration);
      });

      SC.stream("/tracks/"+trackId, function(sound){
         soundObject=sound;
         setTimeout(delayedMouseLeave,10000);
         soundObject._whileplaying = function (b,c,d,e,f)
         {
          if(a.position)
            {
              $("#beginning")[0].innerHTML=msToTime(a.position);
            }
          if(a.position == soundObject.durationEstimate)
            stop_track();
          $("#progress-line-playing").css('width', ((a.position/soundObject.durationEstimate) * 100) + '%'); 
          var g=a._iO;if(isNaN(b)||null===b)return!1;a.position=b;a._processOnPosition();if(!a.isHTML5&&8<i){if(g.usePeakData&&"undefined"!==typeof c&&c)a.peakData={left:c.leftPeak,right:c.rightPeak};if(g.useWaveformData&&"undefined"!==typeof d&&d)a.waveformData={left:d.split(","),right:e.split(",")};if(g.useEQData&&"undefined"!==typeof f&&f&&f.leftEQ&&(b=f.leftEQ.split(","),a.eqData=b,a.eqData.left=b,"undefined"!==typeof f.rightEQ&&f.rightEQ))a.eqData.right=f.rightEQ.split(",")}1===a.playState&&(!a.isHTML5&&8===i&&!a.position&&a.isBuffering&&a._onbufferchange(0),g.whileplaying&&g.whileplaying.apply(a));
         return!0
       };
         soundObject.play();
       });
      };
    $("#playerPlayButton").attr("src","/pictures/icons/big-pause.png");
    $("#playerPlayButton").attr("onClick","pause_track("+trackId+")");
    $("#Soundtagged").attr("src","/pictures/icons/pause.png");
    $("#Soundtagged").attr("onClick","pause_track("+trackId+")");
    }catch(e){console.log(e);}
}
function pause_track(trackId) {
    playing=false;
    soundObject.pause();
    $("#playerPlayButton").attr("src","/pictures/icons/big-play.png");
    $("#playerPlayButton").attr("onClick","play_track("+trackId+")");
    $("#Soundtagged").attr("src","/pictures/icons/play-button.png");
    $("#Soundtagged").attr("onClick","play_track("+trackId+")");   
}


function stop_track() {
    playing=false;
    soundObject.stop();
    $("#progress-line-playing").css('width', '0%');
    $("#playerPlayButton").attr("src","/pictures/icons/big-play.png");
    $("#playerPlayButton").attr("onClick","play_track("+trackId+")");
    $("#Soundtagged").attr("src","/pictures/icons/play-button.png");
    $("#Soundtagged").attr("onClick","play_track("+trackId+")");   
}

function hidePlayerContainer()
{
  $("#player-container").fadeOut();
}

function displayPlayerContainer()
{
  $("#player-container").fadeIn();
}

var hideplayerContainerTimeout;
function delayedMouseLeave()
{
  if(!$("#player-container").is(":hover"))
    hidePlayerContainer();

  clearTimeout(hideplayerContainerTimeout);
};