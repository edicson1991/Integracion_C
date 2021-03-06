<?php
// Conexión con el archivo config
require_once "config.php";
 
// Definir variables
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Procesar datos del formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validar nombre
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor ingrese el nombre del empleado.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Por favor ingrese un nombre válido.";
    } else{
        $name = $input_name;
    }
    
    // Validar dirección
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Por favor ingrese una dirección.";     
    } else{
        $address = $input_address;
    }
    
    // Validar salario
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Por favor ingrese el monto del salario del empleado.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Por favor ingrese un valor correcto y positivo.";
    } else{
        $salary = $input_salary;
    }
    
    // Verificar errores antes de guardar en la BD
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare una declaración de inserción
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // vincular las variables
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            
            // establecer parametros
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Intentar ejecutar la declaración preparada
            if(mysqli_stmt_execute($stmt)){
                // Los registros se crearon exitosamente. Redirige al index
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    }
    
    // Cerrar la conexión
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Empleado</title>
    <link rel="icon" type="image/jpg" href="img/favicon.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Inicio<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Contenido HTML/acercadelproyecto.html">Acerca del proyecto</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Contenido HTML/Autoresproyecto.html">Autores del proyecto</a>
      </li>

    </ul>
  </div>
</nav>
</BR></BR></BR>
<div class="container">


<div class="card">
  <div class="card-header">
    Proyecto Integracion Continua, Politecnico Gran colombiano
  </div>
  <div class="card-body">
    <h5 class="card-title">Bienvenidos a Todos!</h5>
    <p class="card-text">Este es nuestro proyecto para aplicar la integracion continua</p></br>
    <p class="card-text">En esta seccion usted podra hacer la creacion de un empleado </p>
</div>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/poli.png" class="d-block w-100" width="300px" height="400px">
    </div>
    <div class="carousel-item">
      <img src="img/jenkins.png" class="d-block w-100" width="300px" height="450px">
    </div>
    <div class="carousel-item">
      <img src="img/bootstrap.png" class="d-block w-100" width="300px" height="400px">
    </div>
    <div class="carousel-item">
      <img src="img/php.png" class="d-block w-100" width="300px" height="400px">
    </div>
    <div class="carousel-item">
      <img src="img/sql.png" class="d-block w-100" width="300px" height="400px">
    </div>
    <div class="carousel-item">
      <img src="img/html.JPG" class="d-block w-100" width="300px" height="400px">
    </div>
    <div class="carousel-item">
      <img src="img/jquery.png" class="d-block w-100" width="300px" height="400px">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Agregar Empleado</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario, para agregar el empleado.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Dirección</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Sueldo</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    <br/><br/><br/>
</body>
</html>
