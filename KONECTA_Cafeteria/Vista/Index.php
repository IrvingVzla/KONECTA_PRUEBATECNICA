<!DOCTYPE html>
<html>
<head>
    <title>Administrador de Productos</title>
</head>
<body>

<script>
    window.addEventListener('load', function () {
        const filtroButton = document.querySelector('input[type="submit"][value="Filtrar"]');
        if (filtroButton && !sessionStorage.getItem('filtroButtonClicked')) {
            filtroButton.click();
            sessionStorage.setItem('filtroButtonClicked', 'true');
        }
    });
</script>


<?php
include_once("../AccesoDatos/ConexionBD.php");
$conn = Conexion::ConexionPostgres();

// Procesar la creación de un nuevo producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['crear_producto'])) {
        $nombre = $_POST["nombre"];
        $referencia = $_POST["referencia"];
        $precio = $_POST["precio"];
        $peso = $_POST["peso"];
        $categoria = $_POST["categoria"];
        $stock = $_POST["stock"];

        // Validar y procesar la inserción en la base de datos
        $query = 'INSERT INTO public."Productos" ("NombreProducto", "Referencia", "Precio", "Peso", "Categoria", "Stock", "FechaCreacion") 
                  VALUES (:nombre, :referencia, :precio, :peso, :categoria, :stock, NOW())';

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':referencia', $referencia, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);
        $stmt->bindParam(':peso', $peso, PDO::PARAM_INT);
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Producto creado con éxito.";
        } else {
            echo "Error al crear el producto: " . $stmt->errorInfo()[2];
        }
    } elseif (isset($_POST['editar_producto'])) {
        $producto_id = $_POST["producto_id"];
        $nombre = $_POST["nombre"];
        $referencia = $_POST["referencia"];
        $precio = $_POST["precio"];
        $peso = $_POST["peso"];
        $categoria = $_POST["categoria"];
        $stock = $_POST["stock"];

        // Validar y procesar la actualización en la base de datos
        $query = 'UPDATE public."Productos" 
                  SET "NombreProducto" = :nombre, 
                      "Referencia" = :referencia, 
                      "Precio" = :precio, 
                      "Peso" = :peso, 
                      "Categoria" = :categoria, 
                      "Stock" = :stock 
                  WHERE "ID" = :id';

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':referencia', $referencia, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);
        $stmt->bindParam(':peso', $peso, PDO::PARAM_INT);
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Producto actualizado con éxito.";
        } else {
            echo "Error al actualizar el producto: " . $stmt->errorInfo()[2];
        }
    }
}

// Procesar la eliminación de un producto
if (isset($_GET['eliminar_producto'])) {
    $producto_id = $_GET['eliminar_producto'];
    
    // Validar y procesar la eliminación en la base de datos
    $query = 'DELETE FROM public."Productos" WHERE "ID" = :id';
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $producto_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "Producto eliminado con éxito.";
    } else {
        echo "Error al eliminar el producto: " . $stmt->errorInfo()[2];
    }
}

// Obtener la lista de categorías disponibles
$queryCategorias = 'SELECT DISTINCT "Categoria" FROM public."Productos"';
$categoriasResult = $conn->query($queryCategorias);

// Mostrar el menú desplegable de categorías
echo "<form method='GET' action=''>";
echo "<label for='categoria'>Filtrar por Categoría: </label>";
echo "<select name='categoria' id='categoria'>";
echo "<option value=''>Todas</option>"; // Opción para mostrar todos los productos
while ($categoria = $categoriasResult->fetch(PDO::FETCH_ASSOC)) {
    $categoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : '';
    $selected = ($categoriaSeleccionada === $categoria['Categoria']) ? 'selected' : '';
    echo "<option value='" . $categoria['Categoria'] . "' $selected>" . $categoria['Categoria'] . "</option>";
}
echo "</select>";
echo " ";
echo "<input type='submit' value='Filtrar'>";
echo "</form>";

// Procesar la selección de categoría y mostrar los productos filtrados
if (isset($_GET['categoria'])) {
    $categoriaSeleccionada = $_GET['categoria'];
    // Construir la consulta SQL para seleccionar productos por categoría
    $query = 'SELECT * FROM public."Productos"';
    if (!empty($categoriaSeleccionada)) {
        $query .= ' WHERE "Categoria" = :categoria';
    }
    $query .= ' ORDER BY "ID" ASC';

    // Ejecutar la consulta
    $stmt = $conn->prepare($query);
    if (!empty($categoriaSeleccionada)) {
        $stmt->bindParam(':categoria', $categoriaSeleccionada, PDO::PARAM_STR);
    }
    $stmt->execute();

    echo "<h1>Lista de Productos</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre Producto</th><th>Referencia</th><th>Precio</th><th>Peso</th>
    <th>Categoria</th><th>Stock</th><th>Fecha Creacion</th><th>Acciones</th></tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['ID'] . "</td>";
        echo "<td>" . $row['NombreProducto'] . "</td>";
        echo "<td>" . $row['Referencia'] . "</td>";
        echo "<td>" . $row['Precio'] . "</td>";
        echo "<td>" . $row['Peso'] . "</td>";
        echo "<td>" . $row['Categoria'] . "</td>";
        echo "<td>" . $row['Stock'] . "</td>";
        echo "<td>" . $row['FechaCreacion'] . "</td>";
        echo "<td><a href='?editar_producto=" . $row['ID'] . "'>Editar</a> | <a href='?eliminar_producto=" . $row['ID'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }

    echo "</table>";
}
?>

