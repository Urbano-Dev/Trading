<?php

class Post
{
    // db records
    private $conn;
    private $table = 'products';

    public $errors;
    // post properties
    public $id;
    public $product_name;
    public $storage;
    public $memory;
    public $color;
    public $price;
    public $serial_number;
    public $notes;
    public $date;
    public $brand_id;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = 'SELECT
            p.id,
            b.name as brand,
            p.name,
            p.storage,
            p.memory,
            p.color,
            p.price,
            p.serial_number,
            p.notes,
            p.date
            FROM
            ' . $this->table . ' p 
            LEFT JOIN 
                brand b ON p.brand_id = b.id
                ORDER BY p.name DESC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function get_product()
    {
        $query = 'SELECT
            p.id,
            b.name as brand,
            p.name,
            p.storage,
            p.memory,
            p.color,
            p.price,
            p.serial_number,
            p.notes,
            p.date
            FROM
            ' . $this->table . ' p 
            LEFT JOIN 
                brand b ON p.brand_id = b.id
                Where p.serial_number = ? LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->serial_number);
        try {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->id = $row['id'];
                $this->brand_id = $row['brand'];
                $this->product_name = $row['name'];
                $this->storage = $row['storage'];
                $this->memory = $row['memory'];
                $this->color = $row['color'];
                $this->price = $row['price'];
                $this->serial_number = $row['serial_number'];
                $this->notes = $row['notes'];
                $this->date = $row['date'];
            } else {
                $this->errors = json_encode('Product not found');
            }
        } catch (PDOException $e) {
            error_log('Database Error in get_product(): ' . $e->getMessage());
            throw new Exception('Database Error. Please try again later.');
        }
    }

    public function create()
    {
        try {
            // Prepare the SQL query
            $query = 'INSERT INTO ' . $this->table . ' SET
            name = :name, 
            storage = :storage,
            memory = :memory,
            color = :color,
            price = :price,
            serial_number = :serial_number,
            notes = :notes,
            brand_id = :brand_id';

            // Prepare and bind parameters
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $this->product_name);
            $stmt->bindParam(':storage', $this->storage);
            $stmt->bindParam(':memory', $this->memory);
            $stmt->bindParam(':color', $this->color);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':serial_number', $this->serial_number);
            $stmt->bindParam(':notes', $this->notes);
            $stmt->bindParam(':brand_id', $this->brand_id);

            // Execute the query
            if ($stmt->execute()) {
                return true; // Success
            } else {
                throw new Exception('Error executing SQL query.');
            }
        } catch (PDOException $e) {
            // Log detailed error for debugging
            error_log('Database Error in create(): ' . $e->getMessage());
            throw new Exception('Database Error. Please try again later.');
        } catch (Exception $e) {
            // Log or handle specific error cases
            error_log('Error in create(): ' . $e->getMessage());
            throw new Exception('Error creating product.');
        }
    }


    public function update()
    {
        // query
        $query = 'UPDATE ' . $this->table . ' SET
        name = :name, 
        storage = :storage,
        memory = :memory,
        color = :color,
        price = :price,
        serial_number = :serial_number,
        notes = :notes,
        brand_id = :brand_id
        WHERE id = :id';

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->storage = htmlspecialchars(strip_tags($this->storage));
        $this->memory = htmlspecialchars(strip_tags($this->memory));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->serial_number = htmlspecialchars(strip_tags($this->serial_number));
        $this->notes = htmlspecialchars(strip_tags($this->notes));
        $this->brand_id = htmlspecialchars(strip_tags($this->brand_id));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->product_name);
        $stmt->bindParam(':storage', $this->storage);
        $stmt->bindParam(':memory', $this->memory);
        $stmt->bindParam(':color', $this->color);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':serial_number', $this->serial_number);
        $stmt->bindParam(':notes', $this->notes);
        $stmt->bindParam(':brand_id', $this->brand_id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error %s", $stmt->Error);
        return false;
    }

    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE serial_number = :serial_number';

        $stmt = $this->conn->prepare($query);

        $this->serial_number = htmlspecialchars(strip_tags($this->serial_number));
        $stmt->bindParam(':serial_number', $this->serial_number);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error %s \n", $stmt->error);
        return false;
    }
}