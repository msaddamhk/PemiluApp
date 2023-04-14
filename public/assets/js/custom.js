$(document).ready(function () {
    $(".sidebarCollapseDefault").on("click", function () {
      $(".sidebar").toggleClass("active");
      $(".content").toggleClass("active");
    });
});

var elem = document.documentElement;
var isFullScreen = false;

function toggleFullScreen() {
  if (!isFullScreen) {
    if (elem.requestFullscreen) {
      elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) {
      elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
      elem.msRequestFullscreen();
    }
    isFullScreen = true;
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
    isFullScreen = false;
  }
}
document
  .getElementById("myButton")
  .addEventListener("click", function () {
    toggleFullScreen();
  });