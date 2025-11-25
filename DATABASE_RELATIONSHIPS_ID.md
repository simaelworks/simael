# Database Relationships Documentation (Relational Model – FK Based)

## Overview

Dokumentasi ini menjelaskan struktur database dan relasi antar model dalam sistem **SIMAEL** menggunakan **desain lama yang lebih sesuai dengan standar Laravel**, yaitu:

* Menggunakan **foreign key** formal
* Tidak menggunakan CSV di model Squad
* Setiap student hanya memiliki **satu squad** melalui `squad_id`
* Squad memiliki **satu leader** melalui `leader_id`
* Relasi Laravel dapat berjalan optimal dengan `belongsTo`, `hasMany`, `with()`

Dokumentasi ini menggantikan versi sebelumnya (NISN-based denormalized model).

---

# 1. Tabel `students`

Menyimpan informasi siswa.

```sql
CREATE TABLE students (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    nisn VARCHAR(20) UNIQUE,
    major VARCHAR(50),
    password VARCHAR(255),
    status VARCHAR(50),
    squad_id BIGINT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX(squad_id)
);
```

### Fields

* **id** – Primary key
* **name** – Nama siswa
* **nisn** – Nomor Induk Siswa Nasional (unik)
* **major** – Jurusan
* **password** – Password hashed
* **status** – pending / verified
* **squad_id** – Foreign key ke tabel squads

### Relasi

* `Student.belongsTo(Squad)`
* `Student.hasMany(InviteSquad)`
* `Student.hasMany(Squad, as leader)` melalui `leadingSquads`

---

# 2. Tabel `squads`

Menyimpan informasi kelompok PKL.

```sql
CREATE TABLE squads (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(20) UNIQUE,
    description TEXT NULL,
    company_name VARCHAR(255) NULL,
    company_address VARCHAR(255) NULL,
    leader_id BIGINT, -- FK ke students.id
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX(leader_id)
);
```

### Fields

* **id** – Primary key
* **name** – Nama squad, unik
* **description** – Deskripsi squad
* **company_name** – Nama perusahaan
* **company_address** – Alamat perusahaan
* **leader_id** – Student yang menjadi ketua squad

### Relasi

* `Squad.belongsTo(Student, leader)`
* `Squad.hasMany(Student)` → semua member squad
* `Squad.hasMany(InviteSquad)`

---

# 3. Tabel `invite_squads`

Digunakan untuk menyimpan undangan siswa untuk masuk ke suatu squad.

```sql
CREATE TABLE invite_squads (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    squad_id BIGINT,
    student_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX(squad_id),
    INDEX(student_id)
);
```

### Fields

* **squad_id** – Squad yang mengirim invite
* **student_id** – Student yang menerima invite

### Relasi

* `InviteSquad.belongsTo(Squad)`
* `InviteSquad.belongsTo(Student)`

---

# 4. Relasi Antar Model (Laravel)

## Student Model

```php
class Student extends Model
{
    protected $fillable = [
        'name', 'nisn', 'major', 'password', 'status', 'squad_id',
    ];

    public function squad()
    {
        return $this->belongsTo(Squad::class);
    }

    public function invites()
    {
        return $this->hasMany(InviteSquad::class);
    }

    public function leadingSquads()
    {
        return $this->hasMany(Squad::class, 'leader_id');
    }
}
```

### Penjelasan

* **Student → Squad (member)**: FK `squad_id`
* **Student → Squad (leader)**: FK `leader_id`
* **Student → InviteSquad**: satu siswa bisa mendapat banyak undangan

---

## Squad Model

```php
class Squad extends Model
{
    protected $fillable = [
        'name', 'description', 'company_name', 'company_address', 'leader_id'
    ];

    public function leader()
    {
        return $this->belongsTo(Student::class, 'leader_id');
    }

    public function users()
    {
        return $this->hasMany(Student::class);
    }

    public function invites()
    {
        return $this->hasMany(InviteSquad::class);
    }
}
```

### Penjelasan

* **Squad → Leader**: satu ketua
* **Squad → Students**: semua member squad (melalui student.squad_id)
* **Squad → InviteSquad**: undangan yang dikirimkan squad

---

## InviteSquad Model

```php
class InviteSquad extends Model
{
    protected $fillable = [
        'squad_id',
        'student_id'
    ];

    public function squad() {
        return $this->belongsTo(Squad::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
```

---

# 5. Diagram Relasi (FK Model)

```
┌───────────────┐       1        ┌───────────────┐       *        ┌───────────────┐
│    students   │───────────────►│     squads    │◄───────────────│ invite_squads │
├───────────────┤                ├───────────────┤                ├───────────────┤
│ id (PK)       │                │ id (PK)       │                │ id (PK)       │
│ squad_id (FK) │◄───────────────│ leader_id (FK)│                │ squad_id (FK) │
│ ...           │                │ ...           │                │ student_id(FK)│
└───────────────┘                └───────────────┘                └───────────────┘
```

### Summary Relasi

* **Student → Squad**: many-to-one
* **Squad → Students**: one-to-many
* **Student → Squad (leader)**: one-to-many
* **Squad → InviteSquad**: one-to-many
* **Student → InviteSquad**: one-to-many

---

# 6. Keunggulan Desain Lama

* Menggunakan **relasi natural Laravel**
* Mendukung eager loading (`with()`)
* Menghindari CSV parsing
* Data konsisten dengan foreign key
* Query sangat cepat
* Maintenance lebih mudah

---

# 7. Aturan Pengembangan (Development Rules)

1. **Tidak boleh mengubah struktur relasi inti** tanpa persetujuan bersama.
2. **Tidak menggunakan CSV untuk menyimpan relasi**.
3. Seluruh relasi harus menggunakan **foreign key**.
4. Semua perubahan model harus melalui PR dan review.
5. Dokumentasi ini harus selalu mencerminkan struktur database asli.

---

# 8. Versi Dokumen

* **v2.0 — December 2025**: Migrasi kembali ke desain relational FK-based.
