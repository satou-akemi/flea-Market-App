<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class RemovePaymentIdFromOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (Schema::hasColumn('orders', 'payment_id')) {
            $foreignKeyName = $this->getForeignKeyName('orders', 'payment_id');

            Schema::table('orders', function (Blueprint $table) use ($foreignKeyName) {
                if ($foreignKeyName) {
                    $table->dropForeign($foreignKeyName);
                }
                $table->dropColumn('payment_id');
            });
        } else {
            // カラムがなければ何もしない
            info('payment_id column does not exist in orders table.');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
        });
    }

    /**
     * 指定したテーブルの指定カラムの外部キー制約名を取得（MySQL専用）
     *
     * @param string $table
     * @param string $column
     * @return string|null
     */
    protected function getForeignKeyName(string $table, string $column): ?string
    {
        $dbName = DB::getDatabaseName();

        $result = DB::selectOne(
            "SELECT CONSTRAINT_NAME 
             FROM information_schema.KEY_COLUMN_USAGE 
             WHERE TABLE_SCHEMA = ? 
             AND TABLE_NAME = ? 
             AND COLUMN_NAME = ? 
             AND REFERENCED_TABLE_NAME IS NOT NULL",
             [$dbName, $table, $column]
        );

        return $result ? $result->CONSTRAINT_NAME : null;
    }
}
