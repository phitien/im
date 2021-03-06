<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCatDetailsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (! Schema::connection ( 'app' )->hasTable ( 'cat_details' ))
			Schema::connection ( 'app' )->create ( 'cat_details', function (Blueprint $table) {
				$table->increments ( 'id' );
				$table->integer ( 'parent_id' )->unsigned ()->nullable ();
				$table->foreign ( 'parent_id' )->references ( 'id' )->on ( 'cats' )->onDelete ( 'cascade' );
				//
				$table->integer ( 'location_id' )->unsigned ();
				//
				$table->boolean ( 'active' )->nullable ()->default ( 0 );
				//
				$table->string ( 'name' );
				$table->string ( 'title' )->nullable ();
				$table->text ( 'description' )->nullable ();
				$table->text ( 'avatar' )->nullable ();
				$table->text ( 'cover' )->nullable ();
				//
				$table->text ( 'tags' )->nullable ();
				$table->text ( 'options' )->nullable ();
				//
				$table->integer ( 'bits' )->nullable ()->default ( 0 );
				//
				$table->timestamps ();
				$table->softDeletes ();
				//
				$table->unique ( [ 
						'parent_id',
						'location_id',
						'name' 
				] );
				//
				$table->index ( [ 
						'parent_id',
						'location_id',
						'name' 
				], 'cat_detail_search_index' );
			} );
		//
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// Schema::connection ( 'app' )->table ( 'cat_details', function (Blueprint $table) {
		// $table->dropForeign ( [
		// 'parent_id'
		// ] );
		// $table->dropIndex ( 'cat_detail_search_index' );
		// } );
		// Schema::connection ( 'app' )->dropIfExists ( 'cat_details' );
	}
}
