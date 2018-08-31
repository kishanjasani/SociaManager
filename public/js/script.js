$(window).on('load',function(){
  $('.loader').css('display','none');
})

$(document).ready(function() {
    //Init side nav
    $(".button-collapse").sideNav();
    $('#modal').modal(); 

    //Hide Download Selected Album button
    $(".selectedAlbums").hide(function() {
      $("#profile")
        .removeClass("section-profile")
        .addClass("profile");
    });

    //==================================================================================
      $('.card-image').click(function() {
        var albumId = $(this).attr('album-id');
        $('.loader').css('display','block');
        $.ajax({
            url: "slider.php?albumId=" + albumId,
            success: function(result) {
              $('.loader').css('display','none');   
              $('.overlay').css('width','100%');
              $('.slideshow-container').html(result);
              flag = 1;
            }
        });
      })

    //===============
    function append_download_link(url) {
      $('.download-process').css('display','block');
      $('.loadermessage').text("Please wait... Albums are downloading");
      $.ajax({
        url: url,
        success: function(result) {
          $('.download-process').css('display','none');
          $(".modal-content").html(result);
          $('#modal').modal('open');
        }
      });
    }

    var count = 0;
    $(".select-album").on("change", function() {
      if ($(this).is(":checked")) {
        count++;
      } else {
        count--;
      }
      if (count > 0) {
        $(".selectedAlbums").show(function() {
          $("#profile")
            .removeClass("profile")
            .addClass("section-profile");
        });
      } else {
        $(".selectedAlbums").hide(function() {
          $("#profile")
            .removeClass("section-profile")
            .addClass("profile");
        });
      }
    });

    function get_all_selected_albums() {
      var selected_albums;
      var i = 0;
      $(".select-album").each(function() {
        if ($(this).is(":checked")) {
          if (!selected_albums) {
            selected_albums = $(this).val();
          } else {
            selected_albums = selected_albums + "-" + $(this).val();
          }
        }
      });

      return selected_albums;
    }

    $(".single-export").on("click", function() {
        var rel = $(this).attr("rel");
        var album = rel.split(",");
        append_download_link(
          "download-album.php?single_export=" + album[0] + "," + album[1]
        );
    });

    $(".single-download").on("click", function() {
      var rel = $(this).attr("rel");
      var album = rel.split(",");
      append_download_link(
        "download-album.php?zip=1&single_album=" + album[0] + "," + album[1]
      );
    });

    $("#download-selected-albums").on("click", function() {
      var selected_albums = get_all_selected_albums();
      append_download_link(
        "download-album.php?zip=1&selected_albums=" + selected_albums
      );
    });

    $(".download-all-albums").on("click", function() {
      append_download_link("download-album.php?zip=1&all_albums=all_albums");
    });


    function move_to_drive(param1, param2) {

        var google_access_token = $('.g-access-token').text();
        if(google_access_token === "Hello") {
            $('.download-process').css('display','block');
            $('.loadermessage').text("Please wait... File is moving in to google drive");
            $.ajax({
                url: "https://localhost:8443/SociaManager/google_drive/google_login.php?" + param1 + "=" + param2,
                success: function (result) {
                    $('.download-process').css('display','none');
                    $(".modal-content").html(result);
                    $('#modal').modal('open');
                }
            });
        } else {
            window.location = "https://localhost:8443/SociaManager/google_drive/google_login.php";
        }
    }

    $(".move-single-album").on("click", function() {
        var single_album = $(this).attr("rel");
        move_to_drive("single_album", single_album);
    });

    $("#move-selected-albums").on("click", function() {
        var selected_albums = get_all_selected_albums();
        move_to_drive("selected_albums", selected_albums);
    });

    $(".move_all").on("click", function() {
        move_to_drive("all_albums", "all_albums");
    });
    
});

// Slider Script in vanilla java script

var flag =0;
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

var y = 0;
setInterval(function displaySlider(){
    var slides = document.getElementsByClassName("mySlides");
    showSlides(slideIndex = y);
    y++;
    if (y > slides.length) {
        slideIndex = 1
        y = 1;
    }    
}, 3000);

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  
  if(flag != 0){
    flag =1;
    slides[slideIndex-1].style.display = "block"; 
  }
}