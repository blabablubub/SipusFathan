<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateSipusTables extends Migration
{
    public function up()
    {
        // 1. USERS
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'petugas'],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users', true, ['ENGINE' => 'InnoDB']);
        // 2. CATEGORIES
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('categories', true, ['ENGINE' => 'InnoDB']);
        // 3. BOOKS
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'category_id' => ['type' => 'INT', 'unsigned' => true],
            'code' => ['type' => 'VARCHAR', 'constraint' => 30],
            'title' => ['type' => 'VARCHAR', 'constraint' => 200],
            'author' => ['type' => 'VARCHAR', 'constraint' => 150],
            'publisher' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'published_year' => ['type' => 'YEAR', 'null' => true],
            'stock_total' => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'stock_available' => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->addKey('category_id');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('books', true, ['ENGINE' => 'InnoDB']);
        // 4. MEMBERS
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'member_code' => ['type' => 'VARCHAR', 'constraint' => 30],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'class_name' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('member_code');
        $this->forge->addKey('status');
        $this->forge->createTable('members', true, ['ENGINE' => 'InnoDB']);
        // 5. LOANS
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'loan_code' => ['type' => 'VARCHAR', 'constraint' => 30],
            'member_id' => ['type' => 'INT', 'unsigned' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true],
            'loan_date' => ['type' => 'DATE'],
            'due_date' => ['type' => 'DATE'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('loan_code');
        $this->forge->addKey('member_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('member_id', 'members', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('loans', true, ['ENGINE' => 'InnoDB']);
        // 6. LOAN_DETAILS
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'loan_id' => ['type' => 'INT', 'unsigned' => true],
            'book_id' => ['type' => 'INT', 'unsigned' => true],
            'quantity' => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['loan_id', 'book_id']);
        $this->forge->addKey('book_id');
        $this->forge->addForeignKey('loan_id', 'loans', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('book_id', 'books', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('loan_details', true, ['ENGINE' => 'InnoDB']);
        // 7. LOAN_RETURNS
        // Satu detail peminjaman dapat dikembalikan beberapa kali (partial return).
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'loan_detail_id' => ['type' => 'INT', 'unsigned' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true],
            'quantity' => ['type' => 'INT', 'unsigned' => true],
            'returned_at' => ['type' => 'DATETIME'],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('loan_detail_id');
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('loan_detail_id', 'loan_details', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('loan_returns', true, ['ENGINE' => 'InnoDB']);
    }
    public function down()
    {
        // Drop dari tabel anak ke tabel induk karena terdapat foreign key.
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('loan_returns', true);
        $this->forge->dropTable('loan_details', true);
        $this->forge->dropTable('loans', true);
        $this->forge->dropTable('members', true);
        $this->forge->dropTable('books', true);
        $this->forge->dropTable('categories', true);
        $this->forge->dropTable('users', true);
        $this->db->enableForeignKeyChecks();
    }
}