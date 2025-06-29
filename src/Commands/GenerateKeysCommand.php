<?php

namespace FullEncryption\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class GenerateKeysCommand extends Command
{
    protected $signature = 'full:generate-keys';
    protected $description = 'Génère une clé chiffrée pour tous les utilisateurs sans enckey';

    public function handle(): void
    {
        $users = User::whereNull('enckey')->get();
        $bar = $this->output->createProgressBar(count($users));

        foreach ($users as $user) {
            $key = substr(hash('sha256', strtolower($user->email)), 0, 32);
            $user->enckey = Crypt::encrypt($key);
            $user->save();

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Clés générées pour {$users->count()} utilisateur(s).");
    }
}
