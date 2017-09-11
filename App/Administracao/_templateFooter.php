</div>
</div>
</div>
<script src="[@path]/public/js/jquery.min.js"></script>
<script type="text/javascript" src="[@path]/public/js/bootstrap.min.js"></script>
<script type="text/javascript">
      // PEGA O PAGINA ATUAL
      var page = document.location.pathname;
      page = page.split("/");
      page = page[page.length-1];
      //alert(page);

      // COLOCA A CLASSE active PARA O ELEMENTO QUE REDIRECIONA PARA ESTA PAGINA
      $("#sidebarList").find('a').each(function(e){
            if (page == $(this).attr('href')) {
                  //console.log($(this).attr('href'));
                  $(this).parent().addClass("active");
                  return;
            }
      });

      $("#navbarList").find('a').each(function(e){
            if (page == $(this).attr('href')) {
                  //console.log($(this).attr('href'));
                  $(this).parent().addClass("active");
                  return;
            }
      });
</script>
</body>
</html>
