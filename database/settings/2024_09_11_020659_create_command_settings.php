<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add("command.add",[
            "name"=>"add",
            "text"=>"សួស្តី!!! បងសូមស្វាគមន៍មកកាន់ ✨𝗜𝗰𝗵𝗶𝗯𝗮𝗻 𝗕𝘂𝗳𝗳𝗲𝘁✨ ក្រុមការងារយើងខ្ញុំនឹងធ្វើការឆ្លើយតបបង ក្នុងពេលបន្តិចទៀតនេះ​ សូមអរគុណសម្រាប់ការជួយគាំទ្រ🙏",
            "photos"=>[],
        ]);
    }
};
