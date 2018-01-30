function rota() {
    var path = window.location.pathname; // Pega a url atual
    var keyPage; // variavel para a chave da pagina que sera carregada
    var page; // variavel da pagina que sera carregada
    var linkId; // id do link que vai receber classe 'active'

    path = path.split("/");
    if (path.length != 4) {
        return;
    }

    keyPage = path[3];

    switch (keyPage) {
        case "index":
            page = 'admin_dashboard_default.html';
            linkId = "#indexLink";
            break;

        case "exercicios":
            page = 'admin_cadastro_exercicio.html';
            linkId = "#exercicioLink";
            break;
        case "adicionarExercicio":
            page = 'form_exercicios.html';
            linkId = "#exercicioLink";
            break;

        case "cadeiras":
            page = 'admin_cadastro_cadeiras.html';
            linkId = "#cadeiraLink";
            break;
        case "adicionarCadeira":
            page = 'form_cadeiras.html';
            linkId = "#cadeiraLink";
            break;

        case "professores":
            page = 'admin_cadastro_professores.html';
            linkId = "#professorLink";
            break;
        case "adicionarProfessor":
            page = 'form_professores.html';
            linkId = "#professorLink";
            break;

        case "tags":
            page = 'admin_cadastro_tags.html';
            linkId = "#tagLink";
            break;

        default:
            $("#main_content").html("Conteudo não encontrado!");
            $('nav a.nav-link.content-changer.active').removeClass('active');
            return;
    }

    $('#main_content').load('/CinDB/app/admin/' + page);

    // PERMITE INDICAR QUAL LINK ESTA ATIVO
    $('nav a.nav-link.content-changer.active').removeClass('active');
    $(linkId).addClass('active');
}

// events

// Evento de de transição de paginas
$(document).on('click', '.content-changer', function (event) {
    var url;
    
    event.preventDefault();

    url = $(this).attr('href');

    window.history.pushState({ urlPath: url }, '', url);
    rota();
});

// Permite recarregar a rota quando alterada pelo navegador
window.onpopstate = function (event) {
    rota();
};

rota();