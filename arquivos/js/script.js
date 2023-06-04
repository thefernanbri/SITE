document.addEventListener("DOMContentLoaded", function() {
  var modalBtn = document.querySelector(".modal__btn");
  var modalText = document.querySelector(".modal__text");
  var modalTitle = document.querySelector(".modal__title");
  var qrImage = document.querySelector(".QR");
  var modal = document.querySelector(".modal");
  var volta1Btn = document.getElementById("volta-1");

  modalBtn.addEventListener("click", function() {
    // Alterar o texto do botão
    modalBtn.textContent = "Baixando...";
    modalText.textContent = "Se o seu download não começar automaticamente, clique no botão abaixo ou scaneie o QR acima:";
    modalTitle.textContent = "Cartão de Visitas";

    // Alterar a imagem
    qrImage.src = "./images/QR.png";
    qrImage.alt = "Nova descrição da imagem";
    qrImage.width = 300;
    qrImage.height = 389;

    // Fazer o download do arquivo .vcf
    var link = document.createElement("a");
    link.href = "arquivos/fernando.vcf";
    link.download = "fernando.vcf";
    link.click();

    // Restaurar o texto do botão após um breve intervalo
    setTimeout(function() {
      modalBtn.textContent = "Baixar";
    }, 2000);
  });
});
