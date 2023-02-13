<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MVC - Personas</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<?php 
		include(dirname(__DIR__).'/controllers/personaController.php');
		if($_SERVER['REQUEST_METHOD'] == 'POST'){ $rs=crearPersona($_REQUEST);}
		if($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['_method'])){
			if($_GET['_method'] == "delete" || $_GET['_method'] == "delete"){
				$rs=eliminarPersona($_REQUEST);
			}
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
				<div class="row mb-3 justify-content-between align-items-center">
					<div class="col-auto">
						<h1>Personas</h1>
					</div>
					<div class="col-auto">
                        <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#personaCrearModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
						</button>
                    </div>
				</div>
				<div class="row">
					<div class="col-12">
						<table border="1" class="table">
							<thead>
								<tr>
									<th>nombre</th>
									<th>apellido</th>
									<th>cedula</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								<?php if(!isset($_GET['nombre'])):?>
									<?php foreach (listarPersonas() as $persona):?>
										<tr>
											<td><?php echo $persona['nombre']; ?></td>
											<td><?php echo $persona['apellido']; ?></td>
											<td><?php echo $persona['cedula']; ?></td>
											<td>
												<a href="personasModificaView.php?id=<?php echo $persona['id']?>" class="text-decoration-none">
													<button class="btn btn-info">
														<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-pencil-fill" viewBox="0 0 16 16">
															<path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
														</svg>
													</button>
												</a>
												<form action="<?php echo $_SERVER['PHP_SELF']?>" method="DELETE" class="d-inline">
													<input name="_method" type="hidden" value="delete" />
													<input type="hidden" name="id" value="<?php echo $persona['id']?>">
													<button type="submit" class="btn btn-danger">
														<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-bucket-fill" viewBox="0 0 16 16">
															<path d="M2.522 5H2a.5.5 0 0 0-.494.574l1.372 9.149A1.5 1.5 0 0 0 4.36 16h7.278a1.5 1.5 0 0 0 1.483-1.277l1.373-9.149A.5.5 0 0 0 14 5h-.522A5.5 5.5 0 0 0 2.522 5zm1.005 0a4.5 4.5 0 0 1 8.945 0H3.527z"/>
														</svg>
													</button>
												</form>												
											</td>
										</tr>
									<?php endforeach;?>
								<?php endif;?>

								<?php if(isset($_GET['nombre'])): $rs=BusquedaPersona($_GET['nombre']);?>
									<?php if(count($rs) != 0): ?>
											<?php foreach ($rs as $persona): ?>
												<tr>
													<td><?php echo $persona['nombre']; ?></td>
													<td><?php echo $persona['apellido']; ?></td>
													<td><?php echo $persona['cedula']; ?></td>
													<td>
														<a href="personasModificaView.php?id=<?php echo $persona['id']?>" class="text-decoration-none">
															<button class="btn btn-info">
																<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-pencil-fill" viewBox="0 0 16 16">
																	<path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
																</svg>
															</button>
														</a>
														<a href="#" class="text-decoration-none">
															<button class="btn btn-danger">
																<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-bucket-fill" viewBox="0 0 16 16">
																	<path d="M2.522 5H2a.5.5 0 0 0-.494.574l1.372 9.149A1.5 1.5 0 0 0 4.36 16h7.278a1.5 1.5 0 0 0 1.483-1.277l1.373-9.149A.5.5 0 0 0 14 5h-.522A5.5 5.5 0 0 0 2.522 5zm1.005 0a4.5 4.5 0 0 1 8.945 0H3.527z"/>
																</svg>
															</button>
														</a>
													</td>
												</tr>
											<?php endforeach;?>
										<?php else: ?>	
												<tr>
													<td colspan="4">
														<div class="alert alert-primary" role="alert">
														 No se encontraron resultados
														</div>
													</td>
												</tr>
									<?php endif;?>
								<?php endif;?>
							</tbody>
						</table>
					</div>
				</div>
				<?php if($_SERVER['REQUEST_METHOD'] == 'POST'):?>
					<?php if($rs['error']==false):?>
						<div class="row">
							<div class="col">
								<div class="alert alert-success" role="alert">
									¡Registro Creado Exitosamente!
								</div>
							</div>
						</div>
					<?php endif;?>
				<?php endif;?>
				<?php if(isset($_GET['_method']) AND $_GET['_method'] == 'delete'):?>
					<?php if($rs['error']==false):?>
						<div class="row">
							<div class="col">
								<div class="alert alert-success" role="alert">
									¡Registro eliminado Exitosamente!
								</div>
							</div>
						</div>
					<?php endif;?>
				<?php endif;?>
			</div>
		</div>
	</main>
<?php require('layouts/partials/personaCrearModal.php')?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>