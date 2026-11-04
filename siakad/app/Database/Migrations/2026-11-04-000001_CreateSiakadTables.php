<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiakadTables extends Migration
{
    public function up()
    {
        // users: akun login untuk semua role
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'username'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'role'       => ['type' => 'ENUM', 'constraint' => ['admin', 'dosen', 'mahasiswa']],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users');

        // dosen
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'INT', 'unsigned' => true],
            'nidn'       => ['type' => 'VARCHAR', 'constraint' => 20],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('nidn');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dosen');

        // mahasiswa
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'       => ['type' => 'INT', 'unsigned' => true],
            'nrp'           => ['type' => 'VARCHAR', 'constraint' => 20],
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'angkatan'      => ['type' => 'YEAR'],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'dosen_wali_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'foto'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('nrp');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dosen_wali_id', 'dosen', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('mahasiswa');

        // matakuliah
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 10],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'sks'        => ['type' => 'TINYINT', 'unsigned' => true],
            'semester'   => ['type' => 'TINYINT', 'unsigned' => true],
            'dosen_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('kode');
        $this->forge->addForeignKey('dosen_id', 'dosen', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('matakuliah');

        // krs: matakuliah yang diambil mahasiswa + nilai dari dosen
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'mahasiswa_id'  => ['type' => 'INT', 'unsigned' => true],
            'matakuliah_id' => ['type' => 'INT', 'unsigned' => true],
            'tahun_ajaran'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'nilai'         => ['type' => 'VARCHAR', 'constraint' => 2, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['mahasiswa_id', 'matakuliah_id', 'tahun_ajaran']);
        $this->forge->addForeignKey('mahasiswa_id', 'mahasiswa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('matakuliah_id', 'matakuliah', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('krs');
    }

    public function down()
    {
        foreach (['krs', 'matakuliah', 'mahasiswa', 'dosen', 'users'] as $table) {
            $this->forge->dropTable($table, true);
        }
    }
}
