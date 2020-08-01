<?php

/**
 * JSON API отзывов о точках (объектах) на карте.
 */

require 'inc/config.php';
require 'inc/database.php';
require 'inc/Review.php';


$action = $_GET['action'] ?? '';

$actions = [
    'get_list' => 'get_list',
    'get_item' => 'get_item',
    'create_item' => 'create_item',
    'seed_items' => 'seed_items',
];

header('Content-Type: application/json; charset=UTF-8');

// Недоступный метод API
if (!isset($actions[$action])) {
    $error = [
        'success' => false,
        'error' => 'Action not available',
    ];
    echo json_encode($error);
    exit;
}

// Подключить БД
Database::init($config['db']);

$pdo = Database::getPdo();

if (!Database::isActive()) {
    $error = [
        'success' => false,
        'error' => 'Database not available',
    ];
    echo json_encode($error);
    exit;
}

// Вызвать соответствующий блок под выбранное действие
try {
    call_user_func($actions[$action]);
} catch (Exception $e) {
    $error = [
        'success' => false,
        'error' => 'Unknown action',
    ];
    echo json_encode($error);
    exit;
}


/**
 * Получение списка отзывов
 */
function get_list() {
    $page = $_GET['page'] ?: 1;

    if (!filter_var($page, FILTER_VALIDATE_INT, ['options' => [
        'min_range' => 1,
    ]])
    ) {
        $error = [
            'success' => false,
            'error' => 'Incorrect page number',
            'reviews' => null,
        ];
        echo json_encode($error);
        exit;
    }

    $sortValue = $_GET['sort'] ?? '';
    $orderValue = $_GET['order'] ?? '';

    $sort_available = [
        'rating' => 'rating',
        'created_at' => 'created_at',
    ];
    $order_available = [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ];

    if ($sortValue
        && (
            !isset($sort_available[$sortValue])
            || (
                $orderValue
                && !isset($order_available[$orderValue])
            )
        )
    ) {
        $error = [
            'success' => false,
            'error' => 'Incorrect sort params',
            'reviews' => null,
        ];
        echo json_encode($error);
        exit;
    }

    $sort = $sortValue ? $sort_available[$sortValue] : null;
    $order = $orderValue ? $order_available[$orderValue] : null;

    $limit = 10;
    $offset = $limit * ($page - 1);

    $reviews = Review::getList($limit, $offset, $sort, $order);
    $reviewsData = [];

    foreach ($reviews as $review) {
        $row = [
            'id' => $review->id,
            'username' => $review->username,
            'rating' => $review->rating,
            'main_photo' => $review->mainPhoto(),
        ];
        $reviewsData[] = $row;
    }

    $data = [
        'success' => true,
        'error' => null,
        'reviews' => $reviewsData,
    ];

    echo json_encode($data);
    exit;
}

/**
 * Получение одного отзыва
 */
function get_item() {
    if (empty($_GET['id'])
        || !filter_var($_GET['id'], FILTER_VALIDATE_INT)
    ) {
        $error = [
            'success' => false,
            'error' => 'Review not found',
            'review' => null,
        ];
    }

    $review = Review::find($_GET['id']);

    if ($review === null) {
        $success = false;
        $error = 'Review not found';
        $reviewData = null;
    } else {
        $success = true;
        $error = null;
        $reviewData = [
            'username' => $review->username,
            'rating' => $review->rating,
            'main_photo' => $review->mainPhoto(),
        ];

        $fields = $_GET['fields'] ? trim($_GET['fields'], " \t\n\r\0\x0B,") : '';
        $fieldsArray = [];

        if (isset($fields[0])) {
            $fieldsArray = explode(',', $fields);

            foreach ($fieldsArray as $key => $val) {
                $val = trim($val);

                if (isset($val[0])) {
                    $fieldsArray[$key] = $val;
                } else {
                    unset($fieldsArray[$key]);
                }
            }

            $fieldsArray = array_values($fieldsArray);
        }

        if (in_array('description', $fieldsArray)) {
            $reviewData['description'] = $review->description;
        }

        if (in_array('photos', $fieldsArray)) {
            $reviewData['photos'] = $review->photos;
        }
    }

    $data = [
        'success' => $success,
        'error' => $error,
        'review' => $reviewData,
    ];

    echo json_encode($data);
    exit;
}

/**
 * Создание отзыва
 */
function create_item() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $error = [
            'success' => false,
            'error' => 'Invalid request method',
        ];
        echo json_encode($error);
        exit;
    }

    // validate
    $review = new Review();
    $photos = (array) ($_POST['photos'] ?? []);
    $data = [
        'username' => $_POST['username'] ?? '',
        'rating' => $_POST['rating'] ?? '',
        'description' => $_POST['description'] ?? '',
        'photos' => $photos,
    ];
    $review->massAssign($data, false);

    if (!$review->validate()) {
        $error = [
            'success' => false,
            'error' => 'validation_error',
            'validation_errors' => $review->getValidationErrors(),
        ];
        echo json_encode($error);
        exit;
    }

    $reviewId = $review->save();

    if ($reviewId === null) {
        $error = [
            'success' => false,
            'error' => 'save_error',
        ];
        echo json_encode($error);
        exit;
    }

    $data = [
        'success' => true,
        'error' => null,
        'id' => $reviewId,
    ];

    echo json_encode($data);
    exit;
}

/**
 * Создать отзывы для тестирования
 */
function seed_items() {
    $limit = 10;
    $hasError = false;
    $ids = [];
    $start = isset($_GET['start']) ? (int) $_GET['start'] : 1;
    $end = $start + $limit - 1;

    for ($i = $start; $i <= $end; $i++) {
        $review = new Review();
        $photos = [
            'photo-link-1',
            'photo-link-2',
            'photo-link-3',
        ];
        $data = [
            'username' => 'name' . $i,
            'rating' => mt_rand(1, 5),
            'description' => 'Here is description ' . $i,
            'photos' => $photos,
        ];
        $review->massAssign($data, false);

        if ($review->validate()) {
            $ids[] = $review->save();
        } else {
            $hasError = true;
        }
    }

    if ($hasError) {
        $data = [
            'success' => false,
            'error' => 'seeding_error',
        ];
    } else {
        $data = [
            'success' => true,
            'error' => null,
            'ids' => $ids,
        ];
    }

    echo json_encode($data);
    exit;
}
