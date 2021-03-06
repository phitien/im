<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePasswordResetsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (! Schema::connection ( 'im' )->hasTable ( 'password_resets' ))
			Schema::connection ( 'im' )->create ( 'password_resets', function (Blueprint $table) {
				$table->string ( 'email' )->index ();
				$table->string ( 'token' )->index ();
				$table->timestamp ( 'created_at' );
			} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
// 		if (Schema::connection ( 'im' )->hasTable ( 'password_resets' ))
// 			Schema::connection ( 'im' )->dropIfExists ( 'password_resets' );
	}
}
