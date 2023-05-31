VANTA.BIRDS({
  el: "#vanta",
  mouseControls:true,
  touchControls: true,
  gyroControls: true,
  minHeight: 600.00,
  minWeight: 200.00,
  scale: 1.00,
  scaleMobile: 1.00,
  color1: 0x430a0a,
  color2: 0x981515,
  
  quantity: 2.00, //This is for how much birds you want to display in the animation
  backgroundAlpha: 0.0,
  alignment: 77.00
});

AOS.init();

function whatsapp() {
  if(false) {
    location.href = 'whatsapp://send?phone=5545998438128&text=';
  } else {
    location.href = 'https://api.whatsapp.com/send?phone=5545998438128&text=';
  }
}

function mail() {
  location.href='mailto:fernandobrito.adv@hotmail.com';
}

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
    window.location.href = "https://www.instagram.com/fernandobrito.adv/";
  }
}

function facebook() {
  if (getMobileOS() == "Android") {
    window.location.href = "fb://profile/100001383777344";
  }
  if (getMobileOS() == "iOS") {
    window.location.href = "fb://profile/100001383777344";
  }
  if (!getMobileOS()) {
    window.location.href = "https://www.facebook.com/fernandobritopro";
  }
}

function share() {
  if(false) {
  location.href = 'whatsapp://send?phone&text=Este é o Cartão de Visita do Advogado *Fernando Brito*: https://site.com';
  } else {
    location.href = 'https://api.whatsapp.com/send?phone&text=Este é o Cartão de Visita do Advogado *Fernando Brito*: https://site.com';
  }
}