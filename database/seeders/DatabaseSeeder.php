<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // membuat user dengan seeder
        // User::create([
        //     'name' => "Bagoes Arinata",
        //     'email' => "arinata@gmail.com",
        //     'password' => bcrypt('1234')
        // ]);
        
        // User::create([
        //     'name' => "undabi",
        //     'email' => "una@gmail.com",
        //     'password' => bcrypt('1234')
        // ]);

        // membuat user dengan factory
        User::factory(5)->create();

        Category::create([
            'name' => "Web Programig",
            'slug' => "web-programing"
        ]);
        
        Category::create([
            'name' => "Web Design",
            'slug' => "web-design"
        ]);

        Category::create([
            'name' => "Personal",
            'slug' => "personal"
        ]);

        Post::factory(20)->create();

        // Post::create([
        //     'title' => "Judul Pertama",
        //     'slug' => "judul-pertama",
        //     'excerpt' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quo dolorem quidem quasi ullam earum quam eveniet quibusdam itaque accusantium officia, temporibus molestiae cumque architecto obcaecati quia voluptatum tempora laborum minus autem aliquid.",
        //     'body' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quo dolorem quidem quasi ullam earum quam eveniet quibusdam itaque accusantium officia, temporibus molestiae cumque architecto obcaecati quia voluptatum tempora laborum minus autem aliquid. In ducimus repudiandae cumque at, rem quia dignissimos pariatur, accusamus unde, eveniet commodi dolore ex! Deleniti at obcaecati sit nostrum recusandae itaque quidem ipsum, quam accusantium enim quasi, sequi mollitia corrupti cum. Sint eos fugit laudantium quo harum deleniti exercitationem maiores delectus nemo asperiores id saepe, dignissimos inventore, doloremque, quos omnis at quasi minima quibusdam et? Veniam animi ratione ipsa placeat accusantium vel dolores laborum, ipsam perferendis eveniet quam. Minima sequi, error expedita eligendi, velit quisquam temporibus, aspernatur doloremque explicabo omnis nemo consequatur? Provident ex impedit odit et tempora inventore voluptate ad amet dolorum, minus possimus, vero nesciunt, numquam corrupti. Enim, iusto sed? Labore asperiores iusto quod alias itaque dolores necessitatibus aperiam, quae sed, nemo dolor, commodi illo quibusdam eos nobis saepe hic. Soluta, sed aliquid. Veniam veritatis fugiat fuga, rem placeat quos error totam id beatae ullam, reprehenderit laboriosam ab soluta! Doloremque, laboriosam repudiandae est, ipsum ducimus qui quasi perferendis laborum veritatis tempora aperiam sunt dicta dolorem expedita amet maxime exercitationem iusto odio possimus a recusandae!",
        //     'category_id' => 1,
        //     'user_id' => 1
        // ]);
        
        // Post::create([
        //     'title' => "Judul kedua",
        //     'slug' => "judul-kedua",
        //     'excerpt' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quo dolorem quidem quasi ullam earum quam eveniet quibusdam itaque accusantium officia, temporibus molestiae cumque architecto obcaecati quia voluptatum tempora laborum minus autem aliquid.",
        //     'body' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quo dolorem quidem quasi ullam earum quam eveniet quibusdam itaque accusantium officia, temporibus molestiae cumque architecto obcaecati quia voluptatum tempora laborum minus autem aliquid. In ducimus repudiandae cumque at, rem quia dignissimos pariatur, accusamus unde, eveniet commodi dolore ex! Deleniti at obcaecati sit nostrum recusandae itaque quidem ipsum, quam accusantium enim quasi, sequi mollitia corrupti cum. Sint eos fugit laudantium quo harum deleniti exercitationem maiores delectus nemo asperiores id saepe, Doloremque, laboriosam repudiandae est, ipsum ducimus qui quasi perferendis laborum veritatis tempora aperiam sunt dicta dolorem expedita amet maxime exercitationem iusto odio possimus a recusandae!",
        //     'category_id' => 1,
        //     'user_id' => 1
        // ]);
        
        // Post::create([
        //     'title' => "Judul Ketiga",
        //     'slug' => "judul-ketiga",
        //     'excerpt' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quo dolorem quidem quasi ullam earum quam eveniet quibusdam itaque accusantium officia, temporibus molestiae cumque architecto obcaecati quia voluptatum tempora laborum minus autem aliquid.",
        //     'body' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quo dolorem quidem quasi ullam earum quam eveniet quibusdam itaque accusantium officia, temporibus molestiae cumque architecto obcaecati quia voluptatum tempora laborum minus autem aliquid. In ducimus repudiandae cumque at, rem quia dignissimos pariatur, accusamus unde, eveniet commodi dolore ex! Deleniti at obcaecati sit nostrum recusandae itaque quidem ipsum, quam accusantium enim quasi, sequi mollitia corrupti cum. Sint eos fugit laudantium quo harum deleniti exercitationem maiores delectus nemo asperiores id saepe, Doloremque, laboriosam repudiandae est, ipsum ducimus qui quasi perferendis laborum veritatis tempora aperiam sunt dicta dolorem expedita amet maxime exercitationem iusto odio possimus a recusandae!",
        //     'category_id' => 2,
        //     'user_id' => 1
        // ]);
        // Post::create([
        //     'title' => "Judul keempat",
        //     'slug' => "judul-keempat",
        //     'excerpt' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quo dolorem quidem quasi ullam earum quam eveniet quibusdam itaque accusantium officia, temporibus molestiae cumque architecto obcaecati quia voluptatum tempora laborum minus autem aliquid.",
        //     'body' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quo dolorem quidem quasi ullam earum quam eveniet quibusdam itaque accusantium officia, temporibus molestiae cumque architecto obcaecati quia voluptatum tempora laborum minus autem aliquid. In ducimus repudiandae cumque at, rem quia dignissimos pariatur, accusamus unde, eveniet commodi dolore ex! Deleniti at obcaecati sit nostrum recusandae itaque quidem ipsum, quam accusantium enim quasi, sequi mollitia corrupti cum. Sint eos fugit laudantium quo harum deleniti exercitationem maiores delectus nemo asperiores id saepe, Doloremque, laboriosam repudiandae est, ipsum ducimus qui quasi perferendis laborum veritatis tempora aperiam sunt dicta dolorem expedita amet maxime exercitationem iusto odio possimus a recusandae!",
        //     'category_id' => 2,
        //     'user_id' => 1
        // ]);
    }
}
