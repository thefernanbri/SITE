VANTA.BIRDS({
  el: "#vanta",
  mouseControls: true,
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
  if (getMobileOS() == "Android") {
    window.location.href = "whatsapp://send?phone=5545991164631&text=";
  }
  if (getMobileOS() == "iOS") {
    window.location.href = "whatsapp://send?phone=5545991164631&text=";
  }
  if (!getMobileOS()) {
    window.open("https://api.whatsapp.com/send?phone=5545991164631&text=");
  }
}

function mail() {
  location.href = 'mailto:contato@fernandobrito.adv.br';
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
  if (getMobileOS() == "Android") {
    window.location.href = "whatsapp://send?phone&text=Este é o Cartão de Visita do Advogado *Fernando Brito*: https://bio.fernandobrito.adv.br";
  }
  if (getMobileOS() == "iOS") {
    window.location.href = "whatsapp://send?phone&text=Este é o Cartão de Visita do Advogado *Fernando Brito*: https://bio.fernandobrito.adv.br";
  }
  if (!getMobileOS()) {
    window.open("https://api.whatsapp.com/send?phone&text=Este é o Cartão de Visita do Advogado *Fernando Brito*: https://bio.fernandobrito.adv.br");
  }
}

// Obtém o elemento <p> pelo seu ID
var qrCodeParagraph = document.getElementById('qr-code');
// Adiciona um evento de clique ao elemento <p>
qrCodeParagraph.addEventListener('click', function() {
  // Obtém o elemento <a> pelo seu ID
  var link1 = document.getElementById('m2-c');

  // Clica no link1
  link1.click();
});
// Obtém o elemento <p> pelo seu ID
var qrCodeParagraph = document.getElementById('qr-code-site');
// Adiciona um evento de clique ao elemento <p>
qrCodeParagraph.addEventListener('click', function() {
  // Obtém o elemento <a> pelo seu ID
  var link1 = document.getElementById('m1-c');

  // Clica no link1
  link1.click();
});