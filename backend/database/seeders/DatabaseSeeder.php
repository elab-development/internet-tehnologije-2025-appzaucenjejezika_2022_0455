<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tasks')->truncate();
        DB::table('lessons')->truncate();
        DB::table('courses')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        

        echo "🗑️  Tables cleared\n";

        // ========== USERS ==========
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ana Djuric',
                'email' => 'ana@test.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Test User',
                'email' => 'test@test.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        echo "✅ Created 3 users\n";

        // ========== COURSES ==========
        $englishId = DB::table('courses')->insertGetId([
            'title' => 'English for Beginners',
            'description' => 'Learn English from scratch',
            'language' => 'English',
            'level' => 'beginner',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $spanishId = DB::table('courses')->insertGetId([
            'title' => 'Spanish for Beginners',
            'description' => 'Learn Spanish basics',
            'language' => 'Spanish',
            'level' => 'beginner',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $germanId = DB::table('courses')->insertGetId([
            'title' => 'German Intermediate',
            'description' => 'Intermediate German course',
            'language' => 'German',
            'level' => 'intermediate',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        echo "✅ Created 3 courses\n";

        // ========== LESSONS ==========
        $greetingsId = DB::table('lessons')->insertGetId([
            'course_id' => $englishId,
            'title' => 'Greetings',
            'content' => 'Learn how to greet people in English',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $numbersId = DB::table('lessons')->insertGetId([
            'course_id' => $englishId,
            'title' => 'Numbers',
            'content' => 'Learn to count from 1 to 100',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $foodId = DB::table('lessons')->insertGetId([
            'course_id' => $englishId,
            'title' => 'Food & Drinks',
            'content' => 'Common food vocabulary',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $saludosId = DB::table('lessons')->insertGetId([
            'course_id' => $spanishId,
            'title' => 'Saludos',
            'content' => 'Spanish greetings and introductions',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $grundlagenId = DB::table('lessons')->insertGetId([
            'course_id' => $germanId,
            'title' => 'Grundlagen',
            'content' => 'German language basics',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        echo "✅ Created 5 lessons\n";

        // ================= TASKS =================
DB::table('tasks')->insert([

    // ================= ENGLISH - GREETINGS =================
    [
        'lesson_id' => $greetingsId,
        'question' => 'Translate: Zdravo',
        'type' => 'translate',
        'options' => null,
        'correct_answer' => 'Hello',
        'audio_url' => null,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'lesson_id' => $greetingsId,
        'question' => 'Choose the correct translation for "Good night"',
        'type' => 'multiple-choice',
        'options' => json_encode(['Laku noć', 'Dobro jutro', 'Dobar dan', 'Zdravo']),
        'correct_answer' => 'Laku noć',
        'audio_url' => null,
        'created_at' => now(),
        'updated_at' => now()
    ],

    // ================= ENGLISH - NUMBERS =================
    [
        'lesson_id' => $numbersId,
        'question' => 'Translate: deset',
        'type' => 'translate',
        'options' => null,
        'correct_answer' => 'Ten',
        'audio_url' => null,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'lesson_id' => $numbersId,
        'question' => 'How do you say number 5?',
        'type' => 'multiple-choice',
        'options' => json_encode(['Four', 'Five', 'Six', 'Seven']),
        'correct_answer' => 'Five',
        'audio_url' => null,
        'created_at' => now(),
        'updated_at' => now()
    ],

    // ================= ENGLISH - FOOD =================
    [
        'lesson_id' => $foodId,
        'question' => 'What is "bread" in Serbian?',
        'type' => 'multiple-choice',
        'options' => json_encode(['Voda', 'Hleb', 'Mleko', 'Sir']),
        'correct_answer' => 'Hleb',
        'audio_url' => null,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'lesson_id' => $foodId,
        'question' => 'Translate: mleko',
        'type' => 'translate',
        'options' => null,
        'correct_answer' => 'Milk',
        'audio_url' => null,
        'created_at' => now(),
        'updated_at' => now()
    ],

    // ================= ENGLISH - AUDIO =================
    [
        'lesson_id' => $greetingsId,
        'question' => 'Listen and choose the correct word',
        'type' => 'audio',
        'options' => json_encode(['Hello', 'Goodbye', 'Please', 'Thanks']),
        'correct_answer' => 'Hello',
        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
        'created_at' => now(),
        'updated_at' => now()
    ],

    // ================= SPANISH - SALUDOS =================
    [
        'lesson_id' => $saludosId,
        'question' => 'Translate: Zdravo',
        'type' => 'translate',
        'options' => null,
        'correct_answer' => 'Hola',
        'audio_url' => null,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'lesson_id' => $saludosId,
        'question' => 'Choose the correct translation for "Good night"',
        'type' => 'multiple-choice',
        'options' => json_encode(['Buenas noches', 'Buenos días', 'Hola', 'Adiós']),
        'correct_answer' => 'Buenas noches',
        'audio_url' => null,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'lesson_id' => $saludosId,
        'question' => 'Listen and choose the correct word',
        'type' => 'audio',
        'options' => json_encode(['Hola', 'Adiós', 'Por favor', 'Gracias']),
        'correct_answer' => 'Hola',
        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
        'created_at' => now(),
        'updated_at' => now()
    ],

    // ================= GERMAN - GRUNDLAGEN =================
    [
        'lesson_id' => $grundlagenId,
        'question' => 'Translate: Zdravo',
        'type' => 'translate',
        'options' => null,
        'correct_answer' => 'Hallo',
        'audio_url' => null,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'lesson_id' => $grundlagenId,
        'question' => 'Choose the correct translation for "Good night"',
        'type' => 'multiple-choice',
        'options' => json_encode(['Gute Nacht', 'Guten Morgen', 'Hallo', 'Tschüss']),
        'correct_answer' => 'Gute Nacht',
        'audio_url' => null,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'lesson_id' => $grundlagenId,
        'question' => 'Listen and choose the correct word',
        'type' => 'audio',
        'options' => json_encode(['Hallo', 'Tschüss', 'Bitte', 'Danke']),
        'correct_answer' => 'Hallo',
        'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
        'created_at' => now(),
        'updated_at' => now()
    ],

]);

    

        echo "✅ Created 13 tasks\n";

        echo "\n";
        echo "🎉 Database seeded successfully!\n";
        echo "📊 Summary:\n";
        echo "   - 3 Users (admin@test.com, ana@test.com, test@test.com)\n";
        echo "   - 3 Courses (English, Spanish, German)\n";
        echo "   - 5 Lessons\n";
        echo "   - 13 Tasks\n";
        echo "🔑 Password for all users: password123\n";
    }
}