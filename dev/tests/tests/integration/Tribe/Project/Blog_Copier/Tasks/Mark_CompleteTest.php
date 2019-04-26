<?php

namespace Tribe\Project\Blog_Copier\Tasks;

use Tribe\Project\Blog_Copier\Copy_Manager;
use Tribe\Tests\SquareOneTestCase;

class Mark_CompleteTest extends SquareOneTestCase {

	public function test_publishes_post() {
		$post_id = $this->factory()->post->create( [
			'post_type'   => Copy_Manager::POST_TYPE,
			'post_status' => 'pending',
		] );

		$this->assertEquals( 'pending', get_post_status( $post_id ) );

		$task = new Mark_Complete();
		$task->handle( [
			'post_id' => $post_id,
		] );

		$this->assertEquals( 'publish', get_post_status( $post_id ) );
	}

}