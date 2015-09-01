var velcro;
function PunkAveFileUploader(options)
{
  var self = this,
    uploadUrl = options.uploadUrl,
    viewUrl = options.viewUrl,
    $el = $(options.el),
    uploaderTemplate = _.template($.trim($('#file-uploader-template').html()));
  $el.html(uploaderTemplate({}));
  var fileTemplate = _.template($.trim($('#file-uploader-file-template').html())),
    editor = $el.find('[data-files="1"]'),
    thumbnails = $('#caching-pictures');
  
  self.uploading = false;
  
  self.errorCallback = 'errorCallback' in options ? options.errorCallback : function( info ) { if (window.console && console.log) { console.log(info) } },

  self.addExistingFiles = function(files)
  {
    _.each(files, function(file) {
      appendEditableImage({
        'thumbnail_url': viewUrl + '/thumbnails/' + file,
        'url': viewUrl + '/originals/' + file,
        'name': file
        });
    });
  };

  // Delay form submission until upload is complete.
  // Note that you are welcome to examine the
  // uploading property yourself if this isn't
  // quite right for you
  self.delaySubmitWhileUploading = function(sel)
  {
    $(sel).submit(function(e) {
        if (!self.uploading)
        {
            return true;
        }
        function attempt()
        {
            if (self.uploading)
            {
                setTimeout(attempt, 100);
            }
            else
            {
                $(sel).submit();
            }
        }
        attempt();
        return false;
    });
  }

  if (options.blockFormWhileUploading)
  {
    self.blockFormWhileUploading(options.blockFormWhileUploading);
  }

  if (options.existingFiles)
  {
    self.addExistingFiles(options.existingFiles);
  }

  editor.fileupload({
    dataType: 'json',
    url: uploadUrl,
    dropZone: $el.find('[data-dropzone="1"]'),
    done: function (e, data) {
      if (data)
      {
        _.each(data.result, function(item) {
          var str = item.thumbnail_url
          item.thumbnail_url="/web"+str;
          console.log(item);
          appendEditableImage(item);
          $("#profil-pic-preview").attr("src","/web/"+item.medium_url);
          var editStr=item.small_url;
          var id=editStr.substr(0,editStr.indexOf("/small")).replace("/uploads/tmp/attachments/","")
          velcro = id;
          if(isVelcroWallpaper)
          {
            $("#cover-image").css("background-image","url('/web/"+item.medium_url+"')");
            $(".filter-previews").attr("src","/web/"+item.medium_url);
            upaloadBoardBackground(id,"/web/"+item.medium_url);
          }
          else if(isProfilPic == true)
          {
            $("#submitProfilPicture").attr("onClick","saveProfilPicture("+id+",'"+"/web/"+item.medium_url+"')");
            isProfilPic = false;
          }
          else if(isAvatar)
          {
           $("#avatar-input").val("/web/"+item.medium_url);
            isAvatar = false;
          }
          else if(trackUploadId != -1)
          {
            $("#submitUploadTrackBackground").attr("onClick","saveUploadedTrackBackground("+id+",'"+"/web/"+item.medium_url+"')");
          }
          else
          {            
            $("#submitBackgroundButton").fadeIn();
            $("#submitBackgroundButton").attr("onClick","saveUploadedBackground("+id+",'"+"/web/"+item.medium_url+"')");
            appendPicture(id,"/web/"+item.medium_url);

          }
        });
      }
    },
    start: function (e) {
      $el.find('[data-spinner="1"]').show();
      self.uploading = true;
    },
    stop: function (e) {
      $el.find('[data-spinner="1"]').hide();
      self.uploading = false;
    }
  });

  // Expects thumbnail_url, url, and name properties. thumbnail_url can be undefined if
  // url does not end in gif, jpg, jpeg or png. This is designed to work with the
  // result returned by the UploadHandler class on the PHP side
  function appendEditableImage(info)
  {
    if (info.error)
    {
      self.errorCallback(info);
      return;
    }
    var li = $(fileTemplate(info));
    li.find('[data-action="delete"]').click(function(event) {
      var file = $(this).closest('[data-name]');
      var name = file.attr('data-name');
      $.ajax({
        type: 'delete',
        url: setQueryParameter(uploadUrl, 'file', name),
        success: function() {
          file.remove();
        },
        dataType: 'json'
      });
      return false;
    });

    thumbnails.append(li);
  }

  function setQueryParameter(url, param, paramVal)
  {
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1]; 
    var temp = "";
    if (additionalURL)
    {
        var tempArray = additionalURL.split("&");
        var i;
        for (i = 0; i < tempArray.length; i++)
        {
            if (tempArray[i].split('=')[0] != param )
            {
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }
    var newTxt = temp + "" + param + "=" + encodeURIComponent(paramVal);
    var finalURL = baseURL + "?" + newAdditionalURL + newTxt;
    return finalURL;
  }
}


