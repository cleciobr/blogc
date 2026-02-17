
    // Animations initialization
    new WOW().init();

    $(document).ready( function () {
      $('#tabelaRamais').DataTable({

        "language": {
                    "lengthMenu": "",
                    "zeroRecords": "Ramal ou Setor não encontrado",
                    "info": "Exibindo página _PAGE_ de _PAGES_",
                    "infoEmpty": "-",
                    "infoFiltered": "",
                    "search": "Pesquisar",
                    "paginate": {
                        "next": "Próximo",
                        "previous": "Anterior",
                        "first": "Primeiro",
                        "last": "Último"
                    }

                 }

      });

      $(".owl-carousel").owlCarousel({

        items:2,
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true

      });

      $(".project").hover3d({
        selector: ".project__card"
      });

      $("#myModal").modal("show");
      $("#btn-close").click(function () {
          $("#myModal").modal("hide");
          $('#0').modal("show");
      });
      
      $("#top").removeAttr("style");
      $("#btn-0").click(function () {
        $("#0").modal("hide");
        $('#1').modal("show");
      });

      $("#top").removeAttr("style");
 
      $("#btn-1").click(function () {
        $('#1').modal("hide");
	$('#2').modal("show");
      });
      $("#top").removeAttr("style");

      $("#btn-2").click(function() {
	$('#2').modal("hide");
	$('#top').removeAttr("style");
      });

    });


     $(document).on('click', '[data-toggle="lightbox"]', function(event) {
         event.preventDefault();
         $(this).ekkoLightbox();
     });
