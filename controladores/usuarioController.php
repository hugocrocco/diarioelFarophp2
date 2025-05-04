<?php

require_once __DIR__ . '/../modelos/Usuario.php';

class UsuarioController {

    private $usuarios = [];

    public function __construct() {
        $this->cargarUsuarios();
    }

    public function eliminarUsuario($id) {
        $this->usuarios = array_filter($this->usuarios, function($usuario) {
            return !in_array($usuario->getNombre(), ['administrador', 'lector']);
        });
    
        $this->usuarios = array_filter($this->usuarios, function($usuario) use ($id) {
            return $usuario->getId() !== $id;
        });
    
        $this->guardarUsuarios();
    }

    private function cargarUsuarios() {
        $ruta = __DIR__ . '/../data/usuarios.json';
        if (file_exists($ruta)) {
            $json = file_get_contents($ruta);
            $arrayUsuarios = json_decode($json, true);

            if ($arrayUsuarios) {
                foreach ($arrayUsuarios as $usuarioData) {
                    $usuario = new Usuario(
                        $usuarioData['id'],
                        $usuarioData['nombre'],
                        $usuarioData['correo'],
                        $usuarioData['password'],
                        $usuarioData['tipo']
                    );
                    $this->usuarios[] = $usuario;
                }
            }
        }
    }

    private function guardarUsuarios() {
        $ruta = __DIR__ . '/../data/usuarios.json';
        $arrayUsuarios = [];

        foreach ($this->usuarios as $usuario) {
            $arrayUsuarios[] = [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'correo' => $usuario->getCorreo(),
                'password' => $usuario->getPassword(),
                'tipo' => $usuario->getTipo()
            ];
        }

        file_put_contents($ruta, json_encode($arrayUsuarios, JSON_PRETTY_PRINT));
    }

    public function login($correo, $password) {
        foreach ($this->usuarios as $usuario) {
            if ($usuario->getCorreo() === $correo && $usuario->getPassword() === $password) {
                return $usuario;
            }
        }
        return null;
    }

    public function registrarUsuario($nombre, $correo, $password, $tipo = 'lector') {
        $id = uniqid();
        $nuevoUsuario = new Usuario($id, $nombre, $correo, $password, $tipo);
        $this->usuarios[] = $nuevoUsuario;
        $this->guardarUsuarios();
        return $nuevoUsuario;
    }
    public function obtenerTodosLosUsuarios() {
        return $this->usuarios;
    }
}

?>