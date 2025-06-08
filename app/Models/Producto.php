<?php
namespace App\Models;

use PDO;

class Producto extends EmptyModel
{
    protected string $tabla = 'productos';

    public function obtenerPaginados(int $inicio, int $limite): array
    {
        $stmt = $this->db->prepare("SELECT * FROM productos LIMIT :inicio, :limite");
        $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorNombre(string $nombre): array
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE nombre LIKE ?");
        $stmt->execute(["%$nombre%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCategoria(int $categoriaId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE categoria_id = ?");
        $stmt->execute([$categoriaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $resultado = $this->find($id, $this->tabla);
        return is_array($resultado) ? $resultado : null;
    }

    public function getAll(): array
    {
        return $this->findAll($this->tabla);
    }

    public function crear(array $datos, array $archivos): bool
    {
        $imagen = $this->procesarImagen($archivos['imagen'] ?? null);
        $stmt = $this->db->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $datos['nombre'],
            $datos['descripcion'],
            $datos['precio'],
            $datos['stock'],
            $datos['categoria_id'],
            $imagen
        ]);
    }

    public function actualizar(array $datos, array $archivos): bool
    {
        $imagen = $this->procesarImagen($archivos['imagen'] ?? null, $datos['imagen_actual'] ?? null);
        $stmt = $this->db->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, categoria_id=?, imagen=? WHERE id=?");
        return $stmt->execute([
            $datos['nombre'],
            $datos['descripcion'],
            $datos['precio'],
            $datos['stock'],
            $datos['categoria_id'],
            $imagen,
            $datos['id']
        ]);
    }

    public function getById($id): ?array
    {
        return $this->find($id, $this->tabla);
    }

    public function eliminar($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    private function procesarImagen(?array $archivo, ?string $existente = null): ?string
    {
        if ($archivo && $archivo['error'] === UPLOAD_ERR_OK) {
            $nombre = basename($archivo['name']);
            $destino = __DIR__ . '/../../public/img/' . $nombre;
            move_uploaded_file($archivo['tmp_name'], $destino);
            return $nombre;
        }
        return $existente;
    }

}
