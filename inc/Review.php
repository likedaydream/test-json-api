<?php

/**
 * Отзыв об объекте на карте
 */
class Review
{
    public $id;

    /** @var int ID объекта, на который оставлен отзыв */
    public $object_id;

    public $username;
    public $rating;
    public $description;
    public $created_at;
    public $photos = [];

    private $validation_errors = [];

    public static function find($id)
    {
        $pdo = Database::getPdo();

        try {
            $stmt = $pdo->prepare('SELECT * FROM reviews WHERE id = ?');
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            return null;
        }

        $row = $stmt->fetch();

        if ($row === false) {
            return null;
        }

        $review = new self();
        $review->massAssign($row, true);
        $review->castTypes();

        return $review;
    }

    public static function getList($limit, $offset = 0, $sort = null, $order = null)
    {
        $pdo = Database::getPdo();

        $sort = $sort ?? 'id';
        $order = $order ?? 'DESC';

        try {
            $stmt = $pdo->prepare("SELECT * FROM reviews ORDER BY {$sort} {$order} LIMIT :offset, :limit");
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

        } catch (PDOException $e) {
            return [];
        }

        $reviews = [];

        while (($row = $stmt->fetch()) !== false) {
            $review = new self();
            $review->massAssign($row, true);
            $review->castTypes();

            $reviews[] = $review;
        }

        return $reviews;
    }

    public function massAssign($row, $fromDb = false)
    {
        $props = ['id', 'object_id', 'username', 'rating', 'description', 'created_at'];

        foreach ($props as $propName) {
            if (isset($row[$propName])) {
                $this->$propName = $row[$propName];
            }
        }

        if (array_key_exists('photos', $row)) {
            if ($fromDb) {
                $this->photos = $row['photos'] ? unserialize($row['photos']) : [];
            } else {
                $this->photos = $row['photos'];
            }
        }
    }

    public function castTypes()
    {
        if ($this->id) {
            $this->id = (int) $this->id;
        }

        if ($this->object_id) {
            $this->object_id = (int) $this->object_id;
        }

        if ($this->rating) {
            $this->rating = (int) $this->rating;
        }
    }

    public function mainPhoto()
    {
        if (isset($this->photos[0])) {
            return $this->photos[0];
        }

        return null;
    }

    public function validate()
    {
        $errors = [];

        if (!$this->rating
            || !filter_var($this->rating,
                FILTER_VALIDATE_INT,
                    ['options' => [
                        'min_range' => 1,
                        'max_range' => 5,
                    ]])
        ) {
            $errors['rating'][] = 'Rating must be from 1 to 5';
        }

        if (isset($this->username)) {
            $this->username = trim($this->username);
            $strlen = mb_strlen($this->username);

            if ($strlen < 1 || $strlen > 50) {
                $errors['username'][] = 'Username must be 1-50 symbols';
            }
        } else {
            $errors['username'][] = 'Username must be 1-50 symbols';
        }

        if (isset($this->description)) {
            $this->description = trim($this->description);
            $strlen = mb_strlen($this->description);
            $descriptionMax = 1000;

            if ($strlen > $descriptionMax) {
                $errors['description'][] = "Description max length = {$descriptionMax}";
            }
        } else {
            $this->description = '';
        }

        if ($this->photos !== null) {
            if (!is_array($this->photos)) {
                $errors['photos'][] = 'Photos invalid format';
            } else {
                foreach ($this->photos as $key => $val) {
                    if (!is_string($val) || !isset($val[0])) {
                        unset($this->photos[$key]);
                    }
                }

                $this->photos = array_values($this->photos);
                $maxPhotos = 3;

                if (count($this->photos) > $maxPhotos) {
                    $errors['photos'][] = "Photos max number {$maxPhotos}";
                }
            }
        } else {
            $this->photos = [];
        }

        $this->validation_errors = $errors;

        return $errors ? false : true;
    }

    public function save()
    {
        $pdo = Database::getPdo();

        $this->object_id = 1;

        try {
            $stmt = $pdo->prepare('INSERT INTO reviews (object_id, username, rating, description, photos) VALUES (:object_id, :username, :rating, :description, :photos)');

            $params = [
                ':object_id' => $this->object_id,
                ':username' => $this->username,
                ':rating' => $this->rating,
                ':description' => $this->description,
                ':photos' => !empty($this->photos) ? serialize($this->photos) : null,
            ];

            $stmt->execute($params);
        } catch (PDOException $e) {
            return null;
        }

        $this->id = (int) $pdo->lastInsertId();
        return $this->id;
    }

    public function getValidationErrors()
    {
        return $this->validation_errors;
    }
}
