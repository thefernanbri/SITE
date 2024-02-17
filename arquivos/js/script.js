document.addEventListener("DOMContentLoaded", function() {
  var modalBtn = document.querySelector(".modal__btn");
  var modalText = document.querySelectorAll(".modal__text")[2];
  var qrImage = document.querySelector(".QR");
  var modal = document.querySelector(".modal");
  var volta1Btn = document.getElementById("volta-1");

  modalBtn.addEventListener("click", function() {
    // Alterar o texto do botão
    modalBtn.textContent = "Baixando...";
    modalText.textContent = "Se o seu download não começar automaticamente, clique no botão abaixo ou scaneie o QR acima:";

    // Alterar a imagem
    qrImage.src = "./images/QR.png";
    qrImage.width = 300;
    qrImage.height = 300;

    // Fazer o download do arquivo .vcf
    var link = document.createElement("a");
    link.href = "arquivos/fernando.vcf";
    link.download = "fernando.vcf";
    link.click();

    // Restaurar o texto do botão após um breve intervalo
    setTimeout(function() {
      modalBtn.innerHTML = '<i class="fas fa-floppy-disk"></i> Salvar';
    }, 2000);
  });
});
