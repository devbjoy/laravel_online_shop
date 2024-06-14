<?php 

use App\Models\Categorie;

function getCategory()
{
	return Categorie::orderBy('name','ASC')
									->with('sub_category')
									->where('show_home','Yes')
									->get();
}

?>