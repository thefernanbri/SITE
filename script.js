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
    location.href = 'whatsapp://send?phone=5545991164631&text=';
  } else {
    window.open("https://api.whatsapp.com/send?phone=5545991164631&text=");
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
window.open("https://www.instagram.com/fernandobrito.adv/");
  }
}

function facebook() {
  if (getMobileOS() == "Android") {
    window.location.href = "fb://profile/100092749495737";
  }
  if (getMobileOS() == "iOS") {
    window.location.href = "fb://profile/100092749495737";
  }
  if (!getMobileOS()) {
    window.open("https://www.facebook.com/100092749495737");
  }
}

function share() {
  if(false) {
  location.href = 'whatsapp://send?phone&text=Este é o Cartão de Visita do Advogado *Fernando Brito*: https://fernandobrito.adv.br';
  } else {
    window.open("https://api.whatsapp.com/send?phone&text=Este é o Cartão de Visita do Advogado *Fernando Brito*: https://fernandobrito.adv.br");
  }
}