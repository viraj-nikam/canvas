<?php
//
//namespace Tests\Unit\Pages\Users;
//
//use Canvas\Models\User;
//use Tests\TestCase;
//use Tests\TestHelper;
//use Tests\CreatesUser;
//use Illuminate\Http\Response;
//use Tests\InteractsWithDatabase;
//use Canvas\Helpers\CanvasHelper;
//
//class UserCreatePageTest extends TestCase
//{
//    use InteractsWithDatabase, TestHelper, CreatesUser;
//
//    /**
//     * Get the successful create message for a user.
//     *
//     * @return string
//     */
//    protected function getCreateMessage()
//    {
//        return trans('canvas::messages.create_success', ['entity' => 'user']);
//    }
//
//    /** @test */
//    public function it_can_press_cancel_to_return_to_the_user_index_page()
//    {
//        // Actions
//        $this->createUser()->actingAs($this->user)
//            ->visit(route('canvas.admin.user.create'))
//            ->click('Cancel')
//
//            // Assertions
//            ->assertResponseStatus(Response::HTTP_OK)
//            ->seePageIs(route('canvas.admin.user.index'))
//            ->see(e('Users'));
//        $this->assertSessionMissing('errors');
//    }
//
//    /** @test */
//    public function it_validates_the_user_create_form()
//    {
//        // Actions
//        $this->createUser()->callRouteAsUser('canvas.admin.user.store', null, ['first_name' => 'foo']);
//
//        // Assertions
//        $this->assertSessionHasErrors();
//    }
//
//    /** @test */
//    public function it_can_create_a_user_and_save_it_to_the_database()
//    {
//        // Actions
//        $this->createUser()->actingAs($this->user)
//            ->visit(route('canvas.admin.user.create'))
//            ->type('foo', 'first_name')
//            ->type('bar', 'last_name')
//            ->type('foo@bar.com', 'email')
//            ->select(1, 'role')
//            ->press('Save')
////dd(User::all());
////             Assertions
//           ->seeInDatabase(CanvasHelper::TABLES['users'], [
//                'first_name'    => 'foo',
//                'last_name'     => 'bar',
////                'display_name'  => 'foo_bar',
//                'email'         => 'foo@bar.com',
//                'role'          => 1
//            ]);
////        dd(User::all());
////            $this->seePageIs(route('canvas.admin.user.index'));
////                $this->see('_new-post', self::getCreateMessage())
////                ->see(e('Users'))
////                ->assertSessionMissing('errors');
//    }
//}
