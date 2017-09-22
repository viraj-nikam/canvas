<?php
//
//namespace Tests\Unit\Pages\Users;
//
//use Tests\TestCase;
//use Tests\CreatesUser;
//use Tests\InteractsWithDatabase;
//
//class UserIndexPageTest extends TestCase
//{
//    use InteractsWithDatabase, CreatesUser;
//
//    /** @test */
//    public function it_can_refresh_the_user_page()
//    {
//        $this->createUser()->actingAs($this->user)
//            ->visit(route('canvas.admin.user.index'))
//            ->click('Refresh Users');
//        $this->assertSessionMissing('errors');
//        $this->seePageIs(route('canvas.admin.user.index'));
//    }
//
//    /** @test */
//    public function it_can_add_a_user_from_the_user_index_page()
//    {
//        $this->createUser()->actingAs($this->user)
//            ->visit(route('canvas.admin.user.index'))
//            ->click('create-user');
//        $this->assertSessionMissing('errors');
//        $this->seePageIs(route('canvas.admin.user.create'));
//    }
//
//    /** @test */
//    public function it_cannot_access_the_user_index_page_if_user_is_not_an_admin()
//    {
//        $this->createUser(['role' => 0])->actingAs($this->user)->visit(route('canvas.admin.user.index'));
//        $this->seePageIs(route('canvas.admin'));
//        $this->assertSessionMissing('errors');
//    }
//}
