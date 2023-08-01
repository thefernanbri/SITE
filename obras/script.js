function getMobileOS() {
  var userAgent = navigator.userAgent || navigator.vendor || window.opera;

  // Android detection 
  if (/Android/i.test(userAgent)) {
    return "Android";
  }

  // iOS detection 
  if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
    return "iOS";
  }
  return false;
}

function instagram() {
  if (getMobileOS() == "Android") {
    window.location.href = "instagram://user?username=FernandoBrito.Adv";
  }
  if (getMobileOS() == "iOS") {
    window.location.href = "instagram://user?username=FernandoBrito.Adv";
  }
  if (!getMobileOS()) {
    window.open("https://www.instagram.com/fernandobrito.adv/");
  }
}