<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DummyImageSeeder extends Seeder
{
    public function run()
    {
        $images = [
            'products/silk-saree.jpg' => 'https://images.unsplash.com/photo-1583391733956-6c78276477e2?q=80&w=1000&auto=format&fit=crop',
            'products/necklace.jpg' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=1000&auto=format&fit=crop',
            'categories/dresses.jpg' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=1000&auto=format&fit=crop',
            'categories/jewellery.jpg' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=1000&auto=format&fit=crop',
            'banners/hero-1.jpg' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1000&auto=format&fit=crop',
            'banners/hero-2.jpg' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=1000&auto=format&fit=crop',
            
            // Saree Edit Images
            'saree_main.png' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1000&auto=format&fit=crop',
            'saree_detail_1.png' => 'https://images.unsplash.com/photo-1583391733956-6c78276477e2?q=80&w=1000&auto=format&fit=crop',
            'saree_detail_2.png' => 'https://images.unsplash.com/photo-1610030469668-935102a9e50a?q=80&w=1000&auto=format&fit=crop',
            'saree_detail_3.png' => 'https://images.unsplash.com/photo-1610189012906-40da8204653a?q=80&w=1000&auto=format&fit=crop',
            
            // Just In Images
            'just_in_riwaayat.png' => 'https://images.unsplash.com/photo-1589156280159-27698a70f29e?q=80&w=1000&auto=format&fit=crop',
            'just_in_noor_kashmir.png' => 'https://images.unsplash.com/photo-1595967734996-c1265076e825?q=80&w=1000&auto=format&fit=crop',
            
            // Look Images
            'look_1.png' => 'https://images.unsplash.com/photo-1583391733956-6c78276477e2?q=80&w=1000&auto=format&fit=crop',
            'look_2.png' => 'https://images.unsplash.com/photo-1595967734996-c1265076e825?q=80&w=1000&auto=format&fit=crop',
            'look_3.png' => 'https://images.unsplash.com/photo-1610030469668-935102a9e50a?q=80&w=1000&auto=format&fit=crop',
            'look_4.png' => 'https://images.unsplash.com/photo-1610189012906-40da8204653a?q=80&w=1000&auto=format&fit=crop',
            'look_5.png' => 'https://images.unsplash.com/photo-1621605815971-fbc3e5fa097a?q=80&w=1000&auto=format&fit=crop',
            'look_6.png' => 'https://images.unsplash.com/photo-1605518216938-7c31b7b14ad0?q=80&w=1000&auto=format&fit=crop',
        ];

        foreach ($images as $path => $url) {
            try {
                $content = file_get_contents($url);
                if ($content) {
                    // Save to public disk so asset() can find it directly if it's in public/
                    // Or save to storage and use asset('storage/...')
                    // The templates use src="saree_main.png", so it expects them in public/ root.
                    // But standard Laravel practice is public/assets/ or storage.
                    // I'll save to public/ via the 'public' disk root? 
                    // No, disk('public') is storage/app/public.
                    
                    Storage::disk('public')->put($path, $content);
                    $this->command->info("Downloaded: $path");
                }
            } catch (\Exception $e) {
                $this->command->error("Failed to download $url: " . $e->getMessage());
            }
        }
    }
}
