<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateRolesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (! Schema::connection ( 'im' )->hasTable ( 'roles' ))
			Schema::connection ( 'im' )->create ( 'roles', function (Blueprint $table) {
				$table->increments ( 'id' );
				$table->string ( 'code' )->unique ();
				$table->string ( 'name' );
				$table->string ( 'description' );
			} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
// 		if (Schema::connection ( 'im' )->hasTable ( 'roles' ))
// 			Schema::connection ( 'im' )->dropIfExists ( 'roles' );
	}
}
