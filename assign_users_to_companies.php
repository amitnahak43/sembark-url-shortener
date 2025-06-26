<?php

use App\Models\User;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// ✅ Assign a specific user to a company
$user = User::find(1);
if ($user) {
    $user->company_id = 1;
    $user->save();
    echo "User ID 1 assigned to Company ID 1\n";
}

// ✅ Assign all users to companies (alternate between company_id 1 and 2)
User::each(function ($user, $index) {
    $companyId = ($index % 2) + 1;
    $user->company_id = $companyId;
    $user->save();
    echo "User ID {$user->id} assigned to Company ID {$companyId}\n";
});
