<div class="modal fade" id="personaCrearModal" tabindex="-1" aria-labelledby="personaCrearModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="personaCrearModalLabel">Crear Persona</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="personaCrearForm" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
          <label for="nombre" class="lead">Nombre:</label>
          <input type="text" class="form-control mb-2" name="nombre" placeholder="Ingrese un nombre">

          <label for="apellido" class="lead">Apellido:</label>
          <input type="text" class="form-control mb-2" name="apellido" placeholder="Ingrese un apellido">
          
          <label for="cedula" class="lead">cedula:</label>
          <input type="text" class="form-control mb-2" name="cedula" placeholder="Ingrese un nro de cedula">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" form="personaCrearForm">Guardar</button>
      </div>
    </div>
  </div>
</div>