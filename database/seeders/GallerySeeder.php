<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data safely
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        GalleryImage::truncate();
        Gallery::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Clear and recreate storage directory
        Storage::disk('public')->deleteDirectory('gallery');
        Storage::disk('public')->makeDirectory('gallery');

        $users = User::all();

        // Sample images (must exist in `database/seeders/images/gallery/`)
        $sampleImages = [
            'event1.jpg',
            'event2.jpg',
            'event3.jpg',
        ];

        $galleries = [
            [
                'title' => 'Summer Festival 2023',
                'description' => 'Amazing moments from our annual summer festival with live music and food stalls.',
                'approved' => true
            ],
            [
                'title' => 'Summer Festival 2023',
                'description' => 'Amazing moments from our annual summer festival with live music and food stalls.',
                'approved' => true
            ],
            [
                'title' => 'Summer Festival 2023',
                'description' => 'Amazing moments from our annual summer festival with live music and food stalls.',
                'approved' => false
            ],
            // ... (other galleries)
        ];

        foreach ($galleries as $galleryData) {
            $user = $users->random();

            $gallery = Gallery::create([
                'user_id' => $user->id,
                'title' => $galleryData['title'],
                'description' => $galleryData['description'],
                'approved' => $galleryData['approved'],
            ]);

            // Store each image physically and in the DB
            foreach ($sampleImages as $index => $imageName) {
                $sourcePath = database_path("seeders/images/gallery/{$imageName}");
                $destinationPath = "gallery/{$gallery->id}_{$imageName}";

                // Copy the image to storage
                Storage::disk('public')->put(
                    $destinationPath,
                    file_get_contents($sourcePath)
                );

                // Save to DB
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $destinationPath,
                    'is_primary' => $index === 0,
                ]);
            }
        }
    }
}
