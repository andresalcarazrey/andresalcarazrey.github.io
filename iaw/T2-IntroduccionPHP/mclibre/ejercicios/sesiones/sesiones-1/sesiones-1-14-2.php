<?php
/**
 * Sesiones (1) 06 - sesiones-1-14-2.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2018 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2018-11-13
 * @link      https://www.mclibre.org
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
// Se accede a la sesión
session_name("sesiones-1-14");
session_start();

// Si alguno de los números de votos no está guardado en la sesión, los pone a cero
if (!isset($_SESSION["a"]) || !isset($_SESSION["b"])) {
    $_SESSION["a"] = $_SESSION["b"] = 0;
}

// Funciones auxiliares
function recoge($var, $m = "")
{
    if (!isset($_REQUEST[$var])) {
        $tmp = (is_array($m)) ? [] : "";
    } elseif (!is_array($_REQUEST[$var])) {
        $tmp = trim(htmlspecialchars($_REQUEST[$var], ENT_QUOTES, "UTF-8"));
    } else {
        $tmp = $_REQUEST[$var];
        array_walk_recursive($tmp, function (&$valor) {
            $valor = trim(htmlspecialchars($valor, ENT_QUOTES, "UTF-8"));
        });
    }
    return $tmp;
}

// Recogida de accion
$accion = recoge("accion");

// Dependiendo de la acción recibida, modifica el número correspondiente
if ($accion == "a") {
    $_SESSION["a"] += 10;
} elseif ($accion == "b") {
    $_SESSION["b"] += 10;
} elseif ($accion == "cero") {
    $_SESSION["a"] = $_SESSION["b"] = 0;
}

// y vuelve al formulario
header("Location:sesiones-1-14-1.php");
?>