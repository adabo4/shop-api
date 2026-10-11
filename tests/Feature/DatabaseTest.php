<?php

use Illuminate\Support\Facades\DB;

it('uses an isolated SQLite database', function () {

    expect(DB::connection()->getDriverName())
        ->toBe('sqlite');

    expect(DB::connection()->getDatabaseName())
        ->toBe(':memory:');
});
