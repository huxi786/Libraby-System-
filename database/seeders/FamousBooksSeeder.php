<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class FamousBooksSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'category' => 'Fiction',
                'price' => 15.99,
                'year' => 1960,
                'image' => 'book_covers/to_kill_a_mockingbird.jpg',
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'category' => 'Fiction',
                'price' => 12.50,
                'year' => 1949,
                'image' => 'book_covers/1984.jpg',
            ],
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'category' => 'Fiction',
                'price' => 25.00,
                'year' => 1954,
                'image' => 'book_covers/lotr.jpg',
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'category' => 'History',
                'price' => 22.00,
                'year' => 2011,
                'image' => 'book_covers/sapiens.jpg',
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'category' => 'Science & Tech',
                'price' => 18.75,
                'year' => 1988,
                'image' => 'book_covers/a_brief_history_of_time.jpg',
            ],
            [
                'title' => 'The Diary of a Young Girl',
                'author' => 'Anne Frank',
                'category' => 'Biography',
                'price' => 14.99,
                'year' => 1947,
                'image' => 'book_covers/anne_frank.jpg',
            ],
            [
                'title' => 'The Hitchhiker\'s Guide to the Galaxy',
                'author' => 'Douglas Adams',
                'category' => 'Science & Tech',
                'price' => 10.00,
                'year' => 1979,
                'image' => 'book_covers/hitchhikers_guide.jpg',
            ],
            [
                'title' => 'The Code Book',
                'author' => 'Simon Singh',
                'category' => 'Technology',
                'price' => 16.50,
                'year' => 1999,
                'image' => 'book_covers/code_book.jpg',
            ],
            [
                'title' => 'The Wright Brothers',
                'author' => 'David McCullough',
                'category' => 'Biography',
                'price' => 19.99,
                'year' => 2015,
                'image' => 'book_covers/wright_brothers.jpg',
            ],
            [
                'title' => 'Guns, Germs, and Steel',
                'author' => 'Jared Diamond',
                'category' => 'History',
                'price' => 21.00,
                'year' => 1997,
                'image' => 'book_covers/guns_germs_steel.jpg',
            ],
        ];

        foreach ($books as $bookData) {
            $category = Category::where('name', $bookData['category'])->first();
            if ($category) {
                Book::firstOrCreate(
                    ['title' => $bookData['title']],
                    [
                        'author' => $bookData['author'],
                        'category_id' => $category->id,
                        'price' => $bookData['price'],
                        'year' => $bookData['year'],
                        'image' => $bookData['image'],
                    ]
                );
            }
        }
    }
}
