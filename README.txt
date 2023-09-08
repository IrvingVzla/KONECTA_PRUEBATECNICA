Para la puesta en marcha del proyecto por favor tener todas las instalaciones en VSCODE y realizar toda la configuración de la base de datos.

En el archivo ConexionBD.php debe configurar la conexion con los datos de su equipo

        $host = "localhost"; // El servidor de PostgreSQL.
        $dbname = "KONECTA_Cafeteria"; // El nombre de tu base de datos.
        $username = "postgres"; // Tu nombre de usuario de PostgreSQL.
        $password = "digiturno"; // Tu contraseña de PostgreSQL.

NOTA: Se recomienda que en caso de no dejar restaurar usar la siguente linea de comandos. (Tener en cuenta que debe estar en la ruta donde se instalo el PostgreSQL ya que usa el archivo pg_restore).
En mi caso esta es la ruta: C:\Program Files\PostgreSQL\16rc1\bin

pg_restore --dbname=Basededatosparaaplicarcambios --username=NombredeUsuario --host=Hostdelabase --port=Puerto "Ruta del BACKUP"

