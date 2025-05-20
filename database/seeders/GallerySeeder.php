<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

        // Clear storage directory
        Storage::disk('public')->deleteDirectory('gallery');
        Storage::disk('public')->makeDirectory('gallery');

        $users = User::all();

        $galleries = [
            [
                'title' => 'Summer Festival 2023',
                'description' => 'Amazing moments from our annual summer festival with live music and food stalls.',
                'images' => ['festival1.jpg', 'festival2.jpg', 'festival3.jpg'],
                'approved' => true
            ],
            // Add more galleries as needed
        ];

        foreach ($galleries as $galleryData) {
            $user = $users->random();

            $gallery = Gallery::create([
                'user_id' => $user->id,
                'title' => $galleryData['title'],
                'description' => $galleryData['description'],
                'approved' => $galleryData['approved'],
                // NO 'image' field here
            ]);

            foreach ($galleryData['images'] as $index => $imageName) {
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => "gallery/{$gallery->id}_{$imageName}",
                    'is_primary' => $index === 0,
                ]);
            }
        }
    }
}
