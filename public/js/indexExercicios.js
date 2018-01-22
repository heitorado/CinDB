// PEGAR CADEIRAS
var cadeiraId;
var exercicios;
var selectedExercicio;
var solucao;

$(document).on('click','div[id^="exercicio-"]',function(){
      var exercicioId = $(this).attr('id').split('-')[1];

      for (var i = 0; i < exercicios.length; i++) {
            if (exercicios[i].idexercicios == exercicioId) {
                  selectedExercicio = exercicios[i];
                  break;
            }
      }
      carregarSolucao();
      exibirModalExercicio(selectedExercicio);
});

$(document).on('click','#btnSolucao',function(){
      exibirSolucao();
});

$.ajax({
      type : "POST",
      data:{buscarCadeiras : 1},
      url : "../Core/ExerciciosIndexControle.php",
      success: function (response) {
            cadeiras = $.parseJSON(response);

            $(cadeiras).each(function(e){
                  var li = $(document.createElement('li'));

                  var a = $(document.createElement('a'))
                  .attr('id', 'idCadeira-'+this.idcadeiras)
                  .attr('href', '#');

                  a.append(this.nome);
                  li.append(a);

                  $("ul#cadeiras").append(li);
            });
      }
});

$(document).on('click','a[id^="idCadeira"]',function(){
      $('#pagination').empty();

      cadeiraId = $(this).attr('id').split('-')[1];

      carregarTags(cadeiraId);
      carregarExercicio(cadeiraId, null);
});

$(document).on('click','input[id^="tags"]',function(){
      $('#pagination').empty();

      var tagId = "";

      $('input[id^="tags"]').each(function ()
      {
            if ($(this).is(':checked')) {
                  tagId += $(this).attr('value') + ',';
            }
      });

      tagId = tagId.substring(0, tagId.length-1);

      carregarExercicio(cadeiraId, tagId);
});


