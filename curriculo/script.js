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

function whatsapp2() {
  if (getMobileOS() == "Android") {
    window.location.href = "whatsapp://send?phone=5545998438128&text=";
  }
  if (getMobileOS() == "iOS") {
    window.location.href = "whatsapp://send?phone=5545998438128&text=";
  }
  if (!getMobileOS()) {
    window.open("https://api.whatsapp.com/send?phone=5545998438128&text=");
  }
}

function mail() {
  location.href = 'mailto:contato@fernandobrito.adv.br';
}


function telefone() {
  if (getMobileOS() == "Android") {
    window.location.href = "tel:045991164631";
  }
  if (getMobileOS() == "iOS") {
    window.location.href = "tel:045991164631";
  }
  if (!getMobileOS()) {
	window.location.href = "tel:045998438128";
  }
}

function telefone2() {
  if (getMobileOS() == "Android") {
    window.location.href = "tel:045998438128";
  }
  if (getMobileOS() == "iOS") {
    window.location.href = "tel:045998438128";
  }
  if (!getMobileOS()) {
	window.location.href = "tel:045998438128";
  }
}