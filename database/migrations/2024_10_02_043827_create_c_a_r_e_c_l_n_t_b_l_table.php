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

        Schema::create('CA_RECLN_TBL', function (Blueprint $table) {
            $table->string('CA_LNREC_ID')->primary()->comment('primary_key ของการบันทึก');
            $table->string('CA_DOCS_ID')->comment('หมายเลขเอกสาร');
            $table->date('CA_ISSUE_DATE')->comment('วันที่บันทึก');
            $table->string('CA_PROD_EMPREC')->comment('รหัสพนักงานผู้ที่บันทึก');
            $table->string('CA_PROD_LINE')->comment('Line การผลิต');
            $table->string('CA_PROD_PROCS')->comment('Process การผลิต');
            $table->string('CA_PROD_MDLCD')->comment('Model Code');
            $table->string('CA_PROD_WON')->comment('work order');
            $table->integer('CA_PROD_LOTS')->comment('งานผลิตทั้งหมด');
            $table->string('CA_PROD_PROBM')->comment('หัวข้อปัญหา');
            $table->string('CA_PROD_RANK')->comment('ระดับความรุนแรง');
            $table->time('CA_PROD_TMPBF')->comment('เวลาที่เริ่มต้นเกิด Linecall');
            $table->time('CA_PROD_TMPBL')->comment('เวลาสิ้นสุด linecall');
            $table->string('CA_PROD_INFMR')->comment('ชื่อผู้แจ้ง');
            $table->string('CA_PROD_DTPROB')->comment('Details of Problem');
            $table->integer('CA_PROD_QTY')->comment('จำนวนงานที่ผลิต');
            $table->integer('CA_PROD_ACCLOT')->comment('จำนวนรับผลิตทั้งหมด');
            $table->integer('CA_PROD_NG')->comment('จำนวนงาน NG');
            $table->integer('CA_PROD_RATE')->comment('Rate (%)');
            $table->integer('CA_PROD_RECSTD')->comment('สถานะการบันทึก');
            $table->integer('CA_PROD_LSTD')->comment('สถานะจบ linecall');
            $table->integer('CA_PROD_SENDAPP')->comment('สถานะส่งอนุมัติ');
            $table->bigInteger('CA_PROD_FAXCOMPLETE');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_a_r_e_c_l_n_t_b_l');
    }
};
