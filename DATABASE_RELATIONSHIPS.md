# Database Relationships Documentation (Relational Model – Foreign Key Based)

## Overview

This document describes the database structure and model relationships in the **SIMAEL** system using the **relational, foreign-key-based model**. This design follows Laravel’s recommended relationship structure:

* Uses **foreign keys** instead of CSV or denormalized fields.
* Each student belongs to **one squad** through `squad_id`.
* Each squad has **one leader** via `leader_id`.
* Relationships fully utilize Laravel's `belongsTo`, `hasMany`, and eager loading.

This document replaces the previous denormalized NISN-based version.

---

# 1. `students` Table

Stores student information.

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
* **name** – Student name
* **nisn** – National Student Number (unique)
* **major** – Student major
* **password** – Hashed password
* **status** – pending / verified
* **squad_id** – Foreign key referencing `squads.id`

### Relationships

* `Student belongsTo Squad`
* `Student hasMany InviteSquad`
* `Student hasMany Squad (as leader)` through `leadingSquads`

---

# 2. `squads` Table

Stores PKL squad/group information.

```sql
CREATE TABLE squads (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(20) UNIQUE,
    description TEXT NULL,
    company_name VARCHAR(255) NULL,
    company_address VARCHAR(255) NULL,
    leader_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX(leader_id)
);
```

### Fields

* **id** – Primary key
* **name** – Unique squad name
* **description** – Squad description
* **company_name** – Company name
* **company_address** – Company address
* **leader_id** – Foreign key referencing student leader

### Relationships

* `Squad belongsTo Student (leader)`
* `Squad hasMany Students` → members (via `student.squad_id`)
* `Squad hasMany InviteSquad`

---

# 3. `invite_squads` Table

Stores invitations sent to students to join a squad.

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

* **squad_id** – Squad sending the invitation
* **student_id** – Student receiving the invitation

### Relationships

* `InviteSquad belongsTo Squad`
* `InviteSquad belongsTo Student`

---

# 4. Laravel Model Relationships

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

### Notes

* Each student belongs to exactly one squad.
* A student may lead multiple squads.
* A student may receive multiple squad invitations.

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

### Notes

* Leader is a single student.
* Users are all students whose `squad_id` matches this squad.
* Squad may send multiple invitations.

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

# 5. Relationship Diagram

```
┌─────────────────┐       1        ┌─────────────────┐       *        ┌──────────────────┐
│    students     │◄───────────────│      squads     │◄───────────────│  invite_squads   │
├─────────────────┤                ├─────────────────┤                ├──────────────────┤
│ id (PK)         │                │ id (PK)         │                │ id (PK)          │
│ squad_id (FK)   │──────────────► │ leader_id (FK)  │                │ squad_id (FK)    │
│ ...             │                │ ...             │                │ student_id (FK)  │
└─────────────────┘                └─────────────────┘                └──────────────────┘
```

### Summary

* **Student → Squad**: many-to-one
* **Squad → Students**: one-to-many
* **Student → Squad (leader)**: one-to-many
* **Squad → InviteSquad**: one-to-many
* **Student → InviteSquad**: one-to-many

---

# 6. Advantages of the Relational FK Model

* Full compatibility with Laravel's ORM
* Supports eager loading
* No CSV parsing or manual relationship handling
* Strong data integrity using foreign keys
* High performance queries
* Clean and maintainable structure

---

# 7. Development Rules

1. No major structural changes to the relationship model without team approval.
2. Do not store relational data in CSV format.
3. All relationships must use foreign keys.
4. All model changes must go through proper Pull Request review.
5. This document must always reflect the actual database structure.

---

# 8. Version

* **v1.0 — English Version (December 2025)**
