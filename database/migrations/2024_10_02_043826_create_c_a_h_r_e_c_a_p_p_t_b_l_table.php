<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('CA_HRECAPP_TBL', function (Blueprint $table) {
            $table->string('CA_RECAPP_ID')->primary()->comment('primary_key ของการอนุมัติ');
            $table->string('CA_LNREC_ID')->index()->comment('foreign key ของ table CA_RECLN_TBL');
            $table->foreign('CA_LNREC_ID')->references('CA_LNREC_ID')->on('CA_RECLN_TBL');
            $table->integer('CA_RECAPP_LV')->comment('ลำดับอนุมัติ');
            $table->string('CA_RECAPP_SEC')->comment('แผนกที่จะอนุมัติ');
            $table->string('CA_RECAPP_EMPAPP_ID')->comment('ข้อมูลรหัสพนักงานแต่ละแผนก');
            $table->string('CA_EMPID_APPR')->comment('รหัสพนักงานอนุมัติ');
            $table->integer('CA_RECAPP_STD')->comment('สถานะอนุมัติ');
            $table->string('CA_RECAPP_REMARK')->comment('remark  for reject');
            $table->string('CA_RECAPP_LSTDT')->comment('วันและเวลาอนุมัติ');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_a_h_r_e_c_a_p_p_t_b_l');
    }
};
