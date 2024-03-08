let perfilDropdownList = document.querySelector(".perfil-dropdown-list");
let btn = document.querySelector(".perfil-dropdown-btn");

const toggle = ()=> perfilDropdownList.classList.toggle("active");

window.addEventListener('clicker',function(e){
    if(!btn.contains(e.target))perfilDropdownList.classList.remove("active");
})


// Obtém o botão e o modal
var openModalBtn = document.getElementById("openModalBtn");
var modal = document.getElementById("myModal");

// Obtém o elemento de fechar o modal
var closeBtn = document.getElementsByClassName("close")[0];

// Abre o modal quando o botão é clicado
openModalBtn.addEventListener("click", function() {
    modal.style.display = "block";
});

// Fecha o modal quando o botão de fechar é clicado
closeBtn.addEventListener("click", function() {
    modal.style.display = "none";
});

// Fecha o modal quando o usuário clica fora da área do modal
window.addEventListener("click", function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
});

var closeButton = document.querySelector('.close');
var modalo = document.querySelector('.form-editar-inteiro');

closeButton.addEventListener('click', function() {
    modalo.style.display = 'none';
    alert('Ops! parece que você fechou o formulário de edição, Tente Novamente');
    window.location.href = '../index.php';
});

window.addEventListener("click", function(event) {
    if (event.target == modalo) {
        modalo.style.display = "none";
        alert('Ops! parece que você fechou o formulário de edição, Tente Novamente');
        window.location.href = '../index.php';
    }
});