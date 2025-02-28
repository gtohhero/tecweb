<!DOCTYPE html >
<html>
  <head>
    <meta charset="utf-8" >
    <title>Registro al Concurso</title>
    <style type="text/css">
      ol, ul { 
      list-style-type: none;
      }
    </style>
  </head>

  <body>
    <h1>Actualización de libro en &ldquo;marketzone&rdquo;</h1>

    <p>¿Quieres actualizar un libro a la base de datos?<p>

    <form id="formularioProduct" onsubmit="" method="post">

      <fieldset>
        <legend>Información del libro</legend>

        <ul>
          <li><label for="form-name">Nombre:</label><br><input type="text" name="name" id="form-name" placeholder="Hasta 100 caracteres" value="<?=!empty($_POST['nombre'])?$_POST['nombre']:$_GET['nombre'] ?>"></li><br>
          
          <li><label for="form-brand">Marca:</label><br><select name="brand" id="form-brand">
            <option selected disabled>Seleccionar</option>
            <option>Pluma Eterna</option>
            <option>Luz & Tinta</option>
            <option>Vórtice Literario</option>
            <option>Alas de Papel</option>
            <option>Sombras & Destello</option>
          </select></li><br>
          
          <li><label for="form-model">Modelo:</label><br><input type="text" name="model" id="form-model" placeholder="Hasta 25 caracteres" value="<?= !empty($_POST['modelo'])?$_POST['modelo']:$_GET['modelo'] ?>"></li><br>
          
          <li><label for="form-price">Precio:</label><br><input type="number" name="price" id="form-price" step="0.01" value="<?= !empty($_POST['precio'])?$_POST['precio']:$_GET['precio'] ?>"></li><br>
          
          <li><label for="form-quantity">Unidades:</label><br><input type="number" name="quantity" id="form-quantity" value="<?= !empty($_POST['unidades'])?$_POST['unidades']:$_GET['unidades'] ?>"></li><br>
          
          <li><label for="form-details">Detalles:</label><br><textarea name="details" rows="4" cols="50" id="form-details" placeholder="Hasta 250 caracteres"><?= !empty($_POST['detalles'])?$_POST['detalles']:$_GET['detalles'] ?></textarea></li><br>
          
          <li><label for="form-img">Nombre del archivo de imagen:</label><br><input type="text" name="img" id="img" value="<?= !empty($_POST['imagen'])?$_POST['imagen']:$_GET['imagen'] ?>"></li>
        </ul>
      </fieldset>

      <p>
        <input type="submit" value="¡Enviar libro!">
        <input type="reset">
      </p>

    </form>
    <script>
      let form = document.getElementById("formularioProduct");
      
      form.addEventListener("submit", function(event) {
        let nombre = document.getElementById("form-name").value;
        let marca = document.getElementById("form-brand").value;
        let modelo = document.getElementById("form-model").value;
        let precio = document.getElementById("form-price").value;
        let unidad = document.getElementById("form-quantity").value;
        let detalle = document.getElementById("form-details").value;
        let imagen = document.getElementById("img").value;

        if (nombre.trim() === "" || nombre.length > 100) {
          event.preventDefault();
          alert("Error: Nombre supera el límite de caracteres o es vacío.");
        }

        if (marca == "Seleccionar") {
          event.preventDefault();
          alert("Error: No se seleccionó una marca de las proporcionadas.");
        }

        if (modelo.trim() === "" || modelo.length > 25 || !/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚüÜñÑ-]+$/.test(modelo)) { // esta última condición solo acepta: letras, números, espacios, guiones, acentos y la ñ.
          event.preventDefault();
          alert("Error: Modelo supera el límite de caracteres, es vacío o no es un texto alfanumérico.");
        }

        if(precio.trim() === "" || parseFloat(precio) <= 99.99) {
          event.preventDefault();
          alert("Error: Precio es vacío o no supera los 99.99 en valor");
        }

        if(detalle.trim() !== "") {
          if(detalle.length > 250) {
            event.preventDefault();
            alert("Error: Los detalles superan el límite permitido de caracteres.");
          }
        }
        
        if(unidad.trim() === "" || Number(unidad) < 0) {
          event.preventDefault();
          alert("Error: Cantidad es vacía o es menor a 0");
        }
        
        if(imagen.trim() === "") {
          imagen = "imagen1";
          document.getElementById("img").value =  imagen;
        }
      });
    </script>
  </body>
</html>