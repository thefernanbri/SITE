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

function telefone() {
  if (getMobileOS() == "Android") {
    window.location.href = "tel:045991164631";
  }
  if (getMobileOS() == "iOS") {
    window.location.href = "tel:045991164631";
  }
  if (!getMobileOS()) {
	window.location.href = "#m3-o";
	window.location.href = "tel:045991164631";
  }
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

// Obtém o elemento <li> pelo seu ID
var qrCodeListItem = document.getElementById('qr-code');

// Adiciona um evento de clique ao elemento <li>
qrCodeListItem.addEventListener('click', function() {
  // Obtém o elemento <a> pelo seu ID
  var link1 = document.getElementById('m2-c');

  // Clica no link1
  link1.click();

  // Altera o CSS do elemento <li> com ID "qr-code"
  qrCodeListItem.style.position = 'relative';
});

// Obtém o elemento <a> com classe "link-2"
var link2 = document.querySelector('a.link-2');

// Adiciona um evento de clique ao link2
link2.addEventListener('click', function() {
  // Obtém novamente o elemento <li> pelo seu ID
  var qrCodeListItem = document.getElementById('qr-code');

  // Altera o CSS do elemento <li> com ID "qr-code" para "inherit"
  qrCodeListItem.style.position = 'inherit';
});


// FUNÇÃO MODAL QR CODE SITE //

// Obtém o elemento <p> pelo seu ID
var qrCodeParagraph = document.getElementById('qr-code-site');
// Adiciona um evento de clique ao elemento <p>
qrCodeParagraph.addEventListener('click', function() {
  // Obtém o elemento <a> pelo seu ID
  var link1 = document.getElementById('m1-c');

  // Clica no link1
  link1.click();
});

// FUNÇÃO ANO FOOTER //
document.getElementById('current-year').innerText = new Date().getFullYear();

// Função para carregar a imagem quando o botão for clicado
function carregarImagem(btnId, imgId) {
    var btn = document.getElementById(btnId);
    var img = document.querySelector(imgId);
    var carregada = false; // Variável para rastrear se a imagem já foi carregada

    // Adicionar evento de clique ao botão
    btn.addEventListener('click', function() {
        // Verificar se a imagem já foi carregada
        if (!carregada) {
            // Obter o valor do atributo data-src
            var src = img.getAttribute('data-src');

            // Alterar o atributo src da imagem para iniciar o carregamento
            img.setAttribute('src', src);

            // Definir a variável carregada como true para indicar que a imagem foi carregada
            carregada = true;
        }
    });
}

// Chamar a função para cada par de botão e imagem
carregarImagem('telefone', '#m3-o img');
carregarImagem('qr-code', '#m2-o img');
carregarImagem('qr-code-site', '#m1-o img');
