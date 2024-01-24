<?php

namespace Tests\Feature\Admin;

use App\Profession;
use DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListProfessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_the_professions_list()
    {
        factory(Profession::class)->create(['title' => 'Diseñador']);
        factory(Profession::class)->create(['title' => 'Programador']);
        factory(Profession::class)->create(['title' => 'Administrador']);

        $this->get('profesiones')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Administrador',
                'Diseñador',
                'Programador',
            ]);
    }

    /** @test */
    public function it_displays_default_message_when_no_professions_registered()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Profession::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $response = $this->get('/professions');

        $response->assertStatus(200);

        $response->assertSee('No hay profesiones registradas');
    }

    /** @test */
    public function it_displays_professions_ordered_by_name()
    {
        $zetaProfession = factory(Profession::class)->create(['title' => 'zeta']);
        $alphaProfession = factory(Profession::class)->create(['title' => 'alpha']);
        $gammaProfession = factory(Profession::class)->create(['title' => 'gamma']);

        $response = $this->get('/professions');

        $response->assertStatus(200);

        $response->assertSeeInOrder([$alphaProfession->title, $gammaProfession->title, $zetaProfession->title]);
    }

    /** @test */
    function it_shows_paginated_professions()
    {
        $titles = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];

        foreach ($titles as $title) {
            factory(Profession::class)->create(['title' => $title]);
        }

        $response = $this->get('profesiones');

        $response->assertStatus(200);

        $response->assertSeeInOrder(Profession::orderBy('title')->pluck('title')->slice(0, 10)->all());
        $response->assertSeeInOrder(Profession::orderBy('title')->pluck('title')->slice(10, 2)->all());
    }
}
