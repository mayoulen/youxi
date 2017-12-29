<?php

use Illuminate\Http\Request;

Route::post('/file/upload', 'FileController@upload')->name('file_upload');

