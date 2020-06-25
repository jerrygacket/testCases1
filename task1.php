<?php
$array = [
    'authors' => [
        [
            'id' => 1,
            'name' => 'Николай Васильевич',
            'year' => 1809,
            'email' => 'gogol@gogol.ru',
        ],
        [
            'id' => 2,
            'name' => 'Пушкин',
            'year' => 1799,
            'email' => 'alexandr@sergeevich.ru',
        ],
        [
            'id' => 3,
            'name' => 'Автор3',
            'year' => 1900,
            'email' => 'author3@extra.ru',
        ],
    ],
    'books' => [
        [
            'authorId' => 1,
            'name' => 'Мертвые души',
            'year' => 1841,
        ],
        [
            'authorId' => 1,
            'name' => 'Вий',
            'year' => 1834,
        ],
        [
            'authorId' => 2,
            'name' => 'Пиковая дама',
            'year' => 1833,
        ],
        [
            'authorId' => 3,
            'name' => 'Вторая',
            'year' => 1908,
        ],
        [
            'authorId' => 3,
            'name' => 'Зеленая',
            'year' => 1920,
        ],
        [
            'authorId' => 4,
            'name' => 'Букварь',
            'year' => 1000,
        ],
    ]
];

function getAuthorInfoById($authors, $id) {
    foreach ($authors as $author) {
        if ($author['id'] == $id) {
            return $author;
        }
    }

    return [];
}

echo 'Авторы'.PHP_EOL;
foreach ($array['authors'] as $author) {
    echo $author['name'].' - '.$author['email'].' - '.$author['year'].PHP_EOL;
}

echo 'Книги'.PHP_EOL;
foreach ($array['books'] as $book) {
    if ($author = getAuthorInfoById($array['authors'], $book['authorId'])) {
        echo $book['name'].' - '.$author['name'].' - '.$book['year'].PHP_EOL;
    }
}