<h1>Crear Nuevo Producto</h1>

<form method="POST" action="">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="text" name="referencia" placeholder="Referencia" required><br>
    <input type="number" name="precio" placeholder="Precio" required><br>
    <input type="number" name="peso" placeholder="Peso" required><br>
    <input type="text" name="categoria" placeholder="Categoría" required><br>
    <input type="number" name="stock" placeholder="Stock" required><br><br>
    <input type="submit" name="crear_producto" value="Crear Producto">
</form>
<?php

// Formulario de edición (se muestra si se hace clic en Editar)
if (isset($_GET['editar_producto'])) {
    $producto_id = $_GET['editar_producto'];
    
    // Recuperar los datos del producto a editar
    $query = 'SELECT * FROM public."Productos" WHERE "ID" = :id';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $producto_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($producto) {
            // Mostrar el formulario de edición con los datos existentes
            echo "<h1>Editar Producto</h1>";
            echo "<form method='POST' action=''>";
            echo "<input type='hidden' name='producto_id' value='" . $producto['ID'] . "'>";
            echo "<input type='text' name='nombre' value='" . $producto['NombreProducto'] . "' placeholder='Nombre' required><br>";
            echo "<input type='text' name='referencia' value='" . $producto['Referencia'] . "' placeholder='Referencia' required><br>";
            echo "<input type='number' name='precio' value='" . $producto['Precio'] . "' placeholder='Precio' required><br>";
            echo "<input type='number' name='peso' value='" . $producto['Peso'] . "' placeholder='Peso' required><br>";
            echo "<input type='text' name='categoria' value='" . $producto['Categoria'] . "' placeholder='Categoría' required><br>";
            echo "<input type='number' name='stock' value='" . $producto['Stock'] . "' placeholder='Stock' required><br>";
            echo "<input type='submit' name='editar_producto' value='Guardar Cambios'>";
            echo "</form>";
        } else {
            echo "Producto no encontrado.";
        }
    } else {
        echo "Error al obtener el producto para editar: " . $stmt->errorInfo()[2];
    }
}
?>


<h1>Realizar Venta</h1>
<form method="POST" action="">
    <input type="number" name="producto_id" placeholder="ID del Producto" required><br>
    <input type="number" name="cantidad" placeholder="Cantidad Vendida" required><br><br>   
    <input type="submit" name="realizar_venta" value="Realizar Venta"><br>
</form>

<?php
if (isset($_POST['realizar_venta'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad_vendida = $_POST['cantidad'];

    // Obtener información del producto
    $queryProducto = 'SELECT "NombreProducto", "Stock" FROM public."Productos" WHERE "ID" = :id';
    $stmtProducto = $conn->prepare($queryProducto);
    $stmtProducto->bindParam(':id', $producto_id, PDO::PARAM_INT);
    $stmtProducto->execute();
    $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        echo "Producto no encontrado.";
    } else {
        $stock_actual = $producto['Stock'];

        // Verificar si hay suficiente stock para la venta
        if ($stock_actual >= $cantidad_vendida) {
            // Actualizar el stock del producto
            $nuevo_stock = $stock_actual - $cantidad_vendida;
            $queryActualizarStock = 'UPDATE public."Productos" SET "Stock" = :nuevo_stock WHERE "ID" = :id';
            $stmtActualizarStock = $conn->prepare($queryActualizarStock);
            $stmtActualizarStock->bindParam(':nuevo_stock', $nuevo_stock, PDO::PARAM_INT);
            $stmtActualizarStock->bindParam(':id', $producto_id, PDO::PARAM_INT);

            // Registrar la venta en la tabla VentasProductos
            $nombre_producto = $producto['NombreProducto'];
            $fecha_venta = date("Y-m-d H:i:s"); // Obtener la fecha actual

            $queryRegistrarVenta = 'INSERT INTO public."VentasProductos" ("NombreProducto", "Cantidad", "FechaVenta") 
                                    VALUES (:nombre_producto, :cantidad_vendida, :fecha_venta)';
            $stmtRegistrarVenta = $conn->prepare($queryRegistrarVenta);
            $stmtRegistrarVenta->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
            $stmtRegistrarVenta->bindParam(':cantidad_vendida', $cantidad_vendida, PDO::PARAM_INT);
            $stmtRegistrarVenta->bindParam(':fecha_venta', $fecha_venta, PDO::PARAM_STR);

            if ($stmtActualizarStock->execute() && $stmtRegistrarVenta->execute()) {
                echo " ";
                echo "Venta realizada con éxito. Nuevo stock: ". $nuevo_stock;
            } else {
                echo "Error al actualizar el stock o registrar la venta.";
            }
        } else {
            echo "No hay suficiente stock para realizar la venta.";
        }
    }
}
?>

</body>
</html>