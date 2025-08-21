<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hobby;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        $mainHobbies = [
            ['name' => 'Islamic', 'emoji' => '🕌', 'color' => '#2ECC71'],
            ['name' => 'Sports', 'emoji' => '⚽', 'color' => '#3498DB'],
            ['name' => 'Traditional', 'emoji' => '🎭', 'color' => '#E67E22'],
            ['name' => 'Artistic', 'emoji' => '🎨', 'color' => '#8E44AD'],
            ['name' => 'Tech & Digital', 'emoji' => '💻', 'color' => '#2C3E50'],
            ['name' => 'Outdoor Activities', 'emoji' => '🌲', 'color' => '#16A085'],
            ['name' => 'Indoor Activities', 'emoji' => '🏠', 'color' => '#D35400'],
            ['name' => 'Music', 'emoji' => '🎵', 'color' => '#9B59B6'],
            ['name' => 'Reading & Writing', 'emoji' => '📚', 'color' => '#34495E'],
            ['name' => 'Food & Cooking', 'emoji' => '🍳', 'color' => '#E74C3C'],
            ['name' => 'Collecting', 'emoji' => '🗃️', 'color' => '#7F8C8D'],
            ['name' => 'Games', 'emoji' => '🎮', 'color' => '#C0392B'],
        ];

        $mainIds = [];

        foreach ($mainHobbies as $main) {
            $main['type'] = 0;
            $hobby = Hobby::create($main);
            $mainIds[$main['name']] = $hobby->id;
        }

        $associated = [
            // Islamic
            ['name' => 'Reciting Quran', 'emoji' => '📖', 'color' => '#1B9CFC', 'main' => 'Islamic'],
            ['name' => 'Memorizing Quran', 'emoji' => '🧠', 'color' => '#55EFC4', 'main' => 'Islamic'],
            ['name' => 'Listening to Islamic Lectures', 'emoji' => '🕌', 'color' => '#81ECEC', 'main' => 'Islamic'],
            ['name' => 'Learning Fiqh', 'emoji' => '📜', 'color' => '#7D5FFF', 'main' => 'Islamic'],
            ['name' => 'Islamic Calligraphy', 'emoji' => '✒️', 'color' => '#6C5CE7', 'main' => 'Islamic'],
            ['name' => 'Islamic Poetry', 'emoji' => '✏️', 'color' => '#00B894', 'main' => 'Islamic'],
            ['name' => 'Islamic History', 'emoji' => '🏛️', 'color' => '#0984E3', 'main' => 'Islamic'],
            ['name' => 'Teaching Islam', 'emoji' => '👨‍🏫', 'color' => '#00CEc9', 'main' => 'Islamic'],

            // Sports
            ['name' => 'Cricket', 'emoji' => '🏏', 'color' => '#27AE60', 'main' => 'Sports'],
            ['name' => 'Football', 'emoji' => '⚽', 'color' => '#1ABC9C', 'main' => 'Sports'],
            ['name' => 'Swimming', 'emoji' => '🏊', 'color' => '#74B9FF', 'main' => 'Sports'],
            ['name' => 'Horse Riding', 'emoji' => '🏇', 'color' => '#8E44AD', 'main' => 'Sports'],
            ['name' => 'Basketball', 'emoji' => '🏀', 'color' => '#E74C3C', 'main' => 'Sports'],
            ['name' => 'Tennis', 'emoji' => '🎾', 'color' => '#F1C40F', 'main' => 'Sports'],
            ['name' => 'Badminton', 'emoji' => '🏸', 'color' => '#2ECC71', 'main' => 'Sports'],
            ['name' => 'Volleyball', 'emoji' => '🏐', 'color' => '#E67E22', 'main' => 'Sports'],
            ['name' => 'Table Tennis', 'emoji' => '🏓', 'color' => '#9B59B6', 'main' => 'Sports'],
            ['name' => 'Martial Arts', 'emoji' => '🥋', 'color' => '#3498DB', 'main' => 'Sports'],
            ['name' => 'Cycling', 'emoji' => '🚴', 'color' => '#16A085', 'main' => 'Sports'],
            ['name' => 'Running', 'emoji' => '🏃', 'color' => '#D35400', 'main' => 'Sports'],
            ['name' => 'Gym', 'emoji' => '🏋️', 'color' => '#C0392B', 'main' => 'Sports'],
            ['name' => 'Archery', 'emoji' => '🏹', 'color' => '#7F8C8D', 'main' => 'Sports'],
            ['name' => 'Fishing', 'emoji' => '🎣', 'color' => '#34495E', 'main' => 'Sports'],

            // Traditional
            ['name' => 'Traditional Dance', 'emoji' => '💃', 'color' => '#E84393', 'main' => 'Traditional'],
            ['name' => 'Traditional Music', 'emoji' => '🎶', 'color' => '#FD79A8', 'main' => 'Traditional'],
            ['name' => 'Traditional Crafts', 'emoji' => '🧵', 'color' => '#FDCB6E', 'main' => 'Traditional'],
            ['name' => 'Traditional Games', 'emoji' => '🎲', 'color' => '#00B894', 'main' => 'Traditional'],
            ['name' => 'Folk Art', 'emoji' => '🎨', 'color' => '#6C5CE7', 'main' => 'Traditional'],
            ['name' => 'Storytelling', 'emoji' => '📖', 'color' => '#0984E3', 'main' => 'Traditional'],
            ['name' => 'Cultural Festivals', 'emoji' => '🎪', 'color' => '#E17055', 'main' => 'Traditional'],

            // Artistic
            ['name' => 'Drawing', 'emoji' => '✏️', 'color' => '#6C5CE7', 'main' => 'Artistic'],
            ['name' => 'Painting', 'emoji' => '🎨', 'color' => '#00B894', 'main' => 'Artistic'],
            ['name' => 'Sculpting', 'emoji' => '🗿', 'color' => '#0984E3', 'main' => 'Artistic'],
            ['name' => 'Photography', 'emoji' => '📷', 'color' => '#00CEc9', 'main' => 'Artistic'],
            ['name' => 'Pottery', 'emoji' => '🏺', 'color' => '#E84393', 'main' => 'Artistic'],
            ['name' => 'Calligraphy', 'emoji' => '✒️', 'color' => '#FD79A8', 'main' => 'Artistic'],
            ['name' => 'Digital Art', 'emoji' => '🖥️', 'color' => '#FDCB6E', 'main' => 'Artistic'],
            ['name' => 'Graffiti', 'emoji' => '🎨', 'color' => '#E17055', 'main' => 'Artistic'],
            ['name' => 'Origami', 'emoji' => '📄', 'color' => '#6C5CE7', 'main' => 'Artistic'],

            // Tech & Digital
            ['name' => 'Programming', 'emoji' => '💻', 'color' => '#2C3E50', 'main' => 'Tech & Digital'],
            ['name' => 'Gaming', 'emoji' => '🎮', 'color' => '#9B59B6', 'main' => 'Tech & Digital'],
            ['name' => '3D Modeling', 'emoji' => '🖥️', 'color' => '#3498DB', 'main' => 'Tech & Digital'],
            ['name' => 'Video Editing', 'emoji' => '🎬', 'color' => '#E74C3C', 'main' => 'Tech & Digital'],
            ['name' => 'Graphic Design', 'emoji' => '🎨', 'color' => '#F1C40F', 'main' => 'Tech & Digital'],
            ['name' => 'Robotics', 'emoji' => '🤖', 'color' => '#16A085', 'main' => 'Tech & Digital'],
            ['name' => 'Drone Flying', 'emoji' => '🚁', 'color' => '#D35400', 'main' => 'Tech & Digital'],
            ['name' => 'VR/AR', 'emoji' => '👓', 'color' => '#C0392B', 'main' => 'Tech & Digital'],
            ['name' => 'Cybersecurity', 'emoji' => '🔒', 'color' => '#7F8C8D', 'main' => 'Tech & Digital'],
            ['name' => 'AI/Machine Learning', 'emoji' => '🧠', 'color' => '#34495E', 'main' => 'Tech & Digital'],

            // Outdoor Activities
            ['name' => 'Hiking', 'emoji' => '🥾', 'color' => '#27AE60', 'main' => 'Outdoor Activities'],
            ['name' => 'Camping', 'emoji' => '⛺', 'color' => '#1ABC9C', 'main' => 'Outdoor Activities'],
            ['name' => 'Gardening', 'emoji' => '🌱', 'color' => '#74B9FF', 'main' => 'Outdoor Activities'],
            ['name' => 'Bird Watching', 'emoji' => '🐦', 'color' => '#8E44AD', 'main' => 'Outdoor Activities'],
            ['name' => 'Stargazing', 'emoji' => '🔭', 'color' => '#2C3E50', 'main' => 'Outdoor Activities'],
            ['name' => 'Mountain Climbing', 'emoji' => '⛰️', 'color' => '#E67E22', 'main' => 'Outdoor Activities'],
            ['name' => 'Kayaking', 'emoji' => '🛶', 'color' => '#3498DB', 'main' => 'Outdoor Activities'],
            ['name' => 'Rock Climbing', 'emoji' => '🧗', 'color' => '#E74C3C', 'main' => 'Outdoor Activities'],

            // Indoor Activities
            ['name' => 'Chess', 'emoji' => '♟️', 'color' => '#2C3E50', 'main' => 'Indoor Activities'],
            ['name' => 'Puzzles', 'emoji' => '🧩', 'color' => '#9B59B6', 'main' => 'Indoor Activities'],
            ['name' => 'Board Games', 'emoji' => '🎲', 'color' => '#3498DB', 'main' => 'Indoor Activities'],
            ['name' => 'Card Games', 'emoji' => '🃏', 'color' => '#E74C3C', 'main' => 'Indoor Activities'],
            ['name' => 'DIY Crafts', 'emoji' => '✂️', 'color' => '#F1C40F', 'main' => 'Indoor Activities'],
            ['name' => 'Knitting', 'emoji' => '🧶', 'color' => '#16A085', 'main' => 'Indoor Activities'],
            ['name' => 'Sewing', 'emoji' => '🪡', 'color' => '#D35400', 'main' => 'Indoor Activities'],
            ['name' => 'Home Decor', 'emoji' => '🏠', 'color' => '#C0392B', 'main' => 'Indoor Activities'],

            // Music
            ['name' => 'Singing', 'emoji' => '🎤', 'color' => '#E74C3C', 'main' => 'Music'],
            ['name' => 'Playing Guitar', 'emoji' => '🎸', 'color' => '#F1C40F', 'main' => 'Music'],
            ['name' => 'Playing Piano', 'emoji' => '🎹', 'color' => '#16A085', 'main' => 'Music'],
            ['name' => 'Playing Drums', 'emoji' => '🥁', 'color' => '#D35400', 'main' => 'Music'],
            ['name' => 'Violin', 'emoji' => '🎻', 'color' => '#C0392B', 'main' => 'Music'],
            ['name' => 'Flute', 'emoji' => '🎶', 'color' => '#7F8C8D', 'main' => 'Music'],
            ['name' => 'Music Production', 'emoji' => '🎧', 'color' => '#34495E', 'main' => 'Music'],
            ['name' => 'Songwriting', 'emoji' => '✍️', 'color' => '#9B59B6', 'main' => 'Music'],

            // Reading & Writing
            ['name' => 'Novel Reading', 'emoji' => '📚', 'color' => '#2C3E50', 'main' => 'Reading & Writing'],
            ['name' => 'Poetry Writing', 'emoji' => '✍️', 'color' => '#9B59B6', 'main' => 'Reading & Writing'],
            ['name' => 'Journaling', 'emoji' => '📓', 'color' => '#3498DB', 'main' => 'Reading & Writing'],
            ['name' => 'Blogging', 'emoji' => '✍️', 'color' => '#E74C3C', 'main' => 'Reading & Writing'],
            ['name' => 'Non-Fiction Reading', 'emoji' => '📖', 'color' => '#F1C40F', 'main' => 'Reading & Writing'],
            ['name' => 'Creative Writing', 'emoji' => '🖋️', 'color' => '#16A085', 'main' => 'Reading & Writing'],
            ['name' => 'Comic Books', 'emoji' => '🦸', 'color' => '#D35400', 'main' => 'Reading & Writing'],
            ['name' => 'Magazines', 'emoji' => '📰', 'color' => '#C0392B', 'main' => 'Reading & Writing'],

            // Food & Cooking
            ['name' => 'Baking', 'emoji' => '🍞', 'color' => '#E74C3C', 'main' => 'Food & Cooking'],
            ['name' => 'Cooking', 'emoji' => '🍳', 'color' => '#F1C40F', 'main' => 'Food & Cooking'],
            ['name' => 'Coffee Making', 'emoji' => '☕', 'color' => '#16A085', 'main' => 'Food & Cooking'],
            ['name' => 'Tea Tasting', 'emoji' => '🍵', 'color' => '#D35400', 'main' => 'Food & Cooking'],
            ['name' => 'Wine Tasting', 'emoji' => '🍷', 'color' => '#C0392B', 'main' => 'Food & Cooking'],
            ['name' => 'Food Photography', 'emoji' => '📷', 'color' => '#7F8C8D', 'main' => 'Food & Cooking'],
            ['name' => 'Recipe Development', 'emoji' => '📝', 'color' => '#34495E', 'main' => 'Food & Cooking'],
            ['name' => 'Food Blogging', 'emoji' => '✍️', 'color' => '#9B59B6', 'main' => 'Food & Cooking'],

            // Collecting
            ['name' => 'Coin Collecting', 'emoji' => '🪙', 'color' => '#F1C40F', 'main' => 'Collecting'],
            ['name' => 'Stamp Collecting', 'emoji' => '🏷️', 'color' => '#16A085', 'main' => 'Collecting'],
            ['name' => 'Book Collecting', 'emoji' => '📚', 'color' => '#D35400', 'main' => 'Collecting'],
            ['name' => 'Art Collecting', 'emoji' => '🖼️', 'color' => '#C0392B', 'main' => 'Collecting'],
            ['name' => 'Antique Collecting', 'emoji' => '🏺', 'color' => '#7F8C8D', 'main' => 'Collecting'],
            ['name' => 'Vinyl Records', 'emoji' => '🎵', 'color' => '#34495E', 'main' => 'Collecting'],
            ['name' => 'Comic Book Collecting', 'emoji' => '🦸', 'color' => '#9B59B6', 'main' => 'Collecting'],
            ['name' => 'Toy Collecting', 'emoji' => '🧸', 'color' => '#E74C3C', 'main' => 'Collecting'],

            // Games
            ['name' => 'Video Games', 'emoji' => '🎮', 'color' => '#9B59B6', 'main' => 'Games'],
            ['name' => 'Mobile Games', 'emoji' => '📱', 'color' => '#3498DB', 'main' => 'Games'],
            ['name' => 'Tabletop RPGs', 'emoji' => '🎲', 'color' => '#E74C3C', 'main' => 'Games'],
            ['name' => 'Puzzle Games', 'emoji' => '🧩', 'color' => '#16A085', 'main' => 'Games'],
            ['name' => 'E-Sports', 'emoji' => '🏆', 'color' => '#D35400', 'main' => 'Games'],
            ['name' => 'Word Games', 'emoji' => '🔠', 'color' => '#C0392B', 'main' => 'Games'],
            ['name' => 'Strategy Games', 'emoji' => '♟️', 'color' => '#7F8C8D', 'main' => 'Games'],
        ];

        foreach ($associated as $assoc) {
            Hobby::create([
                'name' => $assoc['name'],
                'emoji' => $assoc['emoji'],
                'color' => $assoc['color'],
                'type' => 1,
                'main_hobby_id' => $mainIds[$assoc['main']]
            ]);
        }
    }

}
