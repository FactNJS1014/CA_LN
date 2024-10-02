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

        Schema::create('CA_CASEACTIVE_TBL', function (Blueprint $table) {
            $table->string('CA_CASE_ID')->primary();
            $table->string('CA_LNREC_ID')->index();
            $table->foreign('CA_LNREC_ID')->references('CA_LNREC_ID')->on('CA_RECLN_TBL');
            $table->string('CA_PROD_CASE')->comment('สาเหตุการเกิด');
            $table->string('CA_PROD_ACTIVE')->comment('การแก้ไข');
            $table->string('CA_CASEREC_EMPID')->comment('รหัสพนักงานแก้ไข');
            $table->string('CA_CASEREC_LSTDT');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_a_c_a_s_e_a_c_t_i_v_e_t_b_l');
    }
};
