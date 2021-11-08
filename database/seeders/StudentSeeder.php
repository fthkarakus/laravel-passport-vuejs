<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Student::create([
               'name' => 'Tyshawn Johns Sr.',
               'section' => 'İşletme',
               'section_class' => '3',
               'student_number' => '20190345',
           ]);
        Student::create([
                'name' => 'Aditya Elton Douglas',
                'section' => 'İktisat',
                'section_class' => '2',
                'student_number' => '20200593',
            ]);
        Student::create([
                'name' => 'Abraham Kaci',
                'section' => 'Bilgisayar Mühendisliği',
                'section_class' => '4',
                'student_number' => '20180056',
            ]);
        Student::create([
            'name' => 'Edward Abraham',
            'section' => 'İşletme',
            'section_class' => '3',
            'student_number' => '20190346',
        ]);
        Student::create([
            'name' => 'Natasha Elton',
            'section' => 'İktisat',
            'section_class' => '2',
            'student_number' => '20200597',
        ]);
        Student::create([
            'name' => 'Kaci Ernser',
            'section' => 'Bilgisayar Mühendisliği',
            'section_class' => '4',
            'student_number' => '20180146',
        ]);

    }
}
