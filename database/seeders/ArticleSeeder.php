<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Tag;
use \App\Models\Category;
use \App\Models\Article;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tag1 = new Tag([
            "name" => "hot"
        ]);
        $tag2 = new Tag([
            "name" => "music"
        ]);
        $tag3 = new Tag([
            "name" => "new"
        ]);
        $tag4 = new Tag([
            "name" => "asian"
        ]);
        $tag5 = new Tag([
            "name" => "usa"
        ]);
        $tag6 = new Tag([
            "name" => "football"
        ]);
        $category1 = Category::create(['name' => 'World']);
        $category1->tags()->saveMany([$tag3, $tag5]);

        $category2 = Category::create(['name' => 'Music']);
        $category2->tags()->saveMany([$tag2, $tag3, $tag1]);

        $category3 = Category::create(['name' => 'Life']);
        $category3->tags()->saveMany([$tag3]);

        $category4 = Category::create(['name' => 'Edu']);
        $category4->tags()->saveMany([$tag3, $tag1]);

        $category5 = Category::create(['name' => 'Sport']);
        $category5->tags()->saveMany([$tag6]);


        $article1 = Article::create([
            'caption' => 'Topic - 1 Sơn Tùng nói gì mà khiến em trai bật khóc ngay lần đầu "chào sân" showbiz?',
            'author' => 'Vũ Mê',
            'detail' => 'Sáng 7/8, chàng ca sĩ có nghệ danh MONO đã chính thức có buổi "chào sân", ra mắt khán giả. Điều bất ngờ là đây không phải gương mặt xa lạ mà chính là Nguyễn Việt Hoàng, em trai của ca sĩ Sơn Tùng M-TP. Trong đoạn clip tự giới thiệu, MONO cũng tự hào nói rằng mình là "em trai của anh Tùng".',
            'image' => 'https://icdn.dantri.com.vn/thumb_w/680/2022/08/07/ca-si-mono-ben-phai-trong-hop-bao-ra-mat-album-22-vao-sang-ngay-78-crop-1659860084437.jpeg?watermark=true',
        ]);

        $article1->categories()->saveMany([$category2, $category3]);
        $article1->tags()->saveMany([$tag1, $tag2]);


        $article2 = Article::create([
            'caption' => 'Topic - 2 AFF Cup 2022: Đội tuyển Việt Nam không phải là hạt giống số một?',
            'author' => 'An An',
            'detail' => '(Dân trí) - Sáng 10/8, Liên đoàn bóng đá Đông Nam Á (AFF) chính thức công bố kế hoạch tổ chức Lễ bốc thăm chia bảng và xếp lịch thi đấu giải vô địch bóng đá Đông Nam Á 2022 (AFF Cup 2022).',
            'image' => 'https://icdn.dantri.com.vn/thumb_w/680/2022/08/10/thailand-crop-1660106953595.jpeg',
        ]);

        $article2->categories()->saveMany([$category5]);
        $article2->tags()->saveMany([$tag6, $tag4]);


        $article3 = Article::create([
            'caption' => 'Topic - 3 NHỮNG THÁCH THỨC LÀM KHÓ GIẤC MƠ TRỞ LẠI "GHẾ NÓNG" CỦA ÔNG TRUMP',
            'author' => 'Tùng Nguyễn',
            'detail' => 'Tối 8/8, một sự kiện chấn động chính trường Mỹ đã xảy ra khi hàng chục đặc vụ FBI tổ chức cuộc đột kích và khám xét tại dinh thự Mar-a-Lago của cựu Tổng thống Donald Trump.',
            'image' => 'https://icdn.dantri.com.vn/2022/08/10/220207-donald-trump-ew-408p-11c8c7-crop-1660070047356.jpeg',
        ]);

        $article3->categories()->saveMany([$category1]);
        $article3->tags()->saveMany([$tag1, $tag5]);
    }
}
