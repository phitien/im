<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateRoleActionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'role_action', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'role_id' )->unsigned ();
			$table->foreign ( 'role_id' )->references ( 'id' )->on ( 'roles' )->onDelete ( 'cascade' );
			$table->integer ( 'action_id' )->unsigned ();
			$table->foreign ( 'action_id' )->references ( 'id' )->on ( 'actions' )->onDelete ( 'cascade' );
			$table->unique ( [ 
					'role_id',
					'action_id' 
			], 'role_action_unique' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'role_action' );
	}
}