function carregarExercicio(cadeiraId, tagId) {
      $.ajax({
            type : "POST",
            data:{idCadeira : cadeiraId,
                  idTag : tagId},
                  url : "../Core/ExerciciosIndexControle.php",
                  success: function (response) {
                        $("#exercicios").empty();

                        exercicios = $.parseJSON(response);

                        if(exercicios.length > 0){
                              exibirExercicios(exercicios, exercicios.length);
                        } else{
                              exibirNenhumExercicio();
                        }
                  }
            });
      }

      function carregarTags(cadeiraId) {
            $.ajax({
                  type : "POST",
                  data:{idCadeiraTag : cadeiraId},
                  url : "../Core/ExerciciosIndexControle.php",
                  success: function (response) {
                        $("#tags").empty();
                        tags = $.parseJSON(response);
                        if(tags.length > 0){
                              exibirTags(tags);
                        } else{
                              exibirNenhumaTag();
                        }
                  }
            });
      }

      function exibirTags(tags) {
            for (var i = 0; i < tags.length; i++) {
                  var label = $(document.createElement('label'));
                  var input = $(document.createElement('input'))
                  .attr('type', 'checkbox')
                  .attr('value', tags[i].idtags)
                  .attr('id', 'tags-' + tags[i].idtags);

                  label.append(input);
                  label.append(tags[i].nome);
                  $('#tags').append(label, '<br>');
            }
      }

      function exibirNenhumaTag() {
            var div = $(document.createElement('div')).attr('class', 'welcome-message');
            var h2 = $(document.createElement('h3')).append("Sem resultado!");
            var p = $(document.createElement('p')).append("Nenhuma tag relacionada");
            $("#tags").append(div.append(h2,p));
      }

      function exibirNenhumExercicio() {
            var div = $(document.createElement('div')).attr('class', 'welcome-message');
            var h2 = $(document.createElement('h2')).append("Sem resultado!");
            var p = $(document.createElement('p')).append("Nenhum exercicios encontrado");
            $("#exercicios").append(div.append(h2,p));
      }

      function exibirExercicios(exercicios, cardLength){

            var pags = [];
            var numPages = Math.ceil(cardLength / 6);

            var pagination = $(document.createElement('ul')).attr( 'class', 'pagination');
            pagination.twbsPagination({
                  totalPages : numPages,
                  first : "Primeiro",
                  prev : '<span aria-hidden="true">&laquo;</span>',
                  next : '<span aria-hidden="true">&raquo;</span>',
                  last : "Último",
                  visiblePages : 4,
                  onPageClick : function(evt, page){
                        //window.history.pushState(null, 'page ' + page, page);
                        geraCards(page, exercicios, cardLength);
                  }
            });

            $("#pagination").append(pagination);
      }

      function geraCards(page, exercicios, cardLength){
            $('#exercicios').empty();
            var inicio = (page-1) * 6;
            var cards = carregaCards(exercicios, cardLength);

            for (var i = 0; i < 6; i++) {
                  $('#exercicios').append(cards[inicio+i]);
            }
      }

      function carregaCards(exercicios, cardLength){
            var cards = [];

            for(var i = 0; i < cardLength; i++)
            {
                  var texto = exercicios[i].enunciado;
                  var topicoTexto = exercicios[i].tags != "" ? "Topicos: " + exercicios[i].tags + "<br>" : "";
                  topicoTexto += "Cadeira: " + exercicios[i].cadeira + "<br>"
                  + "Professor: " + exercicios[i].professor

                  var card = $(document.createElement('div')).attr( 'class', 'exercise-card' )
                  .attr( 'id', 'exercicio-' + exercicios[i].idexercicios )
                  .attr('data-toggle', 'modal')
                  .attr( 'data-target', '#modalExercicio' );

                  var img = $(document.createElement('img')).attr('src',exercicios[i].image)
                  .attr('alt',exercicios[i].image)
                  .attr('title',exercicios[i].image);

                  var container = $(document.createElement('div')).attr('class', 'card-container');
                  var topico = $(document.createElement('h4')).append(topicoTexto);
                  var enun = $(document.createElement('p'))
                  .append(texto.substring(0, 145) + '...');

                  container.append(topico, enun);
                  card.append(img,container);
                  cards.push(card);
            }
            return cards;
      }

      function exibirModalExercicio(selectedExercicio) {
            $(".modal-header > .modal-title").empty().append('Exercicio relacionado a cadeira: ' + selectedExercicio.cadeira);

            $(".modalExercicioImg > img").attr('src', ''+ selectedExercicio.image)
            .attr('alt', selectedExercicio.image)
            .attr('title', selectedExercicio.image);

            $(".modal-body > #exercicioEnunciado").empty().append(selectedExercicio.enunciado);

            $(".modal-body > .exercicioFooter > #professor").empty().append(selectedExercicio.professor);
            $(".modal-body > .exercicioFooter > #exercicioTags").empty().append(selectedExercicio.tags);
            $(".modal-footer > .exercicioSolucao").hide();
      }

      function carregarSolucao() {
            solucao = null;
            $.ajax({
                  type : "POST",
                  data:{idexercicioSolucao : selectedExercicio.idexercicios},
                  url : "../Core/ExerciciosIndexControle.php",
                  success: function (response) {
                        solucao = $.parseJSON(response);
                        solucao = solucao[0];
                        if (solucao) {
                              var btnSolucao = $(document.createElement('button'))
                              .attr('class', 'btn btn-primary')
                              .attr('id', 'btnSolucao')
                              .append("Solução");
                              $(".modal-footer > .btnExercicio").empty().append(btnSolucao);
                        }else {
                              $(".modal-footer > .btnExercicio").empty();
                        }
                  }
            });
      }

      function exibirSolucao() {
            if (solucao.image != null || solucao.image != "") {
                  var img = $(document.createElement('img'));
                  img.attr('src', solucao.image)
                  .attr('alt',solucao.image)
                  .attr('title', solucao.image);

                  $(".modal-footer > .exercicioSolucao > #solucaoImg").empty().append(img);
            }
            $(".modal-footer > .exercicioSolucao > #solucaoText").empty().append(solucao.texto);

            $(".modal-footer > .exercicioSolucao").toggle("slow");
      }
