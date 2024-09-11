<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/modificar.css">
<div class="container">
    <div class="row">
        <div class="col-12 text-right pt-4 pb-4">
            <a href="" class="btn btn-custom btn-back"><i class="fas fa-arrow-left"></i> Regresar</a>
        </div>
    </div>
    <!-- Contenido principal aquí -->
</div>

<script type="text/javascript">
    let btn_back = document.querySelector(".btn-back");

    btn_back.addEventListener('click', function(e){
        e.preventDefault();
        window.history.back();
    });
</script>
