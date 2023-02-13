<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MVC - Modifica</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<?php 
		include(dirname(__DIR__).'/controllers/personaController.php');
        $id=isset($_GET['id']) ? $_GET['id']: $_POST['id'];
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $rs=actualizarPersona($_REQUEST);
        }       
	?>
</head>
<body>
	<!--navegación--> 
	<?php include('layouts/navegacion.php')?>
	<!--navegación-->
	<main class="container">
		<div class="row">
			<div class="col">
				<div class="row mb-3">
					<div class="col">
						<h1>Personas</h1>
					</div>
				</div>
				<div class="row">
                        <table border="1" class="table mb-3">
							<thead>
								<tr>
									<th>nombre</th>
									<th>apellido</th>
									<th>cedula</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
                                   <?php $rs=MostrarPersona($id); if(count($rs) !=0):  ?>
                                        <?php foreach ($rs as $persona):?>
                                            <form action="<?php echo  $_SERVER['PHP_SELF'];?>" method="POST" class="d-inline">
                                                <tr>
                                                    <td><input type="text" name="nombre" class="form-control" value="<?php echo $persona['nombre']; ?>"></td>
                                                    <td><input type="text" name="apellido" class="form-control" value="<?php echo $persona['apellido']; ?>"></td>
                                                    <td><input type="text" name="cedula" class="form-control" value="<?php echo $persona['cedula']; ?>"></td>
                                                    <td>
                                                        <input type="hidden" name="id" value="<?php echo $persona['id']; ?>">
                                                        <button class="btn btn-success text-white">
                                                            GUARDAR
                                                        </button>
                                                       
                                                        <a href="personasView.php">
                                                            <button type="button" class="btn btn-info text-white">
                                                                VOLVER
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </form>
                                        <?php endforeach;?>
                                    <?php else:?> 
                                        <tr>
                                            <td colspan="3">
                                                <div class="alert alert-primary" role="alert">
                                                    No existen registros con ese ID
                                                </div>
                                            </td>
                                            <td>
                                                <a href="personasView.php">
                                                    <button class="btn btn-info text-white">
                                                        VOLVER
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif;?>
							</tbody>
						</table>
                        <?php if($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                            <div class="alert alert-success" role="alert">
                                ¡Registro modificado Exitosamente!, <a href="personasView.php">Regresar</a>
                            </div>
                        <?php endif;?>
                </div>
			</div>
		</div>
	</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>