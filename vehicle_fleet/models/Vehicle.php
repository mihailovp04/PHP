<?php
require_once 'config/database.php';

/**
 * Vehicle model for handling vehicle-related operations
 */
class Vehicle {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    /**
     * Create a new vehicle
     * @param array $data
     * @param int $userId
     * @return bool
     */
    public function create($data, $userId) {
        $brand = $this->conn->real_escape_string($data['brand']);
        $model = $this->conn->real_escape_string($data['model']);
        $year = (int)$data['year'];
        $color = $this->conn->real_escape_string($data['color']);
        $mileage = (int)$data['mileage'];
        $fuel_type = $this->conn->real_escape_string($data['fuel_type']);
        $sql = "INSERT INTO vehicles (user_id, brand, model, year, color, mileage, fuel_type) 
                VALUES ($userId, '$brand', '$model', $year, '$color', $mileage, '$fuel_type')";
        return $this->conn->query($sql);
    }

    /**
     * Get all vehicles for a user
     * @param int $userId
     * @return array
     */
    public function getByUser($userId) {
        $sql = "SELECT * FROM vehicles WHERE user_id = $userId";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get vehicle by ID
     * @param int $id
     * @param int|null $userId
     * @return array|null
     */
    public function getById($id, $userId = null) {
        $id = (int)$id;
        $sql = "SELECT * FROM vehicles WHERE id = $id";
        if ($userId !== null) {
            $sql .= " AND user_id = " . (int)$userId;
        }
        $result = $this->conn->query($sql);
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    /**
     * Update a vehicle
     * @param int $id
     * @param array $data
     * @param int|null $userId
     * @return bool
     */
    public function update($id, $data, $userId = null) {
        $id = (int)$id;
        $brand = $this->conn->real_escape_string($data['brand']);
        $model = $this->conn->real_escape_string($data['model']);
        $year = (int)$data['year'];
        $color = $this->conn->real_escape_string($data['color']);
        $mileage = (int)$data['mileage'];
        $fuel_type = $this->conn->real_escape_string($data['fuel_type']);
        $sql = "UPDATE vehicles SET 
                brand = '$brand', model = '$model', year = $year, 
                color = '$color', mileage = $mileage, fuel_type = '$fuel_type' 
                WHERE id = $id";
        if ($userId !== null) {
            $sql .= " AND user_id = " . (int)$userId;
        }
        return $this->conn->query($sql);
    }

    /**
     * Delete a vehicle
     * @param int $id
     * @param int|null $userId
     * @return bool
     */
    public function delete($id, $userId = null) {
        $id = (int)$id;
        $sql = "DELETE FROM vehicles WHERE id = $id";
        if ($userId !== null) {
            $sql .= " AND user_id = " . (int)$userId;
        }
        return $this->conn->query($sql);
    }

    /**
     * Search vehicles by criteria
     * @param array $criteria
     * @return array
     */
    public function search($criteria) {
        $sql = "SELECT * FROM vehicles WHERE 1=1";
        if (!empty($criteria['brand'])) {
            $brand = $this->conn->real_escape_string($criteria['brand']);
            $sql .= " AND brand LIKE '%$brand%'";
        }
        if (!empty($criteria['year'])) {
            $year = (int)$criteria['year'];
            $sql .= " AND year = $year";
        }
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>