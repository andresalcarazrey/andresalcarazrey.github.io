<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "biblioteca.php";

$db = conectaDb();
cabecera("Añadir 2", MENU_VOLVER);

$nombre    = recoge("nombre");
$apellidos = recoge("apellidos");
$telefono  = recoge("telefono");

$nombreOk    = false;
$apellidosOk = false;
$telefonoOk  = false;

if (mb_strlen($nombre, "UTF-8") > $tamAgendaNombre) {
    print "    <p class=\"aviso\">El nombre no puede tener más de $tamAgendaNombre caracteres.</p>\n";
    print "\n";
} else {
    $nombreOk = true;
}

if (mb_strlen($apellidos, "UTF-8") > $tamAgendaApellidos) {
    print "    <p class=\"aviso\">Los apellidos no pueden tener más de $tamAgendaApellidos caracteres.</p>\n";
    print "\n";
} else {
    $apellidosOk = true;
}

if (mb_strlen($telefono, "UTF-8") > $tamAgendaTelefono) {
    print "    <p class=\"aviso\">El teléfono no puede tener más de $tamAgendaTelefono caracteres.</p>\n";
    print "\n";
} else {
    $telefonoOk = true;
}

if ($nombreOk && $apellidosOk && $telefonoOk) {
    if ($nombre == "" && $apellidos == "" && $telefono == "") {
        print "    <p class=\"aviso\">Hay que rellenar al menos uno de los campos. No se ha guardado el registro.</p>\n";
    } else {
        $consulta = "SELECT COUNT(*) FROM $tablaAgenda";
        $result   = $db->query($consulta);
        if (!$result) {
            print "    <p class=\"aviso\">Error en la consulta.</p>\n";
        } elseif ($result->fetchColumn() >= MAX_REG_TABLE_AGENDA) {
            print "    <p class=\"aviso\">Se ha alcanzado el número máximo de registros que se pueden guardar.</p>\n";
            print "\n";
            print "    <p class=\"aviso\">Por favor, borre algún registro antes.</p>\n";
        } else {
            $consulta = "SELECT COUNT(*) FROM $tablaAgenda
                WHERE nombre=:nombre
                AND apellidos=:apellidos
                AND telefono=:telefono";
            $result = $db->prepare($consulta);
            $result->execute([":nombre" => $nombre, ":apellidos" => $apellidos,
                ":telefono"             => $telefono, ]);
            if (!$result) {
                print "    <p class=\"aviso\">Error en la consulta.</p>\n";
            } elseif ($result->fetchColumn() > 0) {
                print "    <p class=\"aviso\">El registro ya existe.</p>\n";
            } else {
                $consulta = "INSERT INTO $tablaAgenda
                    (nombre, apellidos, telefono)
                    VALUES (:nombre, :apellidos, :telefono)";
                $result = $db->prepare($consulta);
                if ($result->execute([":nombre" => $nombre, ":apellidos" => $apellidos,
                    ":telefono" => $telefono, ])) {
                    print "    <p>Registro <strong>$nombre $apellidos $telefono</strong> creado correctamente.</p>\n";
                } else {
                    print "    <p class=\"aviso\">Error al crear el registro <strong>$nombre $apellidos $telefono</strong>.</p>\n";
                }
            }
        }
    }
}

$db = null;
pie();
