<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [];
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i++ < 100; $i++) {
            $date = $faker->unixTime('now');
            $data [] = [
                'name' => $faker->catchPhrase,
                'slug' => $faker->slug,
                'content' => $faker->text,
                'created_at' => $faker->date('Y-m-d H:i:s', $date),
                'updated_at' => $faker->date('Y-m-d H:i:s', $date),
            ];
        }

        $this->table('posts')->insert($data)->save();
    }
